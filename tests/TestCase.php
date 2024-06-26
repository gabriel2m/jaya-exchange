<?php

namespace Tests;

use App\Contracts\Services\ExchangeService;
use App\Services\ExchangeRatesApiService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->mockExchangeRatesApiLatestRates();
    }

    protected function mockExchangeRatesApiLatestRates()
    {
        $mock = mock(ExchangeRatesApiService::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->allows([
                'latestRates' => [
                    'USD' => 1.071593,
                    'BRL' => 5.841356,
                ],
            ]);

        $this->instance(ExchangeService::class, $mock);
        $this->instance(ExchangeRatesApiService::class, $mock);
    }
}
