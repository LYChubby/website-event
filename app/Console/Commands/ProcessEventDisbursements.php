<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\OrganizerInfo;
use App\Models\Disbursement;
use Xendit\Configuration;
use Xendit\Disbursements\DisbursementsApi;


class ProcessEventDisbursements extends Command
{
    protected $signature = 'disburse:events';
    protected $description = 'Proses disbursement otomatis untuk event yang sudah selesai dan belum didisburse';

    public function handle()
    {
        Configuration::setXenditKey('XENDIT_API_KEY');

        $disbursementApi = new DisbursementsApi();

        $events = Event::where('status_approval', 'approved')
            ->where('end_date', '<', Carbon::yesterday())
            ->doesntHave('disbursement') // pastikan event belum pernah didisburse
            ->get();

        if ($events->isEmpty()) {
            $this->info('Tidak ada event yang memenuhi syarat untuk disbursement.');
            return;
        }

        foreach ($events as $event) {
            $this->info("Memproses event: {$event->name_event}");

            $total = Transaction::where('event_id', $event->event_id)
                ->where('status_pembayaran', 'paid')
                ->sum('total_price');

            if ($total <= 0) {
                $this->warn("  - Tidak ada pembayaran untuk event ini.");
                continue;
            }

            $organizerInfo = OrganizerInfo::where('user_id', $event->user_id)
                ->where('is_verified', true)
                ->where('disbursement_ready', true)
                ->first();

            if (!$organizerInfo) {
                $this->warn("  - Organizer belum melengkapi atau verifikasi info rekening.");
                continue;
            }

            $platformFee = round($total * 0.10, 2); // contoh fee 10%
            $amountToDisburse = round($total - $platformFee, 2);

            try {
                $xenditResponse = Disbursements::create([
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
                    'external_disbursement_id' => $xenditResponse['id'],
                    'disbursed_at' => now(),
                ]);

                $this->info("  - Disbursement berhasil dikirim: Rp " . number_format($amountToDisburse));
            } catch (\Exception $e) {
                $this->error("  - Gagal mengirim disbursement: " . $e->getMessage());
            }
        }

        $this->info('Proses disbursement selesai.');
    }
}
