<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionModel>
 */
class TransactionModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'compte_id' => \App\Models\CompteModel::factory(),
            'type' => fake()->randomElement(['debit', 'credit']),
            'montant' => fake()->randomFloat(2, 10, 10000),
            'description' => fake()->sentence(),
        ];
    }
}
