<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('page')->nullable(); // Page/URL context where contact was made
            $table->string('topic')->nullable(); // Subject/Topic of contact
            $table->string('department')->nullable(); // Department to contact
            $table->text('message');
            $table->boolean('has_reply')->default(false); // Whether admin has replied
            $table->text('remarks')->nullable(); // Admin remarks/notes
            $table->foreignId('user_id')->nullable(); // If contact is from logged-in user
            $table->string('ip_address')->nullable(); // IP address of the submitter
            $table->text('user_agent')->nullable(); // User agent string
            $table->timestamps();
            
            // Indexes
            $table->index(['email']);
            $table->index(['has_reply']);
            $table->index(['created_at']);
            $table->index(['user_id']);
            $table->index(['ip_address']);
            $table->index(['ip_address', 'created_at']); // For rate limiting queries
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        DB::statement("ALTER TABLE contacts AUTO_INCREMENT = 100000;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
