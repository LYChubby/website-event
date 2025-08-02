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
                'details' => $transaction->transactionDetails->map(function ($detail) {
                    return [
                        'ticket_name' => $detail->ticket->jenis_ticket ?? '-',
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
}
