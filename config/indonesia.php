<?php

return [
    'table_prefix' => 'indonesia_',
    'route' => [
        'enabled' => false,
        // The pages can create, edit and delete region data, so they require the
        // indonesia::manage-all permission (laravolt/acl registers it).
        'middleware' => ['web', 'auth', 'can:indonesia::manage-all'],
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
        'store' => env('INDONESIA_CACHE_STORE'),
    ],
    'database' => [
        'connection' => env('INDONESIA_DB_CONNECTION', null),
    ],
];
