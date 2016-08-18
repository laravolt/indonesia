<?php

namespace Laravolt\Indonesia;

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

    public function boot()
    {
        $this->publishes([
	        __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
	    ], 'migrations');
    }
}