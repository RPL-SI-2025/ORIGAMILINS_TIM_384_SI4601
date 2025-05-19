<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

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
    \Log::info('MIDTRANS_SERVER_KEY: ' . env('MIDTRANS_SERVER_KEY'));
    \Log::info('MIDTRANS_CLIENT_KEY: ' . env('MIDTRANS_CLIENT_KEY'));
}
}
