<?php

namespace Database\Seeders;

use App\Models\KnowledgeArea;
use Illuminate\Database\Seeder;

class KnowledgeAreaSeeder extends Seeder
{
    public function run(): void
    {
        KnowledgeArea::factory()->count(10)->create();
    }
}