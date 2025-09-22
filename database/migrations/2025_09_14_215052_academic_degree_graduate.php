// database/migrations/xxxx_xx_xx_xxxxxx_create_academic_degree_graduate_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academic_degree_graduate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graduate_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_degree_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_degree_graduate');
    }
};