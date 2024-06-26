<?php

return [
    'exchange_rates_api' => [
        'base_url' => 'http://api.exchangeratesapi.io',
        'base_currency' => 'EUR',
        'access_key' => env('EXCHANGE_RATES_API_ACCESS_KEY') ?? '7ac244491ec7e2f444ebc0354a8eb73e',
    ],
];
