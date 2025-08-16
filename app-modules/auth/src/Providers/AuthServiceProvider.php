<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'auth');
        $this->loadRoutesFrom(__DIR__.'/../../routes/auth-routes.php');
    }
}