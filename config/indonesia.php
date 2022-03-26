<?php

return [
    /**
     * TODO: docs
     */
    'table_prefix' => 'indonesia_',

    /**
     * TODO: docs
     */
    'api' => [
        'enabled' => true,

        'middleware' => ['api'],

        'route_name' => 'api.indonesia',

        'route_prefix' => 'api/indonesia',

        'response_cached' => true,

        'response_include_latitude_longitude' => false,
    ],
];
