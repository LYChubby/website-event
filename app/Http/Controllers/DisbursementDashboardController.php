<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DisbursementDashboardController extends Controller
{
    public function index()
    {
        // Ambil total pemasukan (total transaksi paid)
        $totalPemasukan = DB::table('transactions')
            ->where('status_pembayaran', 'paid')
            ->sum('total_price');

        // Hitung fee (misal 10%)
        $totalFee = $totalPemasukan * 0.10;

        // Total Bersih (pemasukan - fee)
        $totalBersih = $totalPemasukan - $totalFee;

        // Ambil daftar organizer + total pendapatan masing-masing
        $organizerList = DB::table('transactions')
            ->join('events', 'transactions.event_id', '=', 'events.event_id')
            ->join('users', 'events.user_id', '=', 'users.user_id')
            ->select(
                'users.name as organizer_name',
                DB::raw('SUM(transactions.total_price) as total_pemasukan'),
                DB::raw('SUM(transactions.total_price) * 0.10 as fee'),
                DB::raw('SUM(transactions.total_price) - (SUM(transactions.total_price) * 0.10) as pendapatan_organizer')
            )
            ->where('transactions.status_pembayaran', 'paid')
            ->groupBy('users.user_id', 'users.name')
            ->get();

        return view('admin.disbursement', [
            'totalPemasukan' => $totalPemasukan,
            'totalFee' => $totalFee,
            'totalBersih' => $totalBersih,
            'organizerList' => $organizerList
        ]);
    }
}
