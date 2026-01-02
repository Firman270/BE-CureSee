<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skin_diseases', function (Blueprint $table) {
            $table->id('disease_id');
            $table->string('disease_name', 150);
            $table->text('description');
            $table->text('recommended_action');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skin_diseases');
    }
};
