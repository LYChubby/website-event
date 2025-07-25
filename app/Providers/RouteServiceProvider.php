<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->routes(function () {
            // 👇 Prefix `/api` untuk routes/api.php
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            // 👇 Routes web.php default
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
