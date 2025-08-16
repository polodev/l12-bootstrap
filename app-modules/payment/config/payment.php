<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auto-Payment Creation
    |--------------------------------------------------------------------------
    |
    | When a custom payment is created, automatically create a corresponding
    | payment record with the same amount and SSL Commerce as payment method.
    | This reduces operator workload as every custom payment typically needs
    | at least one payment record.
    |
    */
    'auto_create_payment' => env('PAYMENT_AUTO_CREATE', true),

    /*
    |--------------------------------------------------------------------------
    | Auto-Payment Default Settings
    |--------------------------------------------------------------------------
    |
    | Default values for auto-created payment records.
    |
    */
    'auto_payment_defaults' => [
        'payment_method' => 'sslcommerz',
        'status' => 'pending',
        'notes' => 'Auto-created payment record for custom payment processing'
    ],
];