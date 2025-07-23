<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['category', 'user'])->latest()->get();
        return response()->json($events);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('event_image')) {
            $data['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        $event = Event::create($data);
        return response()->json([
            'message' => 'Event berhasil dibuat',
            'data' => $event
        ], 201);
    }

    public function show($id)
    {
        $event = Event::with(['category', 'user'])->findOrFail($id);
        return response()->json($event);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('event_image')) {
            if ($event->event_image) {
                Storage::disk('public')->delete($event->event_image);
            }
            $data['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        $event->update($data);

        return response()->json([
            'message' => 'Event berhasil diperbarui',
            'data' => $event
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->event_image) {
            Storage::disk('public')->delete($event->event_image);
        }
        $event->delete();

        return response()->json(['message' => 'Event berhasil dihapus']);
    }
}
