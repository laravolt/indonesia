<?php

namespace Laravolt\Indonesia\Test;

use Laravolt\Indonesia\Test\TestCase;

class IndonesiaTest extends TestCase
{
    public function test_seeder()
    {
        $this->seeInDatabase('provinces', ['name' => 'ACEH']);
        $this->seeInDatabase('provinces', ['name' => 'PAPUA']);

        $this->seeInDatabase('cities', ['name' => 'KABUPATEN SIMEULUE']);
        $this->seeInDatabase('cities', ['name' => 'KOTA JAYAPURA']);

        $this->seeInDatabase('districts', ['name' => 'TEUPAH SELATAN']);
        $this->seeInDatabase('districts', ['name' => 'RUMBIO JAYA']);

        $this->seeInDatabase('villages', ['name' => 'LATIUNG']);
        $this->seeInDatabase('villages', ['name' => 'PAYA KALUT']);
    }

    public function test_provinces()
    {
        $results = \Indonesia::allProvinces();

        $this->assertNotEmpty($results);

        $results = \Indonesia::paginateProvinces();

        $this->assertEquals(count($results), 15);

        // array $with : cities, districts, villages, cities.districts, cities.districts.villages, districts.villages

        $selectedProvinceId = $results[0]->id;

        $result = \Indonesia::findProvince($selectedProvinceId);

        $this->assertEquals($result->id, $selectedProvinceId);

        $result = \Indonesia::findProvince($selectedProvinceId, ['cities']);

        $this->assertNotEmpty($result->cities);

        $result = \Indonesia::findProvince($selectedProvinceId, ['districts']);

        $this->assertNotEmpty($result->districts);

        $result = \Indonesia::findProvince($selectedProvinceId, ['villages']);

        $this->assertNotEmpty($result->villages);

        $result = \Indonesia::findProvince($selectedProvinceId, ['cities', 'districts.villages']);

        $this->assertNotEmpty($result->cities);
        $this->assertNotEmpty($result->districts);
        $this->assertNotEmpty($result->districts[0]->villages);

        $result = \Indonesia::findProvince($selectedProvinceId, ['cities.districts']);

        $this->assertNotEmpty($result->cities[0]->districts);

        $result = \Indonesia::findProvince($selectedProvinceId, ['cities.districts.villages']);

        $this->assertNotEmpty($result->cities[0]->districts[0]->villages);
    }
}