<?php

namespace KodePandai\Indonesia\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use KodePandai\Indonesia\IndonesiaServiceProvider;

/**
 * @see https://packages.tools/testbench/basic/testcase.html
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use DatabaseTransactions;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     Artisan::call('migrate');
    //     Artisan::call('db:seed', [
    //         'class' => \KodePandai\Indonesia\IndonesiaDatabaseSeeder::class,
    //     ]);
    //     die(0); // disable DatabaseTransaction first
    // }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [IndonesiaServiceProvider::class];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetup($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => 'database.sqlite',
        ]);
    }
}
