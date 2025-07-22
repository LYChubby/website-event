<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleController;

Route::get('/auth/google', fn() => Socialite::driver('google')->redirect());

// Callback setelah login Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/choose-role', function () {
    $googleUser = session('google_user');
    if (!$googleUser) return redirect('/');
    return view('auth.choose-role', compact('googleUser'));
})->name('choose-role');

Route::post('/choose-role', function (Request $request) {
    $request->validate([
        'role' => 'required|in:user,organizer',
    ]);

    $googleUser = session('google_user');

    $user = \App\Models\User::create([
        'name' => $googleUser['name'],
        'email' => $googleUser['email'],
        'google_id' => $googleUser['id'],
        'role' => $request->role,
        'password' => bcrypt(Str::random(16)),
    ]);

    Auth::login($user);
    session()->forget('google_user');

    return redirect('/dashboard');
});



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
