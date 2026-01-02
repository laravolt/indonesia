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
    ],
    'database' => [
        'connection' => env('INDONESIA_DB_CONNECTION', null),
    ],
];
