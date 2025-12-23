<?php

return [
    /*
     * API path.
     */
    'path' => 'api/documentation',

    /*
     * API domain.
     */
    'domain' => null,

    /*
     * API title.
     */
    'title' => 'Car Marketplace API',

    /*
     * API description.
     */
    'description' => 'RESTful API for the car marketplace platform. Browse cars, manage listings, and handle user watchlists.',

    /*
     * API version.
     */
    'version' => '1.0.0',

    /*
     * Servers.
     */
    'servers' => [
        [
            'url' => env('APP_URL', 'http://localhost'),
            'description' => 'Main server',
        ],
    ],

    /*
     * Middleware.
     */
    'middleware' => ['web'],

    /*
     * API routes to document.
     */
    'api_path' => 'api/v1',

    /*
     * Info contact.
     */
    'info' => [
        'contact' => [
            'name' => 'API Support',
            'email' => 'support@car-hub.xyz',
        ],
    ],
];
