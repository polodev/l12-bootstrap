<?php

namespace Modules\MyFile\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class MyFileServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\MyFile\Http\Controllers';

    /**
     * All of the container bindings that should be registered.
     */
    public array $bindings = [];

    /**
     * All of the container singletons that should be registered.
     */
    public array $singletons = [];

    /**
     * Register services.
     */
    public function register(): void
    {
        // Register module configuration
        $this->mergeConfigFrom(
            $this->getModulePath('config/my-file.php'), 'my-file'
        );

        // Register module bindings
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        // Register module singletons
        foreach ($this->singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register module routes
        $this->registerRoutes();

        // Register module views
        $this->registerViews();

        // Register module migrations
        $this->registerMigrations();

        // Register module translations
        $this->registerTranslations();

        // Register module factories
        $this->registerFactories();

        // Publish module assets
        $this->registerPublishing();
    }

    /**
     * Register the module routes.
     */
    protected function registerRoutes(): void
    {
        Route::group([
            'namespace' => $this->moduleNamespace,
        ], function () {
            $this->loadRoutesFrom($this->getModulePath('routes/my-file-routes.php'));
        });
    }

    /**
     * Register the module views.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom($this->getModulePath('resources/views'), 'my-file');
    }

    /**
     * Register the module migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom($this->getModulePath('database/migrations'));
    }

    /**
     * Register the module translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom($this->getModulePath('resources/lang'), 'my-file');
    }

    /**
     * Register the module factories.
     */
    protected function registerFactories(): void
    {
        if ($this->app->environment('local', 'testing')) {
            // Register factories for local and testing environments
        }
    }

    /**
     * Register the module publishing.
     */
    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes([
                $this->getModulePath('config/my-file.php') => config_path('my-file.php'),
            ], 'my-file-config');

            // Publish views
            $this->publishes([
                $this->getModulePath('resources/views') => resource_path('views/vendor/my-file'),
            ], 'my-file-views');

            // Publish translations
            $this->publishes([
                $this->getModulePath('resources/lang') => resource_path('lang/vendor/my-file'),
            ], 'my-file-translations');

            // Publish migrations
            $this->publishes([
                $this->getModulePath('database/migrations') => database_path('migrations'),
            ], 'my-file-migrations');
        }
    }

    /**
     * Get the path to a module file or directory.
     */
    protected function getModulePath(string $path = ''): string
    {
        return __DIR__ . '/../../' . ($path ? '/' . ltrim($path, '/') : '');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}