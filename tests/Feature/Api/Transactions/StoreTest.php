<?php

namespace Tests\Feature\Api\Transactions;

use App\Contracts\Services\ExchangeService;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ExchangeRatesApi\ExchangeRatesApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Saloon\Exceptions\SaloonException;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('invalidData')]
    public function test_needs_valid_data(string $attr, mixed $value): void
    {
        $data = [
            'user_id' => 1,
            'from' => 'USD',
            'amount' => 0.183264,
            'to' => 'BRL',
            $attr => $value,
        ];

        $this
            ->postJson(route('transactions.store'), $data)
            ->assertUnprocessable();

        $this->assertDatabaseEmpty(User::class);
        $this->assertDatabaseEmpty(Transaction::class);
    }

    public static function invalidData(): array
    {
        return [
            'user id empty' => ['user_id', ''],
            'user id char' => ['user_id', 'l'],
            'user id too low' => ['user_id', 0],
            'user id too big' => ['user_id', PHP_INT_MAX + 1],
            'from empty' => ['from', ''],
            'from invalid' => ['from', 'tst'],
            'amount empty' => ['amount', ''],
            'amount too much decimals' => ['amount', 0.12345678901234],
            'amount too low' => ['amount', 0],
            'amount too big' => ['amount', PHP_INT_MAX + 1],
            'to empty' => ['to', ''],
            'to invalid' => ['to', 'tst'],
            'to equals from' => ['to', 'USD'],
        ];
    }

    #[DataProvider('userIdProvider')]
    public function test_successfully_creates_a_transaction(int|callable $user_id): void
    {
        $data = [
            'user_id' => is_callable($user_id) ? $user_id() : $user_id,
            'from' => 'USD',
            'amount' => 0.183264,
            'to' => 'BRL',
        ];

        $response = $this
            ->postJson(route('transactions.store'), $data)
            ->assertCreated();

        $this->assertDatabaseHas(User::class, ['id' => $data['user_id']]);

        $transaction = Transaction::first();

        $response->assertExactJson(
            TransactionResource::make(
                $transaction
            )->resolve()
        );

        foreach ($data as $attr => $value) {
            $this->assertEquals($value, $transaction->$attr);
        }
    }

    public static function userIdProvider(): array
    {
        return [
            'new user' => [1],
            'old user' => [fn () => User::factory()->create()->id],
        ];
    }

    public function test_returns_unavailable_on_http_client_error(): void
    {
        $this->instance(
            ExchangeService::class,
            Mockery::mock(ExchangeRatesApiService::class, function (MockInterface $mock) {
                $mock
                    ->makePartial()
                    ->shouldReceive('rate')
                    ->andThrow(SaloonException::class);
            })
        );

        $this
            ->postJson(route('transactions.store'), [
                'user_id' => 1,
                'from' => 'USD',
                'amount' => 0.183264,
                'to' => 'BRL',
            ])
            ->assertServiceUnavailable();

        $this->assertDatabaseEmpty(User::class);
        $this->assertDatabaseEmpty(Transaction::class);
    }
}
