<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->country(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}