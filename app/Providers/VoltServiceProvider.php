<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class VoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Volt::mount([
            config('livewire.view_path', resource_path('views/livewire')),
            resource_path('views/pages'),
            base_path('app-modules/user-data/resources/views/livewire'),
            base_path('app-modules/option/resources/views/livewire'),
            base_path('app-modules/booking/resources/views/livewire'),
            base_path('app-modules/payment/resources/views/livewire'),
            base_path('app-modules/utility/resources/views/livewire'),
            base_path('app-modules/hotel/resources/views/livewire'),
            base_path('app-modules/flight/resources/views/livewire'),
        ]);
    }
}
