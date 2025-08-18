<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Support Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the support ticket system.
    |
    */

    'email' => env('SUPPORT_EMAIL', 'support@example.com'),
    
    'business_hours' => [
        'start' => env('SUPPORT_HOURS_START', '09:00'),
        'end' => env('SUPPORT_HOURS_END', '18:00'),
        'timezone' => env('SUPPORT_TIMEZONE', 'UTC'),
        'days' => explode(',', env('SUPPORT_BUSINESS_DAYS', 'Monday,Tuesday,Wednesday,Thursday,Friday')),
    ],
    
    'response_time' => [
        'normal' => env('SUPPORT_RESPONSE_NORMAL', 24), // hours
        'high' => env('SUPPORT_RESPONSE_HIGH', 8), // hours
        'urgent' => env('SUPPORT_RESPONSE_URGENT', 2), // hours
    ],
    
    'notifications' => [
        'enabled' => env('SUPPORT_NOTIFICATIONS_ENABLED', true),
        'admin_emails' => explode(',', env('SUPPORT_ADMIN_EMAILS', '')),
    ],
];