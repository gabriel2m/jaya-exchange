<?php

namespace App\Providers;

use App\Contracts\Services\ExchangeService;
use App\Services\ExchangeRatesApiService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ExchangeServiceProvider extends ServiceProvider implements DeferrableProvider
{
    protected array $exchanges = [
        'exchange_rates_api' => ExchangeRatesApiService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $exchange = config('exchange.exchange');
        $this->app->singleton(ExchangeService::class, fn () => new $this->exchanges[$exchange](config("exchange.exchanges.$exchange")));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [ExchangeService::class];
    }
}
