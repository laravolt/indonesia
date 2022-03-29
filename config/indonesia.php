<?php

/**
 * Read more at https://github.com/kodepandai/laravel-indonesia.
 */
return [
    /**
     * Table prefix for indonesia tables: provinces, cities, districts and villages.
     */
    'table_prefix' => 'indonesia_',

    /**
     * API Configuration.
     */
    'api' => [
        /**
         * If enabled, this will load Indonesia API.
         * - http://localhost:8000/api/indonesia/provinces
         * - http://localhost:8000/api/indonesia/cities
         * - http://localhost:8000/api/indonesia/districts
         * - http://localhost:8000/api/indonesia/villages
         */
        'enabled' => true,

        /**
         * The middleware for Indonesia API.
         */
        'middleware' => ['api'],

        /**
         * The route name for Indonesia API.
         */
        'route_name' => 'api.indonesia',

        /**
         * The route prefix for Indonesia API.
         */
        'route_prefix' => 'api/indonesia',

        /**
         * Specify which column will be displayed in the response data.
         * Only support columns from database.
         */
        'response_columns' => [
            //.
            'province' => ['code', 'name'],

            'city' => ['code', 'province_code', 'name'],

            'district' => ['code', 'city_code', 'name'],

            'village' => ['code', 'district_code', 'name'],
        ],
    ],
];
