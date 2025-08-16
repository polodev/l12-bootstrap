<?php

namespace Modules\CustomerFrontendLayout\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CustomerFrontendServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		// Load views
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'customer-frontend-layout');
		
		// Register Blade component
		Blade::component('customer-frontend-layout::layout', 'customer-frontend-layout::layout');
	}
}
