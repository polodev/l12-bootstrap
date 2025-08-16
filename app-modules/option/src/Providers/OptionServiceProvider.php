<?php

namespace Modules\Option\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class OptionServiceProvider extends ServiceProvider
{
	/**
	 * The module namespace to assume when generating URLs to actions.
	 */
	protected string $moduleNamespace = 'Modules\Option\Http\Controllers';

	public function register(): void
	{
		// Register module configuration if needed
	}
	
	public function boot(): void
	{
		// Register module routes
		$this->registerRoutes();

		// Register module views
		$this->registerViews();

		// Register module migrations
		$this->registerMigrations();
	}

	/**
	 * Register the module routes.
	 */
	protected function registerRoutes(): void
	{
		Route::group([
			'namespace' => $this->moduleNamespace,
		], function () {
			$this->loadRoutesFrom($this->getModulePath('routes/option-routes.php'));
		});
	}

	/**
	 * Register the module views.
	 */
	protected function registerViews(): void
	{
		$this->loadViewsFrom($this->getModulePath('resources/views'), 'option');
	}

	/**
	 * Register the module migrations.
	 */
	protected function registerMigrations(): void
	{
		$this->loadMigrationsFrom($this->getModulePath('database/migrations'));
	}

	/**
	 * Get the path to a module file or directory.
	 */
	protected function getModulePath(string $path = ''): string
	{
		return __DIR__ . '/../../' . ($path ? '/' . ltrim($path, '/') : '');
	}
}
