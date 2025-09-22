<?php

namespace Database\Seeders;

use App\Models\Graduate;
use App\Models\Company;
use App\Models\AcademicDegree;
use App\Models\KnowledgeArea;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GraduateSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create(); 

        $graduates = Graduate::factory()->count(50)->create();
        
        $companies = Company::all();
        $academicDegrees = AcademicDegree::all();
        $knowledgeAreas = KnowledgeArea::all();
        
        // Asignar relaciones muchos a muchos
        $graduates->each(function ($graduate) use ($companies, $academicDegrees, $knowledgeAreas, $faker) {
            // Compañías (1-3 por graduado)
            $graduate->companies()->attach(
                $companies->random(rand(1, 3))->pluck('id')->toArray(),
                [
                    'is_current' => $faker->boolean(),
                    'company_area' => $faker->randomElement(['IT', 'HR', 'Finance', 'Marketing', 'Operations'])
                ]
            );
            
            // Grados académicos (1-2 por graduado)
            $graduate->academicDegrees()->attach(
                $academicDegrees->random(rand(1, 2))->pluck('id')->toArray()
            );
            
            // Áreas de conocimiento (1-3 por graduado)
            $graduate->knowledgeAreas()->attach(
                $knowledgeAreas->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
