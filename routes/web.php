<?php

$router->group(
    [
        'namespace' => '\Laravolt\Indonesia\Http\Controllers',
        'prefix' => config('laravolt.indonesia.route.prefix'),
        'as' => 'indonesia::',
        'middleware' => config('laravolt.indonesia.route.middleware'),
    ],
    function ($router) {
        $router->resource('provinsi', 'ProvinsiController');
        $router->resource('kabupaten', 'KabupatenController');
        $router->resource('kecamatan', 'KecamatanController');
        $router->resource('kelurahan', 'KelurahanController');
    }
);
