<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
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
        $this->registerRoleDirectives();
    }

    /**
     * Register custom Blade directives for role checking
     */
    protected function registerRoleDirectives(): void
    {
        // Single role check
        Blade::directive('hasRole', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($role)): ?>";
        });

        Blade::directive('endhasRole', function () {
            return '<?php endif; ?>';
        });

        // Check if user has any of the specified roles
        Blade::directive('hasAnyRole', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRole($roles)): ?>";
        });

        Blade::directive('endhasAnyRole', function () {
            return '<?php endif; ?>';
        });

        // Check if user has all specified roles
        Blade::directive('hasAllRoles', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasAllRoles($roles)): ?>";
        });

        Blade::directive('endhasAllRoles', function () {
            return '<?php endif; ?>';
        });

        // Permission-based directives (for future use)
        Blade::directive('hasPermission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission($permission)): ?>";
        });

        Blade::directive('endhasPermission', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('hasAnyPermission', function ($permissions) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyPermission($permissions)): ?>";
        });

        Blade::directive('endhasAnyPermission', function () {
            return '<?php endif; ?>';
        });
    }
}