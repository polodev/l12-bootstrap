<?php

namespace Modules\Utility\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class UtilityServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		// Load views
		$this->loadViewsFrom(__DIR__ . '/../../resources/views', 'utility');
		
		// Register Blade components
		Blade::componentNamespace('Modules\\Utility\\View\\Components', 'utility');
	}
}
