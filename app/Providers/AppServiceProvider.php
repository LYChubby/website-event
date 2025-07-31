<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xendit\Configuration;
use Xendit\Payout\PayoutApi;
use Xendit\Invoice\InvoiceApi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Configuration::setXenditKey(config('services.xendit.secret_key'));

        // Bind service singletons
        $this->app->singleton(PayoutApi::class, fn($app) => new PayoutApi());
        $this->app->singleton(InvoiceApi::class, fn($app) => new InvoiceApi());
    }
}
