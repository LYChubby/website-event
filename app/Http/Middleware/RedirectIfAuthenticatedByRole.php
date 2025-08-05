<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'organizer' => !$user->organizerInfo || !$user->organizerInfo->is_verified
                    ? redirect()->route('organizer.info-form')
                    : redirect()->route('organizer.dashboard'),
                'user' => redirect()->route('dashboard'),
                default => redirect('/'),
            };
        }

        return $next($request);
    }
}
