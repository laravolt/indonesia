<?php

namespace Laravolt\Indonesia\Test;

use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class DatabaseConnectionTest extends TestCase
{
    /** @test */
    public function models_use_configured_database_connection_when_set()
    {
        // Test that models respect the configured connection
        // We can't actually connect to a non-existent connection in tests,
        // but we can verify that the getConnectionName() method returns the right value

        // When config is null
        config()->set('indonesia.database.connection', null);
        $province = new Province();
        $this->assertNull($province->getConnectionName());

        // When config is set (just test the method, not actual connection)
        config()->set('indonesia.database.connection', 'indonesia_db');
        $province = new Province();
        $this->assertEquals('indonesia_db', $province->getConnectionName());

        $city = new City();
        $this->assertEquals('indonesia_db', $city->getConnectionName());

        $district = new District();
        $this->assertEquals('indonesia_db', $district->getConnectionName());

        $village = new Village();
        $this->assertEquals('indonesia_db', $village->getConnectionName());

        // Reset config for other tests
        config()->set('indonesia.database.connection', null);
    }
}
