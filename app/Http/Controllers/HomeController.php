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
        $query = Event::query()->with('category', 'organizer');
        $today = Carbon::today();
        $oneMonthLater = $today->copy()->addMonth();

        // Featured Events
        $featuredEvents = Event::with(['category', 'organizer'])
            ->where('status_approval', 'approved')
            ->whereBetween('start_date', [$today, $oneMonthLater])
            ->orderBy('start_date', 'asc') // Urutkan dari tanggal terdekat
            ->take(8)
            ->get();

        // Ambil kategori jika ada
        $kategoriId = $request->kategori;

        // Filtered Events - Base query
        $filterQuery = Event::with(['category', 'organizer'])
            ->where('status_approval', 'approved')
            ->where('start_date', '>=', $today)
            ->orderBy('start_date', 'asc');

        if (!empty($kategoriId) && $kategoriId !== 'all') {
            $filterQuery->where('category_id', $kategoriId);
        }

        $filteredEvents = $filterQuery->latest()->paginate(12);

        $categories = Category::all();

        return view('dashboard', [
            'featuredEvents' => $featuredEvents,
            'filteredEvents' => $filteredEvents,
            'categories' => $categories,
            'currentCategory' => $kategoriId ?? 'all'
        ]);
    }

    public function categoryEvents(Request $request)
    {
        $categoryId = $request->query('category');

        $events = Event::with('category', 'organizer')
            ->where('status_approval', 'approved')
            ->whereDate('start_date', '>=', now());


        // Tambahkan pengecekan jika bukan 'all'
        if ($categoryId !== 'all') {
            $events->where('category_id', $categoryId);
        }

        return response()->json([
            'success' => true,
            'data' => $events->get()
        ]);
    }
}
