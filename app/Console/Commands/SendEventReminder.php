<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Transaction;
use App\Mail\EventReminderMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendEventReminder extends Command
{
    /**
     * Nama signature command.
     */
    protected $signature = 'event:send-reminder';

    /**
     * Deskripsi command.
     */
    protected $description = 'Kirim email pengingat ke user H-3 sebelum event';

    /**
     * Handle command.
     */
    public function handle()
    {
        $targetDate = Carbon::now()->addDays(3)->toDateString();

        // Ambil event yang dimulai pada H-3
        $events = Event::whereDate('start_date', $targetDate)->get();

        if ($events->isEmpty()) {
            $this->info("Tidak ada event yang dimulai pada {$targetDate}");
            return self::SUCCESS;
        }

        foreach ($events as $event) {
            // Ambil transaksi yang sudah paid & relasi user
            $transactions = Transaction::where('event_id', $event->event_id)
                ->where('status_pembayaran', 'paid')
                ->with('user')
                ->get();

            if ($transactions->isEmpty()) {
                $this->info("Tidak ada peserta berbayar untuk event {$event->title}");
                continue;
            }

            foreach ($transactions as $transaction) {
                $user = $transaction->user;

                if (!$user || !$user->email) {
                    $this->warn("Transaksi {$transaction->transaction_id} tidak punya user/email valid");
                    continue;
                }

                // Kirim email reminder
                Mail::to($user->email)->send(new EventReminderMail($event, $user));

                $this->info("✅ Reminder terkirim ke {$user->email} untuk event {$event->title}");
            }
        }

        return self::SUCCESS;
    }
}
