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

        // Total pemasukan (credit admin)
        $totalBersih = DB::table('ledgers')
            ->where('user_id', null) // admin
            ->where('type', 'credit')
            ->sum('amount');

        // Ambil daftar organizer + total pendapatan masing-masing
        $organizerList = DB::table('ledgers')
            ->join('users', 'ledgers.user_id', '=', 'users.user_id')
            ->select(
                'users.name as organizer_name',
                DB::raw("SUM(CASE WHEN ledgers.type = 'credit' THEN ledgers.amount ELSE 0 END) as total_credit"),
                DB::raw("SUM(CASE WHEN ledgers.type = 'debit' THEN ledgers.amount ELSE 0 END) as total_debit"),
                DB::raw("SUM(CASE WHEN ledgers.type = 'credit' THEN ledgers.amount ELSE 0 END) - 
                     SUM(CASE WHEN ledgers.type = 'debit' THEN ledgers.amount ELSE 0 END) as saldo")
            )
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
