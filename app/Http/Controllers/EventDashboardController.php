<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participant;

class EventDashboardController extends Controller
{
    public function show($id)
    {
        // Ambil event beserta tiket
        $event = Event::with('tickets')->findOrFail($id);

        // Hitung total event
        $totalEvents = Event::count();

        // Hitung total tiket untuk event ini
        $totalTickets = $event->tickets->sum('quota');

        // Hitung total pendapatan dari event ini
        // Misalnya: semua participant pada event ini dikalikan harga tiket masing-masing
        // $totalRevenue = Participant::where('event_id', $event->id)
        //     ->with('ticket') // pastikan relasi ticket dimuat
        //     ->get()
        //     ->sum(function ($participant) {
        //         return $participant->ticket->price ?? 0;
        //     });

        $totalRevenue = Participant::where('event_id', $event->id)
            ->with('ticket')
            ->get()
            ->sum(function ($participant) {
                return optional($participant->ticket)->price ?? 0;
            });

        return view('events.dashboard', compact('event', 'totalEvents', 'totalTickets', 'totalRevenue'));
    }
}
