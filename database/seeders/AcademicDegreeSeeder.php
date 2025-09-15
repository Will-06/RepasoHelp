<?php

namespace Database\Seeders;

use App\Models\AcademicDegree;
use Illuminate\Database\Seeder;

class AcademicDegreeSeeder extends Seeder
{
    public function run(): void
    {
        AcademicDegree::factory()->count(8)->create();
    }
}