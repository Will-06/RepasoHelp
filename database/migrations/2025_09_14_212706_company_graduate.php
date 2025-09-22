// database/migrations/xxxx_xx_xx_xxxxxx_create_company_graduate_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('company_graduate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graduate_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->boolean('is_current')->default(false);
            $table->string('company_area', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_graduate');
    }
};