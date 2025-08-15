<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Event;
use App\Notifications\PaymentStatusNotification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentStatusNotificationTest extends TestCase
{
    public function test_via_returns_expected_channels()
    {
        $transaction = Transaction::factory()->make();
        $notification = new PaymentStatusNotification($transaction);

        $this->assertEquals(['mail', 'database'], $notification->via(new User()));
    }

    public function test_to_mail_returns_mail_message()
    {
        $user = User::factory()->make(['name' => 'Test User']);
        $event = Event::factory()->make(['name' => 'Test Event']);

        $transaction = Transaction::factory()->make([
            'no_invoice' => 'INV-123',
            'total_price' => 50000,
            'status_pembayaran' => 'success'
        ]);

        // Pasang relasi event secara manual
        $transaction->setRelation('event', $event);

        $notification = new PaymentStatusNotification($transaction);
        $mailMessage = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertStringContainsString('INV-123', implode(' ', $mailMessage->introLines));
    }


    public function test_to_database_returns_expected_array()
    {
        $event = Event::factory()->make(['name' => 'Test Event']);
        $transaction = Transaction::factory()->make([
            'transaction_id' => 1,
            'no_invoice' => 'INV-999',
            'status_pembayaran' => 'pending',
            'event' => $event,
            'total_price' => 150000
        ]);

        $notification = new PaymentStatusNotification($transaction);
        $data = $notification->toDatabase(new User());

        $this->assertArrayHasKey('transaction_id', $data);
        $this->assertEquals('INV-999', $data['no_invoice']);
    }
}
