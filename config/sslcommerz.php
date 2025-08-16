<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SSL Commerz Configuration
    |--------------------------------------------------------------------------
    |
    | SSL Commerz payment gateway configuration for different stores.
    | You can configure multiple stores for different projects or environments.
    |
    */

    'main-store' => [
        'projectPath' => env('SSLCOMMERZ_PROJECT_PATH'),
        'apiDomain' => env('SSLCOMMERZ_API_DOMAIN_URL', env('SSLCOMMERZ_SANDBOX', true) ? 'https://sandbox.sslcommerz.com' : 'https://securepay.sslcommerz.com'),
        'apiCredentials' => [
            'store_id' => env('SSLCOMMERZ_STORE_ID'),
            'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),
        ],
        'apiUrl' => [
            'make_payment' => '/gwprocess/v4/api.php',
            'transaction_status' => '/validator/api/merchantTransIDvalidationAPI.php',
            'order_validate' => '/validator/api/validationserverAPI.php',
            'refund_payment' => '/validator/api/merchantTransIDvalidationAPI.php',
            'refund_status' => '/validator/api/merchantTransIDvalidationAPI.php',
        ],
        'connect_from_localhost' => env('SSLCOMMERZ_IS_LOCALHOST', true),
        'success_url' => '/sslcommerz/success/main',
        'failed_url' => '/sslcommerz/fail/main',
        'cancel_url' => '/sslcommerz/cancel/main',
        'ipn_url' => '/sslcommerz/ipn/main',
    ],

    'sslcommerz-store2' => [
        'projectPath' => env('SSLCOMMERZ_PROJECT_PATH'),
        'apiDomain' => env('SSLCOMMERZ_API_DOMAIN_URL', env('SSLCOMMERZ_SANDBOX', true) ? 'https://sandbox.sslcommerz.com' : 'https://securepay.sslcommerz.com'),
        'apiCredentials' => [
            'store_id' => env('SSLCOMMERZ_STORE2_STORE_ID'),
            'store_password' => env('SSLCOMMERZ_STORE2_STORE_PASSWORD'),
        ],
        'apiUrl' => [
            'make_payment' => '/gwprocess/v4/api.php',
            'transaction_status' => '/validator/api/merchantTransIDvalidationAPI.php',
            'order_validate' => '/validator/api/validationserverAPI.php',
            'refund_payment' => '/validator/api/merchantTransIDvalidationAPI.php',
            'refund_status' => '/validator/api/merchantTransIDvalidationAPI.php',
        ],
        'connect_from_localhost' => env('SSLCOMMERZ_IS_LOCALHOST', true),
        'success_url' => '/sslcommerz/success/sslcommerz-store2',
        'failed_url' => '/sslcommerz/fail/sslcommerz-store2',
        'cancel_url' => '/sslcommerz/cancel/sslcommerz-store2',
        'ipn_url' => '/sslcommerz/ipn/sslcommerz-store2',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Store
    |--------------------------------------------------------------------------
    |
    | The default store to use when no specific store is specified
    |
    */
    'default_store' => env('SSLCOMMERZ_DEFAULT_STORE', 'main-store'),

    /*
    |--------------------------------------------------------------------------
    | SSL Commerz Environment Settings
    |--------------------------------------------------------------------------
    |
    | Sandbox mode for testing
    | Set to false for production
    |
    */
    'sandbox' => env('SSLCOMMERZ_SANDBOX', true),
    
    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Default currency for transactions
    |
    */
    'currency' => env('SSLCOMMERZ_CURRENCY', 'BDT'),
    
    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    |
    | Timeout and other connection settings
    |
    */
    'timeout' => env('SSLCOMMERZ_TIMEOUT', 30),
    'connect_timeout' => env('SSLCOMMERZ_CONNECT_TIMEOUT', 10),
    
    /*
    |--------------------------------------------------------------------------
    | Fallback Email
    |--------------------------------------------------------------------------
    |
    | Email address to use when customer email is not available
    |
    */
    'fallback_email' => env('SSLCOMMERZ_FALLBACK_EMAIL', 'polodev10@gmail.com'),
];