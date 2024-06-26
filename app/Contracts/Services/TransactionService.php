<?php

namespace App\Contracts\Services;

use App\Models\Transaction;

interface TransactionService
{
    /**
     * Store a newly created Transaction in storage
     */
    public function create(array $attrs): Transaction;
}
