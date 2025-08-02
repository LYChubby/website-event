<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

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
                    'status_pembayaran'  => $transaction->status_pembayaran ?? 'unpaid',
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

        return view('history.show', compact('transaction'));
    }
}
