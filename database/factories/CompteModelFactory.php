<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompteModel>
 */
class CompteModelFactory extends Factory
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
            "client_id" => \App\Models\ClientModel::factory(),

            "type" => fake()->randomElement(['cheque', 'epargne']),
            "statut" => fake()->randomElement(['actif', 'bloque', 'ferme']),
            "devise" => fake()->currencyCode(),
        ];
    }
}
