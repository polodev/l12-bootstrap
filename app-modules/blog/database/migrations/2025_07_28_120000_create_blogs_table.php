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
            $table->string('english_title');
            $table->foreignId('user_id')->nullable();
            $table->string('slug')->unique();
            $table->json('title'); // Translatable field
            $table->json('content')->nullable(); // Translatable field
            $table->json('excerpt')->nullable(); // Translatable field
            $table->json('meta_title')->nullable(); // SEO meta title (translatable)
            $table->json('meta_description')->nullable(); // SEO meta description (translatable)
            $table->json('meta_keywords')->nullable(); // SEO meta keywords (translatable)
            $table->string('canonical_url')->nullable(); // Canonical URL for SEO
            $table->boolean('noindex')->default(false); // SEO noindex directive
            $table->boolean('nofollow')->default(false); // SEO nofollow directive
            $table->string('status')->default('draft'); // enum: draft,published,scheduled
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
        Schema::dropIfExists('blogs');
    }
};