<?php

namespace Modules\CustomerDashboard\Providers;

use Illuminate\Support\ServiceProvider;

class CustomerDashboardServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'customer-dashboard');
        $this->loadRoutesFrom(__DIR__.'/../../routes/customer-dashboard-routes.php');
	}
}
