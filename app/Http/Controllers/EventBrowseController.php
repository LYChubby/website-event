<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventBrowseController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $oneMonthLater = $today->copy()->addMonth();

        $categoryId = $request->query('category');
        $scope      = $request->query('scope'); // 'featured' | 'upcoming' | null
        $search     = $request->query('q');     // opsional pencarian

        $query = Event::with(['category', 'organizer'])
            ->where('status_approval', 'approved')
            ->orderBy('start_date', 'asc');

        // Filter scope
        if ($scope === 'featured') {
            // Event terdekat dalam 1 bulan
            $query->whereBetween('start_date', [$today, $oneMonthLater]);
        } elseif ($scope === 'past') {
            // Event yang sudah selesai (end_date sebelum hari ini)
            $query->where('end_date', '<', $today);
        } else {
            // Default: upcoming
            $query->where('start_date', '>=', $today);
        }

        // Filter kategori
        $activeCategory = null;
        if (!empty($categoryId) && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
            $activeCategory = Category::find($categoryId);
        }

        // Optional: search by name
        if (!empty($search)) {
            $query->where('name_event', 'like', "%{$search}%");
        }

        $events = $query->paginate(12)->withQueryString();

        // Untuk sidebar / filter di halaman index
        $categories = Category::orderBy('name')->get();

        // Judul dinamis
        if ($scope === 'featured') {
            $pageTitle = 'Featured Events (1 bulan ke depan)';
        } elseif ($scope === 'past') {
            $pageTitle = 'Event Selesai';
        } elseif ($activeCategory) {
            $pageTitle = 'Kategori: ' . $activeCategory->name;
        } else {
            $pageTitle = 'Event Mendatang';
        }

        return view('events.index', compact(
            'events',
            'categories',
            'activeCategory',
            'categoryId',
            'scope',
            'search',
            'pageTitle',
            'today',
            'oneMonthLater'
        ));
    }
}
