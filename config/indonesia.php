<?php

return [
    'table_prefix' => 'indonesia_',
    'route' => [
        'enabled' => false,
        'middleware' => ['web', 'auth'],
        'prefix' => 'indonesia',
    ],
    'view' => [
        'layout' => 'ui::layouts.app',
    ],
    'menu' => [
        'enabled' => false,
    ],
    'cache' => [
        'ttl' => env('INDONESIA_CACHE_TTL', 3600),
        'prefix' => env('INDONESIA_CACHE_PREFIX', 'indonesia_service'),
        'store' => env('INDONESIA_CACHE_STORE', 'redis'),

        // Cache data format:
        // - model: store and return Eloquent models (backward compatible)
        // - array: store plain arrays in cache, then restore Eloquent models on read
        'data_format' => env('INDONESIA_CACHE_DATA_FORMAT', 'model'),
    ],
    'database' => [
        'connection' => env('INDONESIA_DB_CONNECTION', null),
    ],
];
