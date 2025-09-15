<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            DepartmentSeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            AcademicDegreeSeeder::class,
            KnowledgeAreaSeeder::class,
            GraduateSeeder::class,
            
        ]);
    }
}
