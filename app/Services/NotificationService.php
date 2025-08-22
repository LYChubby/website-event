<?php

namespace App\Services;

use App\Mail\EventReminderMail;
use App\Models\Event;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Kirim email + simpan notifikasi ke DB
     */
    public function sendEventReminder(Event $event, User $user, int $day): void
    {
        // Kirim email
        Mail::to($user->email)->send(new EventReminderMail($event, $user, $day));

        // Simpan notifikasi ke database
        Notification::create([
            'user_id' => $user->user_id,
            'title'   => "Pengingat Event: {$event->title}",
            'message' => $day > 0
                ? "Event {$event->title} akan dimulai dalam {$day} hari lagi pada "
                . Carbon::parse($event->start_date)->translatedFormat('d F Y')
                : "Hari ini adalah Hari-H event {$event->title}! Jangan lupa hadir 🎉",
            'type'    => 'email',
            'is_read' => false,
        ]);
    }
}
