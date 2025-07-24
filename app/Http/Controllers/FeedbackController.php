<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        // Hanya user, organizer, admin yang boleh lihat
        if (!in_array($role, ['user', 'organizer', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        $feedbacks = Feedback::with(['user', 'event'])->latest()->get();
        return response()->json($feedbacks);
    }

    public function store(StoreFeedbackRequest $request)
    {
        $role = auth()->user()->role;

        // Hanya user biasa yang boleh store
        if ($role !== 'user') {
            abort(403, 'Only users can submit feedback.');
        }

        $feedback = Feedback::create([
            'user_id' => auth()->id(),
            'event_id' => $request->event_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully!',
            'data' => $feedback
        ], 201);
    }

    public function show(Feedback $feedback)
    {
        $role = auth()->user()->role;

        // Semua boleh show
        if (!in_array($role, ['user', 'organizer', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        return response()->json($feedback->load(['user', 'event']));
    }

    public function destroy(Feedback $feedback)
    {
        $role = auth()->user()->role;

        // Hanya admin boleh hapus
        if ($role !== 'admin') {
            abort(403, 'Only admin can delete feedback.');
        }

        $feedback->delete();
        return response()->json(['message' => 'Feedback deleted successfully.']);
    }
}
