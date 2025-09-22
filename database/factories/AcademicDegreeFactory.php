<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicDegreeFactory extends Factory
{
    public function definition(): array
    {
        $degrees = ['Bachelor', 'Master', 'PhD', 'Associate', 'Diploma', 'Certificate'];
        
        return [
            'degree_name' => $this->faker->randomElement($degrees) . ' in ' . $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}