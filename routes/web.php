<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    GoogleController,
    CategoryController,
    EventController,
    TicketController,
    FeedbackController,
    NotificationController,
    ParticipantController,
    ProfileController,
    OrganizerInfoController,
    DisbursementController,
    TransactionController,
    CheckoutController,
    XenditWebhookController,
    HomeController,
    HistoryController,
    OrganizerDashboardController,
    EventDashboardController,
    AdminController,
    DisbursementDashboardController,
    UserController,
    EventBrowseController,
    LandingPageController
};

// ========== AUTH & GOOGLE LOGIN ==========
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/choose-role', function () {
    $googleUser = session('google_user');
    if (!$googleUser) return redirect('/');
    return view('auth.choose-role', compact('googleUser'));
})->name('choose-role');

Route::post('/choose-role', function (Request $request) {
    $request->validate(['role' => 'required|in:user,organizer']);
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

    return redirect()->route($user->role === 'organizer' ? 'organizer.dashboard' : 'dashboard');
});

// ========== GENERAL ==========
Route::get('/', [LandingPageController::class, 'index'])->name('welcome');
Route::get('/tiket/{no_invoice}', [HistoryController::class, 'tampilkanTiket']);

// ========== USER DASHBOARD ROUTES ==========
Route::middleware(['auth', 'role:user'])->prefix('dashboard')->group(function () {
    // Main dashboard
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    // Organizer views
    Route::get('/organizer-list', [HomeController::class, 'organizer'])->name('organizer-list');
    Route::get('/organizer-list/{id}/events', [EventController::class, 'eventListView'])
        ->name('event-list');

    // API routes
    Route::prefix('api')->group(function () {
        Route::get('/organizer-list', [UserController::class, 'organizer']);
        Route::get('/organizer-list/{id}/events', [EventController::class, 'getByOrganizer'])
            ->name('event-list.api');
    });
});

Route::middleware(['auth', 'role:user'])->get('/events', [EventBrowseController::class, 'index'])->name('events.index');


// ========== ORGANIZER DASHBOARD ==========
Route::middleware(['auth', 'role:organizer'])->get('/dashboard/organizer', [OrganizerDashboardController::class, 'dashboard'])->name('organizer.dashboard');

// ========== ADMIN DASHBOARD ==========
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

