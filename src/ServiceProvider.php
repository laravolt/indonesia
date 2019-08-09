<?php

namespace Laravolt\Indonesia;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

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
        $this->mergeConfigFrom(__DIR__.'/../config/indonesia.php', 'laravolt.indonesia');

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

        $this->loadViewsFrom(realpath(__DIR__.'/../resources/views'), 'indonesia');

        if (config('laravolt.indonesia.route.enabled')) {
            $this->registerRoutes();
        }

        if (config('laravolt.indonesia.menu.enabled')) {
            $this->registerMenu();
        }

        if ($this->app->bound('laravolt.acl')) {
            $this->app['laravolt.acl']->registerPermission(Permission::toArray());
        }
    }

    protected function registerMenu()
    {
        if ($this->app->bound('laravolt.menu')) {
            $menu = app('laravolt.menu')->add('Data Wilayah');
            $menu->add(__('Provinsi'), route('indonesia::provinsi.index'))
                ->data('icon', 'map')
                ->data('permission', Permission::MANAGE_INDONESIA)
                ->active(config('laravolt.indonesia.route.prefix').'/provinsi/*');
            $menu->add(__('Kota/Kabupaten'), route('indonesia::kabupaten.index'))
                ->data('icon', 'map marker')
                ->data('permission', Permission::MANAGE_INDONESIA)
                ->active(config('laravolt.indonesia.route.prefix').'/kabupaten/*');
            $menu->add(__('Kecamatan'), route('indonesia::kecamatan.index'))
                ->data('icon', 'map marker alternate')
                ->data('permission', Permission::MANAGE_INDONESIA)
                ->active(config('laravolt.indonesia.route.prefix').'/kecamatan/*');
            $menu->add(__('Desa/Kelurahan'), route('indonesia::kelurahan.index'))
                ->data('icon', 'map pin')
                ->data('permission', Permission::MANAGE_INDONESIA)
                ->active(config('laravolt.indonesia.route.prefix').'/kelurahan/*');
        }
    }

    protected function registerRoutes()
    {
        $router = $this->app['router'];
        require __DIR__.'/../routes/web.php';
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
