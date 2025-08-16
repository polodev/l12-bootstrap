<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure morph maps for activity logging
        Relation::morphMap([
            'payment' => \Modules\Payment\Models\Payment::class,
            'user' => \App\Models\User::class,
        ]);
    }
}
