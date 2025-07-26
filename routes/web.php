<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;



// Callback setelah login Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/choose-role', function () {
    $googleUser = session('google_user');
    if (!$googleUser)
        return redirect('/');
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

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


// Dashboard untuk Organizer
Route::get('/dashboard/organizer', function () {
    return view('organizer.organizerdashboard');
})->middleware(['auth', 'verified'])->name('organizer.dashboard');

// Dashboard untuk Admin
Route::get('/dashboard/admin', function () {
    return view('admin.admindashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);

    // Route::resource('events', EventController::class);
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::resource('tickets', TicketController::class);
    Route::resource('feedbacks', FeedbackController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ]);

    Route::resource('notifications', NotificationController::class)->only([
        'index',
        'show',
        'store',
        'update',
        'destroy'
    ]);

    // Mark as read (opsional)
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');


    // //purchase endpoint
    // Route::middleware(['auth', 'role:user'])->group(function () {
    //     Route::post('/tickets/{ticket}/purchase', [TicketController::class, 'purchase'])
    //         ->name('tickets.purchase');
    // });





    // Route::get('events', [EventController::class, 'index']);
    // Route::get('events/{event}', [EventController::class, 'show']);

    // Organizer

    Route::get('/organizer/events', [EventController::class, 'myEvents']);
    Route::post('/organizer/events', [EventController::class, 'store']);
    Route::get('/organizer/events/{id}', [EventController::class, 'show']);
    Route::put('/organizer/events/{id}', [EventController::class, 'update']);
    Route::delete('/organizer/events/{id}', [EventController::class, 'destroy']);


    // Admin

    Route::get('/admin/events', [EventController::class, 'adminEvents']);
    Route::get('/admin/events/{id}', [EventController::class, 'show']);
    Route::put('/admin/events/{id}/approve', [EventController::class, 'approveEvent']);
    Route::put('/admin/events/{id}/reject', [EventController::class, 'rejectEvent']);
});







require __DIR__ . '/auth.php';
