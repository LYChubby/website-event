<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class OrganizerDashboardController extends Controller
{


    public function dashboard()
    {
        $user = Auth::user();
        $user = User::with('OrganizerInfo')->find($user->user_id);



        if (!$user->OrganizerInfo) {
            return redirect()->route('organizer.info.form')
                ->with('warning', 'Silakan isi dan verifikasi informasi rekening terlebih dahulu.');
        }

        return view('organizer.organizerdashboard');
    }
}
