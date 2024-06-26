<?php

namespace App\Providers;

use App\Contracts\Services\ExchangeService;
use App\Services\ExchangeRatesApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(ExchangeService::class, ExchangeRatesApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
