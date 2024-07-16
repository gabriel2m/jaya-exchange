<?php

namespace App\Services\ExchangeRatesApi;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * List of real-time exchange rates
 */
class LatestRatesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string[]  $symbols
     */
    public function __construct(
        private readonly string $base,
        private readonly ?array $symbols = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/latest';
    }

    protected function defaultQuery(): array
    {
        return [
            'base' => $this->base,
            'symbols' => implode(',', $this->symbols) ?: null,
        ];
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return ! $response->json('success');
    }
}
