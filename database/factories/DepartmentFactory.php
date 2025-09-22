<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->state(),
            'country_id' => Country::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}