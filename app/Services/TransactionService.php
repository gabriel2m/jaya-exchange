<?php

namespace App\Services;

use App\Contracts\Services\ExchangeService;
use App\Contracts\Services\TransactionService as TransactionServiceContract;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceContract
{
    public function create(array $attrs): Transaction
    {
        return DB::transaction(function () use ($attrs) {
            extract($attrs);

            $attrs['rate'] = app(ExchangeService::class)->rate($from, $to);

            User::firstOrCreate(['id' => $user_id]);

            return Transaction::create($attrs);
        });
    }
}
