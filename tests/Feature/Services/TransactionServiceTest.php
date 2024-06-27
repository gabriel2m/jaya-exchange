<?php

namespace Tests\Feature\Services;

use App\Contracts\Services\TransactionService;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('userIdProvider')]
    public function test_successfully_creates_a_transaction(int|callable $user_id): void
    {
        $attrs = [
            'user_id' => is_callable($user_id) ? $user_id() : $user_id,
            'from' => 'BRL',
            'amount' => 5.451096,
            'to' => 'USD',
        ];

        /** @var Transaction */
        $transaction = app(TransactionService::class)->create($attrs);

        foreach ($attrs as $attr => $value) {
            $this->assertEquals($value, $transaction->$attr);
        }

        $this->assertDatabaseHas(User::class, ['id' => $transaction->user_id]);
        $this->assertDatabaseHas(Transaction::class, $transaction->makeHidden('created_at', 'updated_at')->toArray());
    }

    public static function userIdProvider(): array
    {
        return [
            'new user' => [1],
            'old user' => [fn () => User::factory()->create()->id],
        ];
    }

    public function test_rollbacks_on_create_error(): void
    {
        try {
            app(TransactionService::class)->create([
                'user_id' => 1,
                'from' => 'BRL',
                'amount' => 5.451096,
            ]);
        } catch (\Throwable $th) {
        }

        $this->assertDatabaseEmpty(User::class);
        $this->assertDatabaseEmpty(Transaction::class);
    }
}
