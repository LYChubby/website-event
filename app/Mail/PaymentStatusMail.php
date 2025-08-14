<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $status;

    public function __construct($transaction, $status)
    {
        $this->transaction = $transaction;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Status Pembayaran Event Anda')
                    ->markdown('emails.payment_status');
    }
}
