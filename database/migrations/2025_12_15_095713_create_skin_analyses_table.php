<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skin_analyses', function (Blueprint $table) {
    $table->id('analyses_id');

    // user
    $table->foreignId('user_id')
          ->constrained('users')
          ->cascadeOnDelete();

    // disease
    $table->foreignId('disease_id')
          ->nullable()
          ->constrained('skindiseases', 'disease_id')
          ->nullOnDelete();

    $table->string('image_url');
    $table->text('result_text')->nullable();
    $table->double('confidence_score')->nullable();

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('skin_analyses');
    }
};
