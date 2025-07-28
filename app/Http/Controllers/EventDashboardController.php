<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventDashboardController extends Controller
{
    public function show($id)
    {
        $event = Event::with('tickets')->findOrFail($id);

        return view('events.dashboard', compact('event'));
    }
}
