<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // Hanya user, organizer, admin yang boleh lihat
        if (!in_array($role, ['user', 'organizer', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        $feedbacks = Feedback::with(['user', 'event'])->latest()->get();
        return response()->json($feedbacks);
    }

    public function store(StoreFeedbackRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        if (Auth::user()->role !== 'user') {
            return response()->json(['error' => 'Only users can submit feedback.'], 403);
        }

        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully!',
            'feedback' => [
                'user_name' => Auth::user()->name,
                'rating' => $feedback->rating,
                'comment' => $feedback->comment,
                'created_at' => 'Baru saja'
            ]
        ], 201);
    }

    public function show(Feedback $feedback)
    {
        $role = Auth::user()->role;

        // Semua boleh show
        if (!in_array($role, ['user', 'organizer', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        return response()->json($feedback->load(['user', 'event']));
    }

    public function destroy(Feedback $feedback)
    {
        $role = Auth::user()->role;

        // Hanya organizer boleh hapus
        if ($role !== 'organizer') {
            abort(403, 'Only organizer can delete feedback.');
        }

        $feedback->delete();
        return response()->json(['message' => 'Feedback deleted successfully.']);
    }
}
