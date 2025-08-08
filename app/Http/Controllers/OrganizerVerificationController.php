<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrganizerInfo;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizerInfo::with(['user', 'verifier'])
            ->latest();

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = $request->per_page ?? 10;
        $organizers = $query->paginate($perPage);

        return response()->json([
            'data' => $organizers->items(),
            'total' => $organizers->total(),
            'current_page' => $organizers->currentPage(),
        ]);
    }

    public function verify(OrganizerInfo $organizer)
    {
        $organizer->update([
            'is_verified' => true,
            // disbursement_ready akan otomatis true karena di boot()
        ]);

        // Kirim notifikasi ke organizer
        // $organizer->user->notify(new OrganizerVerifiedNotification());

        return response()->json([
            'success' => true,
            'message' => 'Organizer berhasil diverifikasi',
            'data' => $organizer
        ]);
    }

    public function reject(OrganizerInfo $organizer, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $organizer->update([
            'rejection_reason' => $request->rejection_reason
        ]);

        // Kirim notifikasi penolakan
        // $organizer->user->notify(new OrganizerRejectedNotification($request->rejection_reason));

        return response()->json([
            'success' => true,
            'message' => 'Organizer berhasil ditolak'
        ]);
    }
}
