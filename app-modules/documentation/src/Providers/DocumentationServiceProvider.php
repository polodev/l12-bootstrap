<?php

namespace Modules\Documentation\Providers;

use Illuminate\Support\ServiceProvider;

class DocumentationServiceProvider extends ServiceProvider
{
    /**
     * The module namespace.
     */
    protected string $namespace = 'Modules\Documentation';

    /**
     * The module path.
     */
    protected string $modulePath = __DIR__ . '/../../';

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerViews();
        $this->registerRoutes();
        $this->registerMigrations();
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/documentation');
        $sourcePath = $this->modulePath . 'resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'documentation-views');

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), 'documentation');
    }

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom($this->modulePath . 'routes/documentation-routes.php');
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom($this->modulePath . 'database/migrations');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    /**
     * Get publishable view paths.
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        
        foreach ($this->app['config']['view.paths'] as $path) {
            if (is_dir($path . '/modules/documentation')) {
                $paths[] = $path . '/modules/documentation';
            }
        }
        
        return $paths;
    }
}