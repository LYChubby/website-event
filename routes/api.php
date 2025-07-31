<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\XenditWebhookController;

Route::post('/auth/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = Str::random(60);
    $user->api_token = hash('sha256', $token);
    $user->save();

    return response()->json(['token' => $token]);
});

Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::get('/payment/success', [CheckoutController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed',  [CheckoutController::class, 'failed'])->name('payment.failed');
    Route::post('/webhook/xendit', [XenditWebhookController::class, 'handle']);
});

Route::get('/ping', function () {
    return 'pong';
});
