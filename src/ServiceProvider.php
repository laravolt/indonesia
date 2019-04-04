<?php

namespace Laravolt\Indonesia;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bind('indonesia', function() {
            return new Indonesia;
        });

        $this->commands(\Laravolt\Indonesia\Commands\SeedCommand::class);

    }

    /*
        for lumen version <=5.2, just copy the migrations from the package directory
    */
    public function boot()
    {
        if ($this->isLaravel53AndUp() || $this->isLumen()) {
            $this->loadMigrationsFrom(__DIR__.'/migrations');
        } else {
            $this->publishes([
                __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
            ], 'migrations');
        }

        if (class_exists(Application::class)) {
            $this->publishes(
                [
                    __DIR__.'/../config/indonesia.php' => config_path('laravolt/indonesia.php'),
                ], 'config'
            );
        }
    }

    protected function isLaravel53AndUp()
    {
        return version_compare($this->app->version(), '5.3.0', '>=');
    }

    protected function isLaravel()
    {
        return app() instanceof \Illuminate\Foundation\Application;
    }

    protected function isLumen()
    {
        return !$this->isLaravel();
    }
}