// ========== AUTH MIDDLEWARE GROUP ==========
Route::middleware('auth')->group(function () {

    // === PROFILE ===
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // === CATEGORIES ===
    Route::resource('categories', CategoryController::class);

    // === EVENTS (User & Shared) ===
    Route::get('/events/{id}', [EventController::class, 'detail'])->name('events.show');

    // === TICKETS ===
    Route::resource('tickets', TicketController::class);
    Route::get('/events/{eventId}/tickets', [TicketController::class, 'ticketsByEvent']);

    // === FEEDBACK ===
    Route::resource('feedbacks', FeedbackController::class)->only(['index', 'store', 'show', 'destroy']);

    // === NOTIFICATIONS ===
    Route::resource('notifications', NotificationController::class);
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // === PARTICIPANTS ===
    Route::apiResource('participants', ParticipantController::class);
    Route::post('participants/{id}/checkin', [ParticipantController::class, 'checkIn']);

    // === ORGANIZER INFO ===
    Route::resource('organizer-infos', OrganizerInfoController::class);

    // === TRANSACTIONS & DISBURSEMENTS ===
    Route::resource('transaction', TransactionController::class);
    Route::resource('disbursements', DisbursementController::class);



    // === HISTORY ===
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('index');
        Route::get('/{id}', [HistoryController::class, 'show'])->name('show');
    });

    // === FEEDBACK ===
    Route::resource('feedbacks', FeedbackController::class)->only(['store']);

    // === ORGANIZER ===
    Route::prefix('organizer')->name('organizer.')->middleware('role:organizer')->group(function () {
        Route::get('/check-verification', function () {
            $user = Auth::user();

            if ($user->role !== 'organizer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya organizer yang dapat mengakses fitur ini',
                    'is_verified' => false
                ], 403);
            }

            if (!$user->organizerInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data organizer tidak lengkap',
                    'is_verified' => false
                ], 404);
            }

            return response()->json([
                'success' => true,
                'is_verified' => (bool) $user->organizerInfo->is_verified,
                'organizer_data' => [
                    'id' => $user->organizerInfo->organizer_info_id,
                    'bank_account' => $user->organizerInfo->bank_account_name
                ]
            ]);
        });

        // CRUD Event Organizer
        Route::get('/events', [EventController::class, 'myEvents']);
        Route::post('/events', [EventController::class, 'store']);
        Route::get('/events/{id}', [EventController::class, 'show']);
        Route::put('/events/{id}', [EventController::class, 'update']);
        Route::delete('/events/{id}', [EventController::class, 'destroy']);

        // Dashboard event
        Route::get('/events/{id}/dashboard', [EventDashboardController::class, 'show'])->name('events.dashboard');

        // Info Bank & Verifikasi
        Route::get('/info', [OrganizerInfoController::class, 'create'])->name('info.form');
        Route::post('/info', [OrganizerInfoController::class, 'store'])->name('info.store');
        Route::get('/banks', [OrganizerInfoController::class, 'getBanks'])->name('info.banks');
        Route::post('/verify', [OrganizerInfoController::class, 'verifyAccount'])->name('info.verify');
    });

    // === ADMIN ===
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::get('/organizers-info', [AdminController::class, 'organizers'])->name('organizers');
        Route::get('/events-approval', [AdminController::class, 'eventsApproval'])->name('events-approval');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/disbursement', [DisbursementDashboardController::class, 'index'])->name('disbursement');

        // API Endpoints
        Route::prefix('api')->group(function () {
            Route::get('/stats', [AdminController::class, 'getStats']);
            Route::get('/activities', [AdminController::class, 'getActivities']);

            // Categories API
            Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
            Route::get('/categories/stats', [CategoryController::class, 'stats']);

            // Organizer Verification API
            Route::get('/organizers', [OrganizerInfoController::class, 'index']);
            Route::put('/organizers/{id}/verification', [OrganizerInfoController::class, 'updateVerification']);

            // Events Approval API
            Route::get('/events', [EventController::class, 'pendingEvents']);
            Route::get('/events/stats', [EventController::class, 'stats']);
            Route::put('/events/{event}/approve', [EventController::class, 'approveEvent']);
            Route::put('/events/{event}/reject', [EventController::class, 'rejectEvent']);

            // Users API
            Route::get('/users', [UserController::class, 'index']);
            Route::post('/users', [UserController::class, 'store']);
            Route::put('/users/{user}', [UserController::class, 'update']);
            Route::delete('/users/{user}', [UserController::class, 'destroy']);
        });
    });

    // === CHECKOUT & PAYMENT ===
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/history', [CheckoutController::class, 'success'])->name('history.index');
    Route::get('/payment/failed', [CheckoutController::class, 'failed'])->name('payment.failed');
});

Route::withoutMiddleware(['web', 'csrf'])->post('/webhook/xendit', [XenditWebhookController::class, 'handle']);

// ========== AUTH ROUTES ==========
require __DIR__ . '/auth.php';


// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
// use Illuminate\Http\Request;
// use App\Http\Controllers\{
//     GoogleController,
//     CategoryController,
//     EventController,
//     TicketController,
//     FeedbackController,
//     NotificationController,
//     ParticipantController,
//     ProfileController,
//     OrganizerInfoController,
//     DisbursementController,
//     TransactionController,
//     CheckoutController,
//     XenditWebhookController,
//     HomeController,
//     HistoryController,
//     OrganizerDashboardController,
//     EventDashboardController,
//     AdminController,
//     DisbursementDashboardController,
//     UserController,
//     EventBrowseController
// };

