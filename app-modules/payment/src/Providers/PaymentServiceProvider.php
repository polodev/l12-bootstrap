<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		// Register config
		$this->mergeConfigFrom(__DIR__ . '/../../config/payment.php', 'payment');
	}
	
	public function boot(): void
	{
		// Publish config
		$this->publishes([
			__DIR__ . '/../../config/payment.php' => config_path('payment.php'),
		], 'payment-config');
	}
}
