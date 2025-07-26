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
        $query = Event::query()->with('category');
        $today = Carbon::today();
        $oneMonthLater = $today->copy()->addMonth();

        // Featured Events (tanpa filter)
        $featuredEvents = Event::with(['category'])
            ->where('status_approval', 'approved')
            ->whereBetween('start_date', [$today, $oneMonthLater])
            ->latest()
            ->take(12)
            ->get();

        // Filtered Events - Query dasar
        $filterQuery = Event::with(['category'])
            ->where('status_approval', 'approved')
            ->where('start_date', '>=', $today);

        // Filter kategori
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter pencarian
        if ($request->has('search')) {
            $filterQuery->where('name_event', 'like', '%' . $request->search . '%');
        }

        $filteredEvents = $filterQuery->latest()->paginate(12);

        // Tambahkan appends
        $filteredEvents->appends($request->except('page'));

        $categories = Category::all();

        return view('dashboard', compact('featuredEvents', 'filteredEvents', 'categories', 'request'));
    }
}
