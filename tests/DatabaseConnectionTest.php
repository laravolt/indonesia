<?php

namespace Laravolt\Indonesia\Test;

use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use PHPUnit\Framework\Attributes\Test;

class DatabaseConnectionTest extends TestCase
{
    #[Test]
    public function models_use_the_configured_connection()
    {
        config()->set('laravolt.indonesia.database.connection', 'regions');

        $this->assertSame('regions', (new Province())->getConnectionName());
        $this->assertSame('regions', (new Village())->getConnectionName());

        // The migrations roll back on teardown and read the same setting.
        config()->set('laravolt.indonesia.database.connection', null);
    }

    #[Test]
    public function models_fall_back_to_the_default_connection()
    {
        $this->assertNull((new Province())->getConnectionName());
    }
}
