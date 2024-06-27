<?php

namespace Tests\Unit\Api\Transactions;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_successfully_returns_a_paginated_list(): void
    {
        $perPage = Transaction::make()->getPerPage();

        $user = User::factory()
            ->has(Transaction::factory()->count($perPage + 1))
            ->create();

        $this
            ->get(route('transactions.index', $user))
            ->assertOk()
            ->assertJsonFragment([
                'data' => TransactionResource::collection(
                    $user->transactions()->take($perPage)->get()
                )->resolve(),
            ])
            ->assertJsonStructure([
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'path',
                    'per_page',
                    'to',
                ],
            ]);
    }
}
