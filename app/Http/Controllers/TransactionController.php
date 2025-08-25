<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Event;
use App\Models\Notification;
use App\Mail\PaymentStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'event'])->latest()->get();
        return response()->json($transactions);
    }

    public function store(StoreTransactionRequest $request)
    {
        $event = Event::findOrFail($request->event_id);


        //Jika event sudah berakhir, tidak bisa membeli tiket
        if ($event->is_expired) {
            return response()->json([
                'message' => 'Tidak bisa membeli tiket untuk event yang sudah berakhir.'
            ], 403);
        }

        $transaction = Transaction::create($request->validated());

        return response()->json([
            'message' => 'Transaction created successfully',
            'data' => $transaction
        ], 201);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'event'])->findOrFail($id);
        return response()->json($transaction);
    }

    public function update(UpdateTransactionRequest $request, $id)
    {
        $transaction = Transaction::with(['user', 'event.user'])->findOrFail($id);
        $transaction->update($request->validated());

        // Jika pembayaran sukses → kirim email + simpan notifikasi
        if (strtolower($transaction->status_pembayaran) === 'success') {
            $this->sendPaymentSuccessNotifications($transaction);
        }

        return response()->json([
            'message' => 'Transaction updated successfully',
            'data' => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully'
        ]);
    }

    private function sendPaymentSuccessNotifications(Transaction $transaction)
    {
        $user = $transaction->user;
        $event = $transaction->event;
        $organizer = $event->user;

        $subject = "Pembayaran Berhasil - {$transaction->no_invoice}";
        $message = "Halo {$user->name},\n\n"
            . "Pembayaran untuk event \"{$event->title}\" telah berhasil.\n"
            . "No Invoice: {$transaction->no_invoice}\n"
            . "Total: Rp" . number_format($transaction->total_price, 0, ',', '.') . "\n\n"
            . "Terima kasih telah menggunakan layanan kami.";

        // Kirim email ke pembeli
        Mail::to($user->email)
            ->send(new PaymentStatusMail($subject, $message));

        // Kirim email ke organizer
        if ($organizer && $organizer->email) {
            Mail::to($organizer->email)
                ->send(new PaymentStatusMail("Tiket Terjual - {$transaction->no_invoice}", $message));
        }

        // Simpan notifikasi pembeli
        Notification::create([
            'user_id' => $user->user_id,
            'title' => 'Pembayaran Berhasil',
            'message' => "Pembayaran untuk event {$event->title} telah berhasil."
        ]);

        // Simpan notifikasi organizer
        if ($organizer) {
            Notification::create([
                'user_id' => $organizer->user_id,
                'title' => 'Tiket Terjual',
                'message' => "{$user->name} telah membeli tiket untuk event {$event->title}."
            ]);
        }
    }
}
