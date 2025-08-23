<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $user;
    public $day;

    public function __construct(Event $event, $user, int $day)
    {
        $this->event = $event;
        $this->user = $user;
        $this->day = $day;
    }

    public function build()
    {
        $subject = "Pengingat Event: {$this->event->title}";

        return $this->subject($subject)
            ->markdown('emails.events.reminder');
    }
}
