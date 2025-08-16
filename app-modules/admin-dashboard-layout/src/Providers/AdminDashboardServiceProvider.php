<?php

namespace Modules\AdminDashboardLayout\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AdminDashboardServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		// Load views
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin-dashboard-layout');
		
		// Register Blade component
		Blade::component('admin-dashboard-layout::layout', 'admin-dashboard-layout::layout');
	}
}
