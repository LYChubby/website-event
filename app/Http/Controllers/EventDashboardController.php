<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participant;

class EventDashboardController extends Controller
{
    // controller: EventDashboardController.php
    public function show($id)
    {
        $event = Event::with('tickets')->findOrFail($id);

        $totalTickets = $event->tickets->sum(function ($ticket) {
            return $ticket->quantity_available + $ticket->quantity_sold;
        });

        $availableTickets = $event->tickets->sum('quantity_available');
        $soldTickets = $event->tickets->sum('quantity_sold');

        $totalRevenue = Participant::where('event_id', $id)
            ->whereNotNull('transaction_id') // Hanya yang punya transaction_id
            ->with('ticket')
            ->get()
            ->sum(function ($participant) {
                return ($participant->ticket->price ?? 0) * ($participant->jumlah ?? 1);
            });

        // Hitung persentase sold tiket
        $soldPercentage = $totalTickets > 0 ? round(($soldTickets / $totalTickets) * 100) : 0;

        // Tentukan class warna berdasarkan persentase
        $soldPercentageClass = $soldPercentage >= 80 ? 'text-red-600' : 'text-purple-600';

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