// // ========== AUTH & GOOGLE LOGIN ==========
// Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
// Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route::get('/choose-role', function () {
//     $googleUser = session('google_user');
//     if (!$googleUser) return redirect('/');
//     return view('auth.choose-role', compact('googleUser'));
// })->name('choose-role');

// Route::post('/choose-role', function (Request $request) {
//     $request->validate(['role' => 'required|in:user,organizer']);
//     $googleUser = session('google_user');

//     $user = \App\Models\User::create([
//         'name' => $googleUser['name'],
//         'email' => $googleUser['email'],
//         'google_id' => $googleUser['id'],
//         'role' => $request->role,
//         'password' => bcrypt(Str::random(16)),
//     ]);

//     Auth::login($user);
//     session()->forget('google_user');

//     return redirect()->route($user->role === 'organizer' ? 'organizer.dashboard' : 'dashboard');
// });

// // ========== GENERAL ==========
// Route::get('/', fn() => view('welcome'));
// Route::get('/tiket/{no_invoice}', [HistoryController::class, 'tampilkanTiket']);

// // ========== USER DASHBOARD ROUTES ==========
// Route::middleware(['auth', 'role:user'])->prefix('dashboard')->group(function () {
//     // Main dashboard
//     Route::get('/', [HomeController::class, 'index'])->name('dashboard');

//     // Organizer views
//     Route::get('/organizer-list', [HomeController::class, 'organizer'])->name('organizer-list');
//     Route::get('/organizer-list/{id}/events', [EventController::class, 'eventListView'])
//         ->name('event-list');

//     // API routes
//     Route::prefix('api')->group(function () {
//         Route::get('/organizer-list', [UserController::class, 'organizer']);
//         Route::get('/organizer-list/{id}/events', [EventController::class, 'getByOrganizer'])
//             ->name('event-list.api');
//     });
// });

// Route::middleware(['auth', 'role:user'])->get('/events', [EventBrowseController::class, 'index'])->name('events.index');


// // ========== ORGANIZER DASHBOARD ==========
// Route::middleware(['auth', 'role:organizer'])->get('/dashboard/organizer', [OrganizerDashboardController::class, 'dashboard'])->name('organizer.dashboard');

// // ========== ADMIN DASHBOARD ==========
// Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

// // ========== AUTH MIDDLEWARE GROUP ==========
// Route::middleware('auth')->group(function () {

//     // === PROFILE ===
//     Route::prefix('profile')->name('profile.')->group(function () {
//         Route::get('/', [ProfileController::class, 'edit'])->name('edit');
//         Route::patch('/', [ProfileController::class, 'update'])->name('update');
//         Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
//     });

//     // === CATEGORIES ===
//     Route::resource('categories', CategoryController::class);

//     // === EVENTS (User & Shared) ===
//     Route::get('/events/{id}', [EventController::class, 'detail'])->name('events.show');

//     // === TICKETS ===
//     Route::resource('tickets', TicketController::class);
//     Route::get('/events/{eventId}/tickets', [TicketController::class, 'ticketsByEvent']);

//     // === FEEDBACK ===
//     Route::resource('feedbacks', FeedbackController::class)->only(['index', 'store', 'show', 'destroy']);

//     // === NOTIFICATIONS ===
//     Route::resource('notifications', NotificationController::class);
//     Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

//     // === PARTICIPANTS ===
//     Route::apiResource('participants', ParticipantController::class);
//     Route::post('participants/{id}/checkin', [ParticipantController::class, 'checkIn']);

//     // === ORGANIZER INFO ===
//     Route::resource('organizer-infos', OrganizerInfoController::class);

//     // === TRANSACTIONS & DISBURSEMENTS ===
//     Route::resource('transaction', TransactionController::class);
//     Route::resource('disbursements', DisbursementController::class);

//     // === HISTORY ===
//     Route::prefix('history')->name('history.')->group(function () {
//         Route::get('/', [HistoryController::class, 'index'])->name('index');
//         Route::get('/{id}', [HistoryController::class, 'show'])->name('show');
//     });

