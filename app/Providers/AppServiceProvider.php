<?php

namespace App\Providers;

use App\Contracts\Services\ExchangeService;
use App\Contracts\Services\TransactionService as TransactionServiceContract;
use App\Services\ExchangeRatesApiService;
use App\Services\TransactionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        ExchangeService::class => ExchangeRatesApiService::class,
        TransactionServiceContract::class => TransactionService::class,
    ];

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
        //
    }
}
