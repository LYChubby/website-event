<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Tampilkan daftar riwayat pembelian tiket untuk user login
     */
    public function index()
    {
        $userId = Auth::id();

        $histories = Participant::with(['event', 'ticket'])
            ->where('user_id', $userId)
            ->join('transactions', 'participants.user_id', '=', 'transactions.user_id')
            ->select(
                'participants.nama as nama_pembeli',
                'participants.name_event',
                'transactions.created_at as tanggal_beli',
                'transactions.status_pembayaran',
                'transactions.transaction_id'
            )
            ->groupBy('transactions.transaction_id', 'participants.nama', 'participants.name_event', 'transactions.created_at', 'transactions.status_pembayaran')
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        return view('history.index', compact('histories'));
    }

    /**
     * Tampilkan detail transaksi
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'event', 'transactionDetails'])
            ->where('transaction_id', $id)
            ->firstOrFail();

        $participants = Participant::where('user_id', $transaction->user_id)
            ->where('event_id', $transaction->event_id)
            ->get();

        return view('history.show', [
            'transaction' => $transaction,
            'participants' => $participants,
        ]);
    }
}
