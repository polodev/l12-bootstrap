<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for third-party API integrations including flight and hotel APIs.
    | Toggle services on/off, configure API credentials, and set service options.
    |
    */

    'enabled' => env('API_SERVICE_ENABLED', false),
    
    'default_provider' => [
        'flight' => env('DEFAULT_FLIGHT_PROVIDER', 'amadeus'),
        'hotel' => env('DEFAULT_HOTEL_PROVIDER', 'expedia'),
    ],

    'providers' => [
        'amadeus' => [
            'enabled' => env('AMADEUS_ENABLED', false),
            'api_key' => env('AMADEUS_API_KEY'),
            'api_secret' => env('AMADEUS_API_SECRET'),
            'base_url' => env('AMADEUS_BASE_URL', 'https://api.amadeus.com'),
            'timeout' => 30,
            'services' => ['flight', 'hotel']
        ],
        
        'sabre' => [
            'enabled' => env('SABRE_ENABLED', false),
            'client_id' => env('SABRE_CLIENT_ID'),
            'client_secret' => env('SABRE_CLIENT_SECRET'),
            'base_url' => env('SABRE_BASE_URL', 'https://api.sabre.com'),
            'timeout' => 30,
            'services' => ['flight', 'hotel']
        ],
        
        'expedia' => [
            'enabled' => env('EXPEDIA_ENABLED', false),
            'api_key' => env('EXPEDIA_API_KEY'),
            'base_url' => env('EXPEDIA_BASE_URL', 'https://api.expedia.com'),
            'timeout' => 30,
            'services' => ['hotel']
        ],
        
        'booking_com' => [
            'enabled' => env('BOOKING_COM_ENABLED', false),
            'api_key' => env('BOOKING_COM_API_KEY'),
            'base_url' => env('BOOKING_COM_BASE_URL', 'https://distribution-xml.booking.com'),
            'timeout' => 30,
            'services' => ['hotel']
        ]
    ],

    'cache' => [
        'enabled' => env('API_CACHE_ENABLED', true),
        'ttl' => [
            'flight_search' => env('CACHE_FLIGHT_SEARCH_TTL', 300), // 5 minutes
            'hotel_search' => env('CACHE_HOTEL_SEARCH_TTL', 600),  // 10 minutes
            'flight_details' => env('CACHE_FLIGHT_DETAILS_TTL', 1800), // 30 minutes
            'hotel_details' => env('CACHE_HOTEL_DETAILS_TTL', 3600),   // 1 hour
        ]
    ],

    'rate_limiting' => [
        'enabled' => env('API_RATE_LIMITING_ENABLED', true),
        'requests_per_minute' => env('API_REQUESTS_PER_MINUTE', 60),
        'burst_limit' => env('API_BURST_LIMIT', 10),
    ],

    'fallback' => [
        'use_static_data' => env('API_FALLBACK_STATIC_DATA', true),
        'show_error_messages' => env('API_SHOW_ERROR_MESSAGES', false),
        'timeout_fallback' => env('API_TIMEOUT_FALLBACK', true),
    ],
];