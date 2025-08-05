<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user ditemukan, login langsung
                Auth::login($user);

                // Redirect berdasarkan role
                return match ($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'organizer' => redirect()->route('organizer.dashboard'),
                    default => redirect()->route('dashboard'),
                };
            }

            // Jika user belum ada, simpan info sementara di session dan arahkan ke pilih role
            session([
                'google_user' => [
                    'id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                ]
            ]);

            return redirect()->route('choose-role');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Gagal login dengan Google.');
        }
    }
}
