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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable();
            $table->string('name');
            $table->string('state_province')->nullable();
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->string('timezone')->nullable();
            $table->integer('population')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_capital')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['country_id', 'is_active']);
            $table->index(['is_popular', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};