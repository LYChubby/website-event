<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $histories = Transaction::with(['event', 'user'])
            ->where('user_id', $user->user_id)
            ->latest()
            ->get()
            ->map(function ($transaction) {
                return [
                    'transaction_id'     => $transaction->transaction_id,
                    'nama_pembeli'       => $transaction->user->name ?? '-',
                    'nama_event'         => $transaction->event->name_event ?? '-',
                    'tanggal_beli'       => $transaction->created_at,
                    'status_pembayaran'  => $transaction->status_pembayaran ?? 'pending',
                ];
            });

        return view('history.index', compact('histories'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['transactionDetails.ticket', 'event'])
            ->where('transaction_id', $id)
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'transaction_id' => $transaction->transaction_id,
                'event_name' => $transaction->event->name_event ?? '-',
                'tanggal_beli' => $transaction->created_at->format('d M Y'),
                'status_pembayaran' => $transaction->status_pembayaran,
                'no_invoice' => $transaction->no_invoice,
                'details' => $transaction->transactionDetails->map(function ($detail) {
                    return [
                        'ticket_name' => $detail->ticket->jenis_ticket ?? '-',
                        'ticket_code' => $detail->ticket->ticket_code_prefix . '-' . random_int(1000, 9999) . '-' . str_pad($detail->id, 6, '0', STR_PAD_LEFT),
                        'quantity' => $detail->quantity,
                        'price' => $detail->price_per_ticket,
                        'subtotal' => $detail->subtotal,
                    ];
                }),
                'total' => $transaction->total_price,
                'payment_method' => $transaction->payment_method,
            ]
        ]);
    }

    public function tampilkanTiket($no_invoice)
    {
        $transaction = Transaction::with(['transactionDetails.ticket', 'event', 'user'])
            ->where('no_invoice', $no_invoice)
            ->firstOrFail();

        return view('history.tiket', compact('transaction'));
    }
}
