<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class OrganizerDashboardController extends Controller
{
    public function dashboard()
    {
        $authUser = Auth::user();

        // Ambil user + info organizer
        $user = User::with('OrganizerInfo')->find($authUser->user_id);

        if (!$user->OrganizerInfo) {
            return redirect()
                ->route('organizer.info.form')
                ->with('warning', 'Silakan isi dan verifikasi informasi rekening terlebih dahulu.');
        }

        // Total event milik organizer
        $totalEvent = $user->OrganizerInfo->events()->count();

        // ✅ Total pendapatan diambil dari ledger
        $ledgerSummary = DB::table('ledgers')
            ->where('user_id', $authUser->user_id)
            ->selectRaw("SUM(CASE WHEN type = 'credit' THEN amount ELSE 0 END) -
                         SUM(CASE WHEN type = 'debit' THEN amount ELSE 0 END) as saldo")
            ->first();

        $totalRevenue = $ledgerSummary->saldo ?? 0;

        // Total tiket terjual dari transaksi paid
        $totalTickets = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.transaction_id')
            ->join('events', 'transactions.event_id', '=', 'events.event_id')
            ->where('events.user_id', $authUser->user_id)
            ->where('transactions.status_pembayaran', 'paid')
            ->sum('transaction_details.quantity');

        return view('organizer.organizerdashboard', [
            'totalTickets' => $totalTickets,
            'totalEvent'   => $totalEvent,
            'totalRevenue' => $totalRevenue,
        ]);
    }
}
