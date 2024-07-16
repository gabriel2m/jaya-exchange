<?php

namespace App\Services\ExchangeRatesApi;

use Saloon\Http\Auth\QueryAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class HttpConnector extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $accessKey
    ) {}

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultAuth(): QueryAuthenticator
    {
        return new QueryAuthenticator('access_key', $this->accessKey);
    }

    /**
     * List of real-time exchange rates
     *
     * @param  string[]  $symbols
     */
    public function latestRates(string $base, ?array $symbols = null): array
    {
        return $this->send(new LatestRatesRequest($base, $symbols))->json('rates');
    }
}
