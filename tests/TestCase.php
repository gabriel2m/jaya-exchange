<?php

namespace Tests;

use App\Services\ExchangeRatesApi\LatestRatesRequest;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Saloon\Config;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->mockExchangeRatesApiLatestRates();
    }

    protected function mockExchangeRatesApiLatestRates()
    {
        Config::preventStrayRequests();
        Saloon::fake([
            LatestRatesRequest::class => MockResponse::make(body: [
                'success' => true,
                'rates' => [
                    'USD' => 1.071593,
                    'BRL' => 5.841356,
                ],
            ]),
        ]);
    }
}
