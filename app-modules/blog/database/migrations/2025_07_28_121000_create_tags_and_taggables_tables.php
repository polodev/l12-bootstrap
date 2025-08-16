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
        // Create tags table
        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->id();
                $table->string('english_name');
                $table->string('slug')->unique();
                $table->json('name'); // Translatable name field
                $table->string('type')->nullable();
                $table->integer('order_column')->nullable();
                $table->timestamps();
                
                $table->index(['slug']);
                $table->index(['type']);
            });
        }

        // Create taggables pivot table
        if (!Schema::hasTable('taggables')) {
            Schema::create('taggables', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
                $table->morphs('taggable');
                $table->timestamps();
                
                $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
                $table->index(['taggable_id', 'taggable_type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
    }
};