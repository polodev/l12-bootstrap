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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // e.g., "pro" (simplified from full titles)
            $table->string('slug')->unique(); // e.g., "pro-monthly", "pro-quarterly"
            $table->text('description')->nullable();
            $table->json('plan_title')->nullable(); // Translatable plan titles: {"en": "Pro Monthly", "bn": "প্রো মাসিক"}
            $table->decimal('price', 10, 2); // Price in BDT
            $table->integer('duration_months'); // 1, 3, 6, 12
            $table->string('currency', 3)->default('BDT');
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable(); // Translatable features text for EasyMDE: {"en": "markdown text", "bn": "markdown text"}
            $table->integer('sort_order')->default(0); // For display ordering
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'sort_order']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};