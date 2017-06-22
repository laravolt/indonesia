<?php

namespace Laravolt\Indonesia\Test;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected static $dbInited = false;

    public function setUp()
    {
        parent::setUp();

//        file_put_contents(__DIR__.'/database.sqlite', null);

        $this->loadMigrationsFrom([
            '--realpath' => realpath(__DIR__.'/../src/migrations'),
        ]);

        $this->artisan('laravolt:indonesia:seed');

        // if (!static::$dbInited) {
        //     file_put_contents(__DIR__.'/database.sqlite', null);

        //     $this->loadMigrationsFrom([
        //         '--database' => 'sqlite',
        //         '--realpath' => realpath(__DIR__.'/../src/migrations'),
        //     ]);

        //     $this->artisan('laravolt:indonesia:seed');

        //     static::$dbInited = true;
        // }
    }

    protected function getPackageProviders($app)
    {
        return [
            \Laravolt\Indonesia\ServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Indonesia' => \Laravolt\Indonesia\Facade::class
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
