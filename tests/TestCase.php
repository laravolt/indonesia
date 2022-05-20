<?php

namespace KodePandai\Indonesia\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use KodePandai\Indonesia\IndonesiaServiceProvider;

/**
 * @see https://packages.tools/testbench/basic/testcase.html
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use DatabaseTransactions;

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
