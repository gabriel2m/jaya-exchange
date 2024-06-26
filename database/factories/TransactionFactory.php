<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'from' => fake()->unique()->currencyCode(),
            'amount' => fake()->randomFloat(6, 0.000001, PHP_INT_MAX),
            'to' => fake()->unique()->currencyCode(),
            'rate' => fake()->randomFloat(6, 0.000001, PHP_INT_MAX),
        ];
    }
}