//     // === FEEDBACK ===
//     Route::resource('feedbacks', FeedbackController::class)->only(['store']);

//     // === ORGANIZER ===
//     Route::prefix('organizer')->name('organizer.')->middleware('role:organizer')->group(function () {
//         Route::get('/check-verification', function () {
//             $user = Auth::user();

//             if ($user->role !== 'organizer') {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Hanya organizer yang dapat mengakses fitur ini',
//                     'is_verified' => false
//                 ], 403);
//             }

//             if (!$user->organizerInfo) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Data organizer tidak lengkap',
//                     'is_verified' => false
//                 ], 404);
//             }

//             return response()->json([
//                 'success' => true,
//                 'is_verified' => (bool) $user->organizerInfo->is_verified,
//                 'organizer_data' => [
//                     'id' => $user->organizerInfo->organizer_info_id,
//                     'bank_account' => $user->organizerInfo->bank_account_name
//                 ]
//             ]);
//         });

//         // CRUD Event Organizer
//         Route::get('/events', [EventController::class, 'myEvents']);
//         Route::post('/events', [EventController::class, 'store']);
//         Route::get('/events/{id}', [EventController::class, 'show']);
//         Route::put('/events/{id}', [EventController::class, 'update']);
//         Route::delete('/events/{id}', [EventController::class, 'destroy']);

//         // Dashboard event
//         Route::get('/events/{id}/dashboard', [EventDashboardController::class, 'show'])->name('events.dashboard');

//         // Info Bank & Verifikasi
//         Route::get('/info', [OrganizerInfoController::class, 'create'])->name('info.form');
//         Route::post('/info', [OrganizerInfoController::class, 'store'])->name('info.store');
//         Route::get('/banks', [OrganizerInfoController::class, 'getBanks'])->name('info.banks');
//         Route::post('/verify', [OrganizerInfoController::class, 'verifyAccount'])->name('info.verify');
//     });

//     // === ADMIN ===
//     Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
//         Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
//         Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
//         Route::get('/organizers-info', [AdminController::class, 'organizers'])->name('organizers');
//         Route::get('/events-approval', [AdminController::class, 'eventsApproval'])->name('events-approval');
//         Route::get('/users', [AdminController::class, 'users'])->name('users');
//         Route::get('/disbursement', [DisbursementDashboardController::class, 'index'])->name('disbursement');

//         // API Endpoints
//         Route::prefix('api')->group(function () {
//             Route::get('/stats', [AdminController::class, 'getStats']);
//             Route::get('/activities', [AdminController::class, 'getActivities']);

//             // Categories API
//             Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
//             Route::get('/categories/stats', [CategoryController::class, 'stats']);

//             // Organizer Verification API
//             Route::get('/organizers', [OrganizerInfoController::class, 'index']);
//             Route::put('/organizers/{id}/verification', [OrganizerInfoController::class, 'updateVerification']);

//             // Events Approval API
//             Route::get('/events', [EventController::class, 'pendingEvents']);
//             Route::get('/events/stats', [EventController::class, 'stats']);
//             Route::put('/events/{event}/approve', [EventController::class, 'approveEvent']);
//             Route::put('/events/{event}/reject', [EventController::class, 'rejectEvent']);

//             // Users API
//             Route::get('/users', [UserController::class, 'index']);
//             Route::post('/users', [UserController::class, 'store']);
//             Route::put('/users/{user}', [UserController::class, 'update']);
//             Route::delete('/users/{user}', [UserController::class, 'destroy']);
//         });
//     });

//     // === CHECKOUT & PAYMENT ===
//     Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
//     Route::get('/history', [CheckoutController::class, 'success'])->name('history.index');
//     Route::get('/payment/failed', [CheckoutController::class, 'failed'])->name('payment.failed');
// });

// Route::withoutMiddleware(['web', 'csrf'])->post('/webhook/xendit', [XenditWebhookController::class, 'handle']);

// // ========== AUTH ROUTES ==========
// require __DIR__ . '/auth.php';
