<?php

namespace Modules\ApiService;

use Modules\ApiService\Services\FlightApiService;
use Modules\ApiService\Services\HotelApiService;

class ApiServiceManager
{
    /**
     * Get Flight API Service instance
     */
    public static function flight(): FlightApiService
    {
        return app()->make(FlightApiService::class);
    }

    /**
     * Get Hotel API Service instance
     */
    public static function hotel(): HotelApiService
    {
        return app()->make(HotelApiService::class);
    }

    /**
     * Check if API services are enabled
     */
    public static function isEnabled(): bool
    {
        return config('api-service.enabled', false);
    }

    /**
     * Get API service configuration
     */
    public static function config(string $key = null, $default = null)
    {
        if ($key === null) {
            return config('api-service', []);
        }
        
        return config("api-service.{$key}", $default);
    }
}