<?php

namespace App\Http\Requests;

use App\Contracts\Services\ExchangeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(ExchangeService $exchangeService): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                'between:1,'.PHP_INT_MAX,
            ],
            'from' => [
                'required',
                Rule::in($exchangeService->allowedCurrencies()),
            ],
            'amount' => [
                'required',
                'decimal:0,13',
                'between:0.000001,'.PHP_INT_MAX,
            ],
            'to' => [
                'required',
                'different:from',
                Rule::in($exchangeService->allowedCurrencies()),
            ],
        ];
    }
}
