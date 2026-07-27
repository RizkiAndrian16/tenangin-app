<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        URL::forceRootUrl(config('app.url'));
        Carbon::setLocale('id');
    }

    // public function boot(): void
    // {
    //     // Cek apakah ada header dari Ngrok (X-Forwarded-Host)
    //     if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    //         $scheme = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : 'https';
    //         URL::forceRootUrl($scheme . '://' . $_SERVER['HTTP_X_FORWARDED_HOST']);
    //         URL::forceScheme($scheme);
    //     } else {
    //         // Jika tidak via Ngrok, pakai konfigurasi normal dari .env
    //         URL::forceRootUrl(config('app.url'));
    //     }

    //     Carbon::setLocale('id');
    // }
}
