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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('country_code', 5)->nullable(); // e.g., "+1", "+44"
            $table->string('mobile', 15)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password')->nullable(); # for login with google
            $table->string('email_login_code', 6)->nullable();
            $table->timestamp('email_login_code_expires_at')->nullable();
            $table->string('google_id')->nullable(); // Google OAuth ID
            $table->string('facebook_id')->nullable(); // Facebook OAuth ID
            $table->string('avatar')->nullable(); // Profile picture URL
            $table->boolean('password_set')->default(false); // Whether user has set a password
            $table->string('role')->nullable()->default('user');
            $table->timestamp('last_login_at')->nullable();
            $table->string('country')->nullable();
            $table->unsignedBigInteger('default_address_id')->nullable(); // Reference to user addresses
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
