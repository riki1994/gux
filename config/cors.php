<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST','PUT','PATCH', 'DELETE'],

    'allowed_origins' => ['*'], // limit range of ips or domains

    'allowed_origins_patterns' => [],  // limit range of ips or domains using patterns

    'allowed_headers' => ['*'], // limit the allowed headers

    'exposed_headers' => [],

    'max_age' => 0, // max time of client cache

    'supports_credentials' => false,

];
