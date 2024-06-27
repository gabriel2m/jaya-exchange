<?php

namespace Tests\Feature\Services;

use App\Contracts\Services\ExchangeService;
use Tests\TestCase;

class ExchangeServiceTest extends TestCase
{
    public function test_has_valid_allowed_currencies(): void
    {
        $allowedCurrencies = app(ExchangeService::class)->allowedCurrencies();
        $this->assertIsArray($allowedCurrencies);
        foreach ($allowedCurrencies as $currency) {
            $this->assertMatchesRegularExpression('/[A-Z]{3}/', $currency);
        }
    }

    public function test_calculates_rate_successfully(): void
    {
        $this->assertEquals(5.4510957051791, app(ExchangeService::class)->rate(from: 'USD', to: 'BRL'));
    }
}
