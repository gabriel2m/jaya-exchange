<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->mockExchangeRatesApiLatestRates();
    }

    protected function mockExchangeRatesApiLatestRates()
    {
        Http::preventStrayRequests();
        Http::fake([
            str(config('exchange.exchanges.exchange_rates_api.base_url'))->finish('/')->append('latest*')->toString() => fn () => Http::response([
                'success' => true,
                'rates' => [
                    'USD' => 1.071593,
                    'BRL' => 5.841356,
                ],
            ]),
        ]);
    }
}
