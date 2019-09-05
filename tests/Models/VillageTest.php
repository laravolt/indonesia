<?php

namespace Laravolt\Indonesia\Test\Models;

use Laravolt\Indonesia\Test\TestCase;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;

class VillageTest extends TestCase
{
    /** @test */
    public function a_village_has_belongs_to_distict_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\VillagesSeeder');
        $village = Village::first();

        $this->assertInstanceOf(District::class, $village->district);
        $this->assertEquals($village->district_id, $village->district->id);
    }

    /** @test */
    public function a_village_has_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\VillagesSeeder');
        $village = Village::first();

        $this->assertEquals('LATIUNG', $village->name);
    }

    /** @test */
    public function a_village_has_district_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\VillagesSeeder');
        $village = Village::first();

        $this->assertEquals('TEUPAH SELATAN', $village->district_name);
    }

    /** @test */
    public function a_village_has_city_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\VillagesSeeder');
        $village = Village::first();

        $this->assertEquals('KABUPATEN SIMEULUE', $village->city_name);
    }

    /** @test */
    public function a_village_has_province_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\VillagesSeeder');
        $village = Village::first();

        $this->assertEquals('ACEH', $village->province_name);
    }
}
