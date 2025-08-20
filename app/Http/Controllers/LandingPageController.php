<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index()
    {
        // Event yang sudah selesai
        $eventTerselenggara = Event::where('end_date', '<', Carbon::now())->count();

        // Peserta aktif (role = user, status = aktif)
        $pesertaAktif = User::where('role', 'user')
            ->where('status', 'aktif')
            ->count();

        // Organizer terpercaya (role = organizer, status = aktif)
        $organizerTerpercaya = User::where('role', 'organizer')
            ->where('status', 'aktif')
            ->count();

        // Kepuasan pengguna (ambil rata-rata rating feedback)
        $kepuasanPengguna = Feedback::avg('rating');
        $kepuasanPengguna = $kepuasanPengguna ? round($kepuasanPengguna * 20) : 0;
        // misal rating 1–5 dikonversi ke %

        // Ambil 4 kategori populer berdasarkan jumlah event
        $kategoriPopuler = Category::withCount('events')
            ->orderByDesc('events_count')
            ->take(4)
            ->get();

        return view('welcome', compact(
            'eventTerselenggara',
            'pesertaAktif',
            'organizerTerpercaya',
            'kepuasanPengguna',
            'kategoriPopuler'
        ));
    }
}
