<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'cni' => $this->faker->unique()->numerify('CNI########'),
            'user_id' => \App\Models\User::factory()->create()->id,
        ];
    }
}
