// database/migrations/xxxx_xx_xx_xxxxxx_create_academic_degrees_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academic_degrees', function (Blueprint $table) {
            $table->id();
            $table->text('degree_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_degrees');
    }
};