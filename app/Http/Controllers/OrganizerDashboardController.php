<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerDashboardController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->organizerInfo || !$user->organizerInfo->is_verified) {
            return redirect()->route('organizer.info.form')->with('warning', 'Silakan isi dan verifikasi informasi rekening terlebih dahulu.');
        }

        return view('organizer.dashboard');
    }
}
