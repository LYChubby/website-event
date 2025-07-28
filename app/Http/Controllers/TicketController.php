<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return Ticket::all();
    }

    public function store(StoreTicketRequest $request)
    {
        $event = Event::findOrFail($request->event_id);
        $this->authorize('create', [Ticket::class, $event]);
        $ticket = Ticket::create($request->validated());
        return response()->json($ticket, 201);
    }

    public function show(Ticket $ticket)
    {
        return $ticket;
    }

    public function ticketsByEvent($eventId)
    {
        $event = Event::findOrFail($eventId);
        $tickets = Ticket::where('event_id', $eventId)->get();

        return response()->json([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return response()->json($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(null, 204);
    }
}
