<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\EventPolicy;
use App\Models\Event;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Event::class => EventPolicy::class,
    ];


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
