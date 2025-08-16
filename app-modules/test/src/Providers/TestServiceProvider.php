<?php

namespace Modules\Test\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		// Load views
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'test');
		
		// Load routes
		$this->loadRoutesFrom(__DIR__.'/../../routes/test-routes.php');
	}
}
