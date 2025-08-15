<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;

class EventDashboardController extends Controller
{
    public function show($id)
    {
        $event = Event::with('tickets')->findOrFail($id);

        // Hitung total tiket (stok + terjual)
        $totalTickets = $event->tickets->sum(function ($ticket) {
            return $ticket->quantity_available + $ticket->quantity_sold;
        });

        // Hitung stok dan terjual
        $availableTickets = $event->tickets->sum('quantity_available');
        $soldTickets      = $event->tickets->sum('quantity_sold');

        // ✅ Pendapatan konsisten dengan admin & organizer
        $totalRevenue = DB::table('transactions')
            ->where('event_id', $id)
            ->where('status_pembayaran', 'paid')
            ->sum(DB::raw('total_price - (total_price * 0.10)'));

        // Hitung persentase tiket terjual
        $soldPercentage = $totalTickets > 0
            ? round(($soldTickets / $totalTickets) * 100)
            : 0;

        // Tentukan class warna
        $soldPercentageClass = $soldPercentage >= 80
            ? 'text-red-600'
            : 'text-purple-600';

        return view('events.dashboard', compact(
            'event',
            'totalTickets',
            'availableTickets',
            'soldTickets',
            'totalRevenue',
            'soldPercentage',
            'soldPercentageClass'
        ));
    }
}
