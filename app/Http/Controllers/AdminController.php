<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\Activity;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function categories()
    {
        return view('admin.categories');
    }

    public function organizers()
    {
        return view('admin.organizers-info');
    }

    public function eventsApproval()
    {
        return view('admin.events-approval');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function getStats()
    {
        return response()->json([
            'categories_count' => Category::count(),
            'approved_events_count' => Event::where('status_approval', 'approved')->count(),
            'pending_events_count' => Event::where('status_approval', 'pending')->count(),
            'users_count' => User::where('role', '!=', 'admin')->count(),
        ]);
    }

    public function getActivities()
    {
        $activities = Activity::latest()->take(10)->get()->map(function ($activity) {
            return [
                'type' => $activity->type,
                'title' => $activity->title,
                'description' => $activity->description,
                'time' => Carbon::parse($activity->created_at)->diffForHumans()
            ];
        });

        return response()->json($activities);
    }
}
