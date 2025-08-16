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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('english_title');
            $table->foreignId('user_id')->nullable();
            $table->string('slug')->unique();
            $table->json('title'); // Translatable field
            $table->json('content')->nullable(); // Translatable field
            $table->string('template')->nullable(); // Template name
            $table->json('meta_title')->nullable(); // SEO meta title (translatable)
            $table->json('meta_description')->nullable(); // SEO meta description (translatable)
            $table->json('keywords')->nullable(); // SEO keywords (translatable)
            $table->string('status')->default('draft'); // enum: draft,published
            $table->timestamp('published_at')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['status', 'published_at']);
            $table->index('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};