<?php

namespace App\Services;

use App\Contracts\Services\ExchangeService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ExchangeRatesApiService implements ExchangeService
{
    public function allowedCurrencies(): array
    {
        return [
            'AED',
            'AFN',
            'ALL',
            'AMD',
            'ANG',
            'AOA',
            'ARS',
            'AUD',
            'AWG',
            'AZN',
            'BAM',
            'BBD',
            'BDT',
            'BGN',
            'BHD',
            'BIF',
            'BMD',
            'BND',
            'BOB',
            'BRL',
            'BSD',
            'BTC',
            'BTN',
            'BWP',
            'BYN',
            'BYR',
            'BZD',
            'CAD',
            'CDF',
            'CHF',
            'CLF',
            'CLP',
            'CNY',
            'CNH',
            'COP',
            'CRC',
            'CUC',
            'CUP',
            'CVE',
            'CZK',
            'DJF',
            'DKK',
            'DOP',
            'DZD',
            'EGP',
            'ERN',
            'ETB',
            'EUR',
            'FJD',
            'FKP',
            'GBP',
            'GEL',
            'GGP',
            'GHS',
            'GIP',
            'GMD',
            'GNF',
            'GTQ',
            'GYD',
            'HKD',
            'HNL',
            'HRK',
            'HTG',
            'HUF',
            'IDR',
            'ILS',
            'IMP',
            'INR',
            'IQD',
            'IRR',
            'ISK',
            'JEP',
            'JMD',
            'JOD',
            'JPY',
            'KES',
            'KGS',
            'KHR',
            'KMF',
            'KPW',
            'KRW',
            'KWD',
            'KYD',
            'KZT',
            'LAK',
            'LBP',
            'LKR',
            'LRD',
            'LSL',
            'LTL',
            'LVL',
            'LYD',
            'MAD',
            'MDL',
            'MGA',
            'MKD',
            'MMK',
            'MNT',
            'MOP',
            'MRU',
            'MUR',
            'MVR',
            'MWK',
            'MXN',
            'MYR',
            'MZN',
            'NAD',
            'NGN',
            'NIO',
            'NOK',
            'NPR',
            'NZD',
            'OMR',
            'PAB',
            'PEN',
            'PGK',
            'PHP',
            'PKR',
            'PLN',
            'PYG',
            'QAR',
            'RON',
            'RSD',
            'RUB',
            'RWF',
            'SAR',
            'SBD',
            'SCR',
            'SDG',
            'SEK',
            'SGD',
            'SHP',
            'SLE',
            'SLL',
            'SOS',
            'SRD',
            'STD',
            'SVC',
            'SYP',
            'SZL',
            'THB',
            'TJS',
            'TMT',
            'TND',
            'TOP',
            'TRY',
            'TTD',
            'TWD',
            'TZS',
            'UAH',
            'UGX',
            'USD',
            'UYU',
            'UZS',
            'VEF',
            'VES',
            'VND',
            'VUV',
            'WST',
            'XAF',
            'XAG',
            'XAU',
            'XCD',
            'XDR',
            'XOF',
            'XPF',
            'YER',
            'ZAR',
            'ZMK',
            'ZMW',
            'ZWL',
        ];
    }

    public function rate(string $from, string $to): float
    {
        $rates = $this->latestRates($from, $to);

        return round($rates[$to] / $rates[$from], 13, PHP_ROUND_HALF_EVEN);
    }

    /**
     * List of real-time exchange rates
     *
     * @return array<string, float>
     *
     * @throws RequestException
     */
    protected function latestRates(string ...$currencies): array
    {
        $response = Http::get(str(config('exchange.exchange_rates_api.base_url'))->finish('/')->append('latest'), [
            'access_key' => config('exchange.exchange_rates_api.access_key'),
            'base' => config('exchange.exchange_rates_api.base_currency'),
            'symbols' => implode(',', $currencies) ?: null,
        ]);

        if (! $response->json('success')) {
            throw new RequestException($response);
        }

        return $response->json('rates');
    }
}
