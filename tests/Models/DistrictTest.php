<?php

namespace Laravolt\Indonesia\Test\Models;

use Illuminate\Database\Eloquent\Collection;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Test\TestCase;

class DistrictTest extends TestCase
{
    /** @test */
    public function a_district_has_belongs_to_city_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $district = District::first();

        $this->assertInstanceOf(City::class, $district->city);
        $this->assertEquals($district->city_id, $district->city->id);
    }

    /** @test */
    public function a_district_has_many_villages_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\VillagesSeeder');
        $district = District::first();

        $this->assertInstanceOf(Collection::class, $district->villages);
        $this->assertInstanceOf(Village::class, $district->villages->first());
    }

    /** @test */
    public function a_district_has_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $district = District::first();

        $this->assertEquals('TEUPAH SELATAN', $district->name);
    }

    /** @test */
    public function a_district_has_city_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $district = District::first();

        $this->assertEquals('KABUPATEN SIMEULUE', $district->city_name);
    }

    /** @test */
    public function a_district_has_province_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $district = District::first();

        $this->assertEquals('ACEH', $district->province_name);
    }

    /** @test */
    public function a_district_can_store_meta_column()
    {
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $district = District::first();
        $district->meta = ['luas_wilayah' => 200.2];
        $district->save();
        $this->assertEquals(['luas_wilayah' => 200.2], $district->meta);
    }
}
