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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive');

            // Email verification fields
            $table->string('verification_token', 64)->nullable();
            $table->timestamp('verification_expiry')->nullable();

            // Password reset fields
            $table->string('reset_pass_token', 64)->nullable();
            $table->timestamp('reset_pass_token_expiry')->nullable();

            $table->rememberToken();
            $table->timestamps();

            // Indexes for performance
            $table->index(['email', 'status']);
            $table->index(['username', 'status']);
            $table->index('verification_token');
            $table->index('reset_pass_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
