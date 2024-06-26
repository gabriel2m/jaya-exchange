<?php

namespace Tests\Unit\Models;

use App\Models\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function test_calculates_result_successfully(): void
    {
        $transaction = new Transaction([
            'user_id' => 1,
            'from' => 'USD',
            'amount' => 1.234567,
            'to' => 'BRL',
            'rate' => 5.456601646141238,
        ]);

        $this->assertEquals(6.73654032447165, $transaction->result);
    }
}
