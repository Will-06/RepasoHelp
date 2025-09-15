<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KnowledgeAreaFactory extends Factory
{
    public function definition(): array
    {
        $areas = ['Computer Science', 'Engineering', 'Business', 'Medicine', 'Arts', 'Sciences', 'Education'];
        
        return [
            'area_name' => $this->faker->randomElement($areas) . ' - ' . $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
