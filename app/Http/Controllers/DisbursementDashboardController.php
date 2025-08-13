<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;

class DisbursementDashboardController extends Controller
{
    public function revenueReport()
    {
        // Ambil semua transaksi sukses
        $transactions = Transaction::where('status_pembayaran', 'paid')->get();

        $totalGross = $transactions->sum('total_price');
        $totalFee = $totalGross * 0.1;
        $totalRevenue = $totalGross - $totalFee;

        // Hitung revenue per organizer
        $organizers = User::where('role', 'organizer')
            ->with(['events.tickets.participants.transaction' => function ($q) {
                $q->where('status_pembayaran', 'paid');
            }])
            ->get()
            ->map(function ($organizer) {
                $totalGross = 0;

                foreach ($organizer->events as $event) {
                    foreach ($event->tickets as $ticket) {
                        foreach ($ticket->participants as $participant) {
                            if ($participant->transaction) {
                                $totalGross += $ticket->price * $participant->quantity;
                            }
                        }
                    }
                }

                return [
                    'id' => $organizer->user_id,
                    'name' => $organizer->name,
                    'email' => $organizer->email,
                    'total_gross' => $totalGross,
                    'total_fee' => $totalGross * 0.1,
                    'total_revenue' => $totalGross * 0.9,
                ];
            })
            ->sortByDesc('total_gross')
            ->values();

        return response()->json([
            'totalGross' => $totalGross,
            'totalFee' => $totalFee,
            'totalRevenue' => $totalRevenue,
            'organizers' => $organizers
        ]);
    }
}
