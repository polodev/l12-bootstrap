<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure morph maps for activity logging
        Relation::morphMap([
            'payment' => \Modules\Payment\Models\Payment::class,
            'booking' => \Modules\Booking\Models\Booking::class,
            'booking_hotel' => \Modules\Booking\Models\BookingHotel::class,
            'booking_tour' => \Modules\Booking\Models\BookingTour::class,
            'booking_flight' => \Modules\Booking\Models\BookingFlight::class,
            'user' => \App\Models\User::class,
        ]);
    }
}
