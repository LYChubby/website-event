<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->user_id)
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function store(StoreNotificationRequest $request)
    {
        $this->authorize('create', Notification::class);

        $notification = Notification::create($request->validated());
        return response()->json($notification, 201);
    }

    public function show(Notification $notification)
    {
        return response()->json($notification->load('user'));
    }

    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $this->authorize('update', $notification);

        $notification->update($request->validated());
        return response()->json($notification);
    }

    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);

        $notification->delete();
        return response()->json(null, 204);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return response()->json($notification);
    }
}
