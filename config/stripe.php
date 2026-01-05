<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    |
    | The Stripe publishable key and secret key give you access to Stripe's API.
    | The "publishable" key is typically used in your front-end code.
    |
    */

    'key' => env('STRIPE_KEY'),

    'secret' => env('STRIPE_SECRET'),

    'webhook' => [
        'secret' => env('STRIPE_WEBHOOK_SECRET'),
        'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
    ],

    /*
    |--------------------------------------------------------------------------
    | Featured Listing Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for featured car listings payment.
    |
    */

    'featured_listing' => [
        'price' => env('STRIPE_FEATURED_PRICE', 2999), // Price in cents ($29.99)
        'currency' => env('STRIPE_CURRENCY', 'usd'),
        'duration_days' => env('FEATURED_DURATION_DAYS', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe API Version
    |--------------------------------------------------------------------------
    |
    | The version of the Stripe API to use. Leave null to use the account default.
    |
    */

    'api_version' => env('STRIPE_API_VERSION', '2024-12-18.acacia'),
];
