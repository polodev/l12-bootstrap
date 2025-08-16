<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Blog\Models\Blog;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * The module namespace.
     */
    protected string $namespace = 'Modules\Blog';

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
        $this->registerMorphMap();
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
        $viewPath = resource_path('views/modules/blog');
        $sourcePath = $this->modulePath . 'resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'blog-views');

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), 'blog');
    }

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom($this->modulePath . 'routes/blog-routes.php');
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom($this->modulePath . 'database/migrations');
    }

    /**
     * Register morph map for polymorphic relationships.
     */
    protected function registerMorphMap(): void
    {
        Relation::morphMap([
            'blog' => Blog::class,
        ]);
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
            if (is_dir($path . '/modules/blog')) {
                $paths[] = $path . '/modules/blog';
            }
        }
        
        return $paths;
    }
}
