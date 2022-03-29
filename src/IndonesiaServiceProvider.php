<?php

namespace KodePandai\Indonesia;

use Illuminate\Support\ServiceProvider;

class IndonesiaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/indonesia.php', 'indonesia');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/indonesia.php' => config_path('indonesia.php'),
        ], 'indonesia-config');

        $migrationName = '2010_01_01_000000_create_indonesia_table.php';

        $this->publishes([
            __DIR__.'/../database/migrations/'.$migrationName => database_path('migrations/'.$migrationName),
        ], 'indonesia-migration');

        if (config('indonesia.api.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        }
    }
}
