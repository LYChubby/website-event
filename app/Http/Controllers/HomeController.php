<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $oneMonthLater = $today->copy()->addMonth();

        // Featured Events
        $featuredEvents = Event::with(['category', 'organizer'])
            ->where('status_approval', 'approved')
            ->whereBetween('start_date', [$today, $oneMonthLater])
            ->latest()
            ->take(8)
            ->get();

        // Filtered Events - Base query
        $filterQuery = Event::with(['category', 'organizer'])
            ->where('status_approval', 'approved')
            ->where('start_date', '>=', $today);

        $currentCategory = 'all';

        // Filter by category jika ada
        if ($request->has('category')) {
            $filterQuery->where('category_id', $request->category);
            $currentCategory = $request->category;
        }

        $filteredEvents = $filterQuery->latest()->paginate(12);

        $categories = Category::all();

        return view('dashboard', [
            'featuredEvents' => $featuredEvents,
            'filteredEvents' => $filteredEvents,
            'categories' => $categories,
            'currentCategory' => $currentCategory
        ]);
    }
}
