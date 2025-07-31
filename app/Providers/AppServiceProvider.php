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
        // Tidak perlu bind Configuration secara manual — cukup pakai static method
        $this->app->singleton(PayoutApi::class, fn() => new PayoutApi());
        $this->app->singleton(InvoiceApi::class, fn() => new InvoiceApi());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set API Key global untuk Xendit
        Configuration::setXenditKey(config('services.xendit.secret_key'));
    }
}
