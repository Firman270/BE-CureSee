<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // RELASI KE ADMIN (users dengan role = admin)
            $table->unsignedBigInteger('admin_id');

            // DATA BLOG
            $table->string('title', 255);
            $table->text('content');
            $table->string('image', 255)->nullable();

            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('admin_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
