<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Participant;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class HistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat pembelian tiket untuk user yang login.
     */
    public function index()
    {
        $user = Auth::user();

        $query = Participant::with(['event', 'ticket'])
            ->where('user_id', $user->id)
            ->join('transactions', 'participants.user_id', '=', 'transactions.user_id')
            ->select(
                'participants.nama as nama_pembeli',
                'participants.name_event',
                'transactions.created_at as tanggal_beli',
                'transactions.status_pembayaran',
                'transactions.transaction_id'
            )
            ->groupBy(
                'transactions.transaction_id',
                'participants.nama',
                'participants.name_event',
                'transactions.created_at',
                'transactions.status_pembayaran'
            )
            ->orderBy('transactions.created_at', 'desc');

        $riwayat = $query->get()->map(function ($item) {
            return [
                'transaction_id' => $item->transaction_id,
                'nama_pembeli' => $item->nama_pembeli,
                'nama_event' => $item->name_event,
                'status_pembayaran' => $item->status_pembayaran,
                'tanggal_beli' => $item->tanggal_beli,
            ];
        });

        return response()->json($riwayat);
    }

    /**
     * Menampilkan detail transaksi berdasarkan ID transaksi.
     */
    public function show($id)
    {
        $transaksi = Transaction::with(['user', 'event', 'transactionDetails'])
            ->where('transaction_id', $id)
            ->firstOrFail();

        $peserta = Participant::where('user_id', $transaksi->user_id)
            ->where('event_id', $transaksi->event_id)
            ->get();

        return response()->json([
            'id_transaksi' => $transaksi->transaction_id,
            'nama_user' => $transaksi->user->name ?? '-',
            'event' => $transaksi->event->nama ?? '-',
            'status_pembayaran' => $transaksi->status_pembayaran,
            'tanggal_transaksi' => $transaksi->created_at->toDateTimeString(),
            'peserta' => $peserta->map(function ($p) {
                return [
                    'nama' => $p->nama,
                    'ticket' => $p->ticket->nama ?? '-',
                ];
            }),
            'detail_transaksi' => $transaksi->transactionDetails->map(function ($detail) {
                return [
                    'item' => $detail->item_name,
                    'jumlah' => $detail->quantity,
                    'harga' => $detail->price,
                    'total' => $detail->total,
                ];
            }),
        ]);
    }
}

// namespace App\Http\Controllers;

// use App\Models\Participant;
// use App\Models\Transaction;
// use App\Models\TransactionDetail;
// use Illuminate\Support\Facades\Auth;

// class HistoryController extends Controller
// {
//     /**
//      * Menampilkan daftar riwayat pembelian tiket untuk user yang login.
//      */
//     public function index()
//     {
//         $userId = Auth::id();

//         // Ambil semua transaksi user
//         $transactions = Transaction::where('user_id', $userId)
//             ->with(['event', 'transactionDetails'])
//             ->orderBy('created_at', 'desc')
//             ->get()
//             ->map(function ($transaction) {
//                 // Ambil participant yang berkaitan dengan transaksi ini
//                 $participant = Participant::where('user_id', $transaction->user_id)
//                     ->where('event_id', $transaction->event_id)
//                     ->first();

//                 return [
//                     'transaction_id'   => $transaction->transaction_id,
//                     'nama'             => optional($participant)->nama,
//                     'name_event'       => optional($participant)->name_event,
//                     'tanggal_beli'     => $transaction->created_at->format('Y-m-d H:i'),
//                     'status_pembayaran'=> $transaction->status_pembayaran,
//                 ];
//             });

//         return view('history.index', compact('transactions'));
//     }

//     /**
//      * Menampilkan detail dari transaksi tertentu.
//      */
//     public function show($id)
//     {
//         $transaction = Transaction::with(['transactionDetails', 'event', 'user'])->findOrFail($id);

//         $participant = Participant::where('user_id', $transaction->user_id)
//             ->where('event_id', $transaction->event_id)
//             ->first();

//         $details = $transaction->transactionDetails->map(function ($detail) {
//             return [
//                 'jenis_ticket'     => $detail->jenis_ticket,
//                 'quantity'         => $detail->quantity,
//                 'price_per_ticket' => $detail->price_per_ticket,
//                 'subtotal'         => $detail->subtotal,
//             ];
//         });

//         $data = [
//             'name_event'       => optional($participant)->name_event,
//             'nama_pembeli'     => optional($participant)->nama,
//             'tanggal_pembelian'=> $transaction->created_at->format('Y-m-d H:i'),
//             'metode_pembayaran'=> $transaction->payment_method,
//             'total_bayar'      => $transaction->total_price,
//             'details'          => $details,
//         ];

//         return view('history.show', compact('data'));
//     }
// }


