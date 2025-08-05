<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\OrganizerInfo;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();
        $role = $user->role;
        // $credentials = $request->only('email', 'password');
        // // Cek jika request datang dari API (Accept: application/json)
        // if (!Auth::attempt($credentials)) {
        //     return response()->json([
        //         'message'     => 'Login gagal. Email atau password salah.',
        //         'status_code' => 401,
        //     ], 401);
        // }

        // $user  = Auth::user();
        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'access_token' => $token,
        //     'token_type'   => 'Bearer',
        //     'user'         => $user
        // ]);

        // Redirect berdasarkan role
        if ($role === 'organizer') {
            // Cek apakah organizer sudah mengisi data rekening
            if (!$user->OrganizerInfo) {
                return redirect()->route('organizer.info.form');
            }
            return redirect()->route('organizer.dashboard');
        }

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'user' => redirect()->route('dashboard'),
            default => redirect('/'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Untuk API: hapus token saja
        if ($request->expectsJson()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully']);
        }

        // Untuk Web: hapus session
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
