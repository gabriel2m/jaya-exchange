<?php

namespace Tests\Unit\Models;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class TransactionResourceTest extends TestCase
{
    public function test_returns_the_correct_data(): void
    {
        $transaction = new Transaction([
            'user_id' => 1,
            'from' => 'USD',
            'amount' => 1.234567,
            'to' => 'BRL',
            'rate' => 5.456601646141238,
        ]);

        $this->assertEquals(
            [
                'id' => null,
                'user_id' => 1,
                'from' => 'USD',
                'amount' => 1.234567,
                'to' => 'BRL',
                'rate' => 5.456601646141238,
                'result' => 6.73654032447165,
                'created_at' => null,
            ],
            TransactionResource::make($transaction)->toArray(mock(Request::class))
        );
    }
}
