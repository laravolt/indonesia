<?php

use Illuminate\Support\Facades\Route;
use KodePandai\Indonesia\IndonesiaApiController;

Route::middleware(config('indonesia.api.middleware'))
    ->prefix(config('indonesia.api.route_prefix'))
    ->name(config('indonesia.api.route_name'))
    ->group(function () {
        //.
        Route::get('provinces', [IndonesiaApiController::class, 'provinces'])
            ->name('.provinces');

        Route::get('cities', [IndonesiaApiController::class, 'cities'])
            ->name('.cities');

        Route::get('districts', [IndonesiaApiController::class, 'districts'])
            ->name('.districts');

        Route::get('villages', [IndonesiaApiController::class, 'villages'])
            ->name('.villages');
        //.
    });
