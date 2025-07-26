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

        // Query dasar: hanya event yang sudah disetujui
        $query = Event::with(['category', 'organizer'])
            ->where('status_approval', 'approved')
            ->whereBetween('start_date', [$today, $oneMonthLater]);

        // Filter kategori jika dipilih
        if ($request->has('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        // Filter pencarian jika ada
        if ($request->has('search')) {
            $query->where('name_event', 'like', '%' . $request->search . '%');
        }

        $featuredEvents = $query->latest()->take(4)->get();
        $filteredEvents = $query->latest()->get(); // max 4 untuk ditampilkan
        $categories = Category::all();

        return view('dashboard', compact('featuredEvents', 'filteredEvents', 'categories'));
    }
}
