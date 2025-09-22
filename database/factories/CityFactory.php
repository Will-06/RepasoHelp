<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'department_id' => Department::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}