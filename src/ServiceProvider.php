<?php

namespace Laravolt\Indonesia;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/indonesia.php',
            'indonesia'
        );

        $config = $this->app->config['indonesia'];

        if ($config['api_enabled']) {

            $this->appendRoute($config);
        }

        $this->app->bind('indonesia', function() {
            return new Indonesia;
        });

        $this->commands(\Laravolt\Indonesia\Commands\SeedCommand::class);

    }

    public function boot()
    {
        if ($this->isLaravel53AndUp()) {
            $this->loadMigrationsFrom(__DIR__.'/migrations');
        } else {
            $this->publishes([
                __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
            ], 'migrations');
        }

        $this->publishes([
            __DIR__.'/../config/indonesia.php' => config_path('laravolt/indonesia.php'),
        ], 'config');
    }

    protected function isLaravel53AndUp()
    {
        return version_compare($this->app->version(), '5.3.0', '>=');
    }

    /**
     * appendRoute description]
     * @param  array  $config [description]
     * @return          [description]
     */
    protected function appendRoute(array $config)
    {
        Route::group([
            'namespace' => 'Laravolt\Indonesia\Controllers',
            'prefix' => $config['api_prefix']
        ], function () {

            Route::get('/provinces', 'ProvinceController@all');
            Route::get('/provinces/{provinceId}', 'ProvinceController@detail')->where(['provinceId' => '[0-9]+']);

            Route::get('/cities', 'CityController@all');
            Route::get('/cities/{cityId}', 'CityController@detail')->where(['cityId' => '[0-9]+']);

            Route::get('/districts', 'DistrictController@all');
            Route::get('/districts/{districtId}', 'DistrictController@detail')->where(['districtId' => '[0-9]+']);

            // Route::get('/villages', 'VillageController@all'); // disabled because too many data
            Route::get('/villages/{villageId}', 'VillageController@detail')->where(['villageId' => '[0-9]+']);

        });
    }
}
