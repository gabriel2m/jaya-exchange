<?php

namespace App\Contracts\Services;

interface ExchangeService
{
    public function __construct(array $config);

    /**
     * List of supported currency codes
     *
     * @return string[]
     */
    public function allowedCurrencies(): array;

    /**
     * Rate between $from and $to
     *
     * @param  string  $from  three letter currency code
     * @param  string  $to  three letter currency code
     */
    public function rate(string $from, string $to): float;
}
