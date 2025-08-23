<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Services\NotificationService;

class SendEventReminder extends Command
{
    protected $signature = 'event:send-reminder';
    protected $description = 'Kirim email pengingat ke user H-10, H-7, H-3, H-1, dan Hari H event';

    public function handle(NotificationService $notifier)
    {
        $reminderDays = [10, 7, 3, 1, 0];

        foreach ($reminderDays as $day) {
            $targetDate = now()->addDays($day)->toDateString();

            $events = Event::whereDate('start_date', $targetDate)->get();

            foreach ($events as $event) {
                $transactions = $event->transactions()
                    ->where('status_pembayaran', 'paid')
                    ->with('user')
                    ->get();

                foreach ($transactions as $transaction) {
                    $user = $transaction->user;
                    if (!$user || !$user->email) continue;

                    $notifier->sendEventReminder($event, $user, $day);

                    $this->info("✅ Reminder + Notif H-{$day} terkirim ke {$user->email}");
                }
            }
        }

        return self::SUCCESS;
    }
}
