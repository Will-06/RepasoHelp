// database/migrations/xxxx_xx_xx_xxxxxx_create_knowledge_areas_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('knowledge_areas', function (Blueprint $table) {
            $table->id();
            $table->text('area_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_areas');
    }
};