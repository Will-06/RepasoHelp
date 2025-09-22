<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\City;
use Carbon\Carbon;

class GraduateFactory extends Factory
{
    public function definition(): array
    {
        $graduationYear = $this->faker->numberBetween(2010, 2023);
        $birthDate = Carbon::now()->subYears($this->faker->numberBetween(22, 65));
        
        return [
            'name' => $this->faker->name(),
            'birth_date' => $birthDate,
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'linkedin' => $this->faker->optional()->userName(),
            'facebook_name' => $this->faker->optional()->userName(),
            'facebook_link' => $this->faker->optional()->url(),
            'twitter' => $this->faker->optional()->userName(),
            'graduation_year' => $graduationYear,
            'degree_modality' => $this->faker->randomElement(['On-campus', 'Online', 'Hybrid']),
            'city_id' => City::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}