<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Disbursement;
use App\Models\OrganizerInfo;
use App\Services\DisbursementService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProcessEventDisbursements extends Command
{
    protected $signature = 'event:process-disbursements';
    protected $description = 'Disburse payment to organizers for completed events (H+1)';

    public function handle()
    {
        $this->info('📦 Memproses disbursement untuk event yang sudah selesai...');

        // Ambil semua event yang selesai H+1, belum pernah didisburse
        $events = Event::where('status_approval', 'approved')
            ->where('end_date', '<', Carbon::now()->subDay()) // H+1
            ->whereDoesntHave('disbursement')
            ->with('user') // organizer
            ->get();

        $disbursementService = new DisbursementService($events);

        foreach ($events as $event) {
            $this->info("🔍 Event: {$event->name_event} (ID: {$event->event_id})");

            $organizerInfo = OrganizerInfo::where('user_id', $event->user_id)
                ->where('is_verified', true)
                ->where('disbursement_ready', true)
                ->first();

            if (!$organizerInfo) {
                $this->warn("  - Organizer belum siap untuk disbursement.");
                continue;
            }

            // Hitung total transaksi yang sukses
            $totalRevenue = $event->transactions()
                ->where('status_pembayaran', 'paid')
                ->sum('total_price');

            if ($totalRevenue <= 0) {
                $this->warn("  - Tidak ada pendapatan dari event ini.");
                continue;
            }

            $platformFee = round($totalRevenue * 0.1); // Contoh 10% fee platform
            $amountToDisburse = $totalRevenue - $platformFee;

            try {
                DB::beginTransaction();

                $xenditResponse = $disbursementService->send([
                    'external_id' => 'disb-event-' . $event->event_id,
                    'bank_code' => $organizerInfo->bank_code,
                    'account_holder_name' => $organizerInfo->bank_account_name,
                    'account_number' => $organizerInfo->bank_account_number,
                    'amount' => $amountToDisburse,
                    'description' => 'Disbursement for event #' . $event->name_event,
                ]);

                Disbursement::create([
                    'event_id' => $event->event_id,
                    'user_id' => $event->user_id,
                    'amount' => $amountToDisburse,
                    'platform_fee' => $platformFee,
                    'status' => $xenditResponse['status'] ?? 'sent',
                    'external_disbursement_id' => $xenditResponse['id'] ?? null,
                    'disbursed_at' => now(),
                ]);

                DB::commit();

                $this->info("  ✅ Disbursement berhasil dikirim: Rp " . number_format($amountToDisburse));
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("  ❌ Gagal mengirim disbursement: " . $e->getMessage());
            }
        }

        $this->info('🎉 Proses selesai.');
    }
}
