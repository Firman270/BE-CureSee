<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // AUTH
            $table->string('firebase_uid')->nullable()->unique(); // USER only
            $table->string('email')->unique();
            $table->string('password')->nullable(); // ADMIN only (logic level)

            // IDENTITAS
            $table->string('name')->nullable();
            $table->string('username')->nullable()->unique();

            // ROLE
            $table->enum('role', ['user', 'admin'])->default('user');

            // DATA USER
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->integer('age')->nullable();
            $table->string('avatar_url')->nullable();

            $table->timestamps();
        });

        // 🔐 RESET PASSWORD (KEEP)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 🖥️ SESSION ADMIN (KEEP)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
