<?php

namespace KodePandai\Indonesia\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use KodePandai\Indonesia\IndonesiaDatabaseSeeder;
use KodePandai\Indonesia\IndonesiaServiceProvider;

/**
 * @see https://packages.tools/testbench/basic/testcase.html
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use LazilyRefreshDatabase;

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
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => 'database.sqlite',
        ]);
    }

    protected function refreshTestDatabase(): void
    {
        if (! RefreshDatabaseState::$migrated) {
            //.
            $this->artisan('migrate:fresh', $this->migrateFreshUsing());

            $this->artisan('db:seed', ['class' => IndonesiaDatabaseSeeder::class]);

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
