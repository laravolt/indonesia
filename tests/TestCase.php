<?php

namespace Laravolt\Indonesia\Test;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Laravolt\Indonesia\ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Indonesia' => \Laravolt\Indonesia\Facade::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => 'indonesia_',
        ]);
        $app['config']->set('indonesia.table_prefix', 'indonesia_');
    }
}
