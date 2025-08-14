<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Mail\PaymentStatusMail;
use Illuminate\Support\Facades\View;

class PaymentStatusMailTest extends TestCase
{
    public function test_mail_builds_correctly()
    {
        $transaction = (object)[
            'no_invoice' => 'INV-123',
            'total_price' => 50000
        ];

        $mail = new PaymentStatusMail($transaction, 'success');
        $mail->build();

        $this->assertEquals('Status Pembayaran Event Anda', $mail->build()->subject);
        $this->assertTrue(View::exists('emails.payment_status'));
    }
}
