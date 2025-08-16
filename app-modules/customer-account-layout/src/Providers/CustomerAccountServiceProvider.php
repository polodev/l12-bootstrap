<?php

namespace Modules\CustomerAccountLayout\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CustomerAccountServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		// Load views
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'customer-account-layout');
		
		// Register Blade component
		Blade::component('customer-account-layout::layout', 'customer-account-layout::layout');
	}
}
