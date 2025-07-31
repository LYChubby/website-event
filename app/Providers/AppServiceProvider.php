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
        $this->app->singleton(Configuration::class, function () {
            $config = Configuration::getDefaultConfiguration()
                ->setApiKey(config('services.xendit.secret_key'));

            return new Configuration($config);
        });

        $this->app->singleton(PayoutApi::class, function ($app) {
            return new PayoutApi($app->make(Configuration::class));
        });

        $this->app->singleton(InvoiceApi::class, function ($app) {
            return new InvoiceApi($app->make(Configuration::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Optional: jika kamu masih ingin set key global
        Configuration::setXenditKey(config('services.xendit.secret_key'));
    }
}
