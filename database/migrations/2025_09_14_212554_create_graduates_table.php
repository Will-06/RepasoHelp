// database/migrations/xxxx_xx_xx_xxxxxx_create_graduates_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('graduates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55);
            $table->date('birth_date');
            $table->string('phone', 50);
            $table->string('address', 150);
            $table->string('email', 60);
            $table->string('linkedin', 50)->nullable();
            $table->string('facebook_name', 50)->nullable();
            $table->string('facebook_link', 255)->nullable();
            $table->string('twitter', 50)->nullable();
            $table->year('graduation_year');
            $table->text('degree_modality');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('graduates');
    }
};