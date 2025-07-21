<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cek apakah user sudah ada
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                // Simpan user baru, redirect ke halaman pilih role
                session([
                    'google_user' => [
                        'id' => $googleUser->getId(),
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                    ]
                ]); // simpan sementara
                return redirect()->route('choose-role');
            }

            Auth::login($user);
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Gagal login dengan Google.');
        }
    }
}
