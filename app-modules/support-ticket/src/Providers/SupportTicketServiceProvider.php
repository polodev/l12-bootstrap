<?php

namespace Modules\SupportTicket\Providers;

use Illuminate\Support\ServiceProvider;

class SupportTicketServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		// Register any application services
	}
	
	public function boot(): void
	{
		// Load routes
		$this->loadRoutesFrom(__DIR__.'/../../routes/support-ticket-routes.php');
		
		// Load views
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'support-ticket');
		
		// Load migrations
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
		
		// Publish assets if needed
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__.'/../../resources/views' => resource_path('views/vendor/support-ticket'),
			], 'support-ticket-views');
		}
	}
}
