<?php

namespace Laravolt\Indonesia\Test;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

class IndonesiaTest extends TestCase
{
    use InteractsWithDatabase;

    // we make only one test case here to reduce the amount of seeding.
    // because seeding needs to import the csv and takes time.
    public function test()
    {
        $this->artisan('laravolt:indonesia:seed');

        $this->checkSeeder();
        $this->checkProvinces();
        $this->checkCities();
        $this->checkDistricts();
        $this->checkVillages();
    }

    public function checkSeeder()
    {
        $this->assertDatabaseHas('provinces', ['name' => 'ACEH']);
        $this->assertDatabaseHas('provinces', ['name' => 'PAPUA']);

        $this->assertDatabaseHas('cities', ['name' => 'KABUPATEN SIMEULUE']);
        $this->assertDatabaseHas('cities', ['name' => 'KOTA JAYAPURA']);

        $this->assertDatabaseHas('districts', ['name' => 'TEUPAH SELATAN']);
        $this->assertDatabaseHas('districts', ['name' => 'RUMBIO JAYA']);

        $this->assertDatabaseHas('villages', ['name' => 'LATIUNG']);
        $this->assertDatabaseHas('villages', ['name' => 'PAYA KALUT']);
    }

    public function checkProvinces()
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

    public function checkCities()
    {
        $results = \Indonesia::allCities();

        $this->assertNotEmpty($results);

        $results = \Indonesia::paginateCities();

        $this->assertEquals(count($results), 15);

        // array $with : province, districts, villages, districts.villages

        $selectedCityId = $results[0]->id;

        $result = \Indonesia::findCity($selectedCityId);

        $this->assertEquals($result->id, $selectedCityId);

        $result = \Indonesia::findCity($selectedCityId, ['province']);

        $this->assertNotEmpty($result->province);

        $result = \Indonesia::findCity($selectedCityId, ['districts']);

        $this->assertNotEmpty($result->districts);

        $result = \Indonesia::findCity($selectedCityId, ['villages']);

        $this->assertNotEmpty($result->villages);

        $result = \Indonesia::findCity($selectedCityId, ['districts.villages']);

        $this->assertNotEmpty($result->districts);
        $this->assertNotEmpty($result->districts[0]->villages);
    }

    public function checkDistricts()
    {
        $results = \Indonesia::allDistricts();

        $this->assertNotEmpty($results);

        $results = \Indonesia::paginateDistricts();

        $this->assertEquals(count($results), 15);

        // array $with : province, city, city.province, villages

        $selectedDistrictId = $results[0]->id;

        $result = \Indonesia::findDistrict($selectedDistrictId);

        $this->assertEquals($result->id, $selectedDistrictId);

        $result = \Indonesia::findDistrict($selectedDistrictId, ['province']);

        $this->assertNotEmpty($result->province);

        $result = \Indonesia::findDistrict($selectedDistrictId, ['city']);

        $this->assertNotEmpty($result->city);

        $result = \Indonesia::findDistrict($selectedDistrictId, ['city.province']);

        $this->assertNotEmpty($result->city);
        $this->assertNotEmpty($result->city->province);

        $result = \Indonesia::findDistrict($selectedDistrictId, ['villages']);

        $this->assertNotEmpty($result->villages);
    }

    public function checkVillages()
    {
        $results = \Indonesia::allVillages();

        $this->assertNotEmpty($results);

        $results = \Indonesia::paginateVillages();

        $this->assertEquals(count($results), 15);

        // array $with : province, city, district, district.city, district.city.province

        $selectedVillageId = $results[0]->id;

        $result = \Indonesia::findVillage($selectedVillageId);

        $this->assertEquals($result->id, $selectedVillageId);

        $result = \Indonesia::findVillage($selectedVillageId, ['province']);

        $this->assertNotEmpty($result->province);

        $result = \Indonesia::findVillage($selectedVillageId, ['city']);

        $this->assertNotEmpty($result->city);

        $result = \Indonesia::findVillage($selectedVillageId, ['district.city']);

        $this->assertNotEmpty($result->district);
        $this->assertNotEmpty($result->district->city);

        $result = \Indonesia::findVillage($selectedVillageId, ['district.city.province']);

        $this->assertNotEmpty($result->district);
        $this->assertNotEmpty($result->district->city);
        $this->assertNotEmpty($result->district->city->province);
    }
}
