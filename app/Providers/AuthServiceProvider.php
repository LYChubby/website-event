<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\EventPolicy;
use App\Models\Event;
use App\Models\Notification;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Event::class => EventPolicy::class,
        Notification::class => NotificationPolicy::class,
    ];


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
