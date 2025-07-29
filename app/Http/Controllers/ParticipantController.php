<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Http\Requests\StoreParticipantRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::with(['user', 'event', 'ticket'])->latest()->get();
        return response()->json($participants);
    }

    public function store(StoreParticipantRequest $request)
    {
        $participant = Participant::create($request->validated());
        return response()->json(['message' => 'Participant created successfully', 'data' => $participant], 201);
    }

    public function show($id)
    {
        $participant = Participant::with(['user', 'event', 'ticket'])->findOrFail($id);
        return response()->json($participant);
    }

    public function update(StoreParticipantRequest $request, $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->update($request->validated());
        return response()->json(['message' => 'Participant updated successfully', 'data' => $participant]);
    }

    public function destroy($id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();
        return response()->json(['message' => 'Participant deleted successfully']);
    }

    // Custom: Check-in
    public function checkIn($id)
    {
        $participant = Participant::findOrFail($id);
        $participant->checkin_at = Carbon::now();
        $participant->save();

        return response()->json(['message' => 'Check-in successful', 'checkin_at' => $participant->checkin_at]);
    }
}