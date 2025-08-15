<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Kirim ke email & simpan di database
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Status Pembayaran Event: ' . $this->transaction->event->name)
            ->greeting('Halo ' . $notifiable->name)
            ->line('Nomor Invoice: ' . $this->transaction->no_invoice)
            ->line('Total: Rp' . number_format($this->transaction->total_price, 0, ',', '.'))
            ->line('Status Pembayaran: ' . ucfirst($this->transaction->status_pembayaran))
            ->action('Lihat Detail Transaksi', url('/transactions/' . $this->transaction->transaction_id))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->transaction_id,
            'no_invoice' => $this->transaction->no_invoice,
            'status_pembayaran' => $this->transaction->status_pembayaran,
            'event_name' => $this->transaction->event->name ?? null,
            'total_price' => $this->transaction->total_price
        ];
    }
}
