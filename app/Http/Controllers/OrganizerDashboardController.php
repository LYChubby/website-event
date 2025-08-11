<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;


class OrganizerDashboardController extends Controller
{

    public function dashboard()
    {
        $authUser = Auth::user();

        // Ambil user + organizer info
        $user = User::with('OrganizerInfo')->find($authUser->user_id);

        if (!$user->OrganizerInfo) {
            return redirect()->route('organizer.info.form')
                ->with('warning', 'Silakan isi dan verifikasi informasi rekening terlebih dahulu.');
        }

        // Total event milik organizer
        $totalEvent = $user->OrganizerInfo->events()->count();

        // Total tiket terjual dan total pendapatan, lewat join tiket ke events milik organizer
        $ticketsQuery = \App\Models\Ticket::query()
            ->whereHas('event', function ($query) use ($authUser) {
                $query->where('user_id', $authUser->user_id);
            });

        // Total tiket terjual
        $totalTickets = $ticketsQuery->sum('quantity_sold');

        // Total revenue = sum(price * quantity_sold)
        $totalRevenue = $ticketsQuery->selectRaw('SUM(price * quantity_sold) as total')
            ->value('total') ?? 0;

        return view('organizer.organizerdashboard', [
            'totalTickets' => $totalTickets,
            'totalEvent' => $totalEvent,
            'totalRevenue' => $totalRevenue,
        ]);
    }
}
