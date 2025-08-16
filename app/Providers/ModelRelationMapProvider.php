<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

/**
 * Model Relation Map Provider
 * 
 * This provider enforces a morph map for polymorphic relationships.
 * Benefits:
 * - Prevents full class names from being stored in the database
 * - Allows for easier model refactoring and namespace changes
 * - Improves database readability and consistency
 * - Reduces database storage size
 * 
 * Example: Instead of storing "App\Models\User" in the database,
 * it will store "user" which maps to the full class name.
 */
class ModelRelationMapProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * 
     * Enforce morph map for polymorphic relationships.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            // Core Models
            'user' => \App\Models\User::class,
            
            // Module Models  
            'user_address' => \Modules\UserData\Models\UserAddress::class,
            'my_file' => \Modules\MyFile\Models\MyFile::class,
            'airline' => \Modules\Flight\Models\Airline::class,
            'flight' => \Modules\Flight\Models\Flight::class,
            'contact' => \Modules\Contact\Models\Contact::class,
        ]);
    }
}