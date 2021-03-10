<?php

namespace Laravolt\Indonesia\Test\Models;

use Illuminate\Database\Eloquent\Collection;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Test\TestCase;

class CityTest extends TestCase
{
    /** @test */
    public function a_city_has_belongs_to_province_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');

        $city = City::first();

        $this->assertInstanceOf(Province::class, $city->province);
        $this->assertEquals($city->province_code, $city->province->code);
    }

    /** @test */
    public function a_city_has_many_districts_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');

        $city = City::first();

        $this->assertInstanceOf(Collection::class, $city->districts);
        $this->assertInstanceOf(District::class, $city->districts->first());
    }

    /** @test */
    public function a_city_has_many_villages_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\VillagesSeeder');

        $city = City::first();

        $this->assertInstanceOf(Collection::class, $city->villages);
        $this->assertInstanceOf(Village::class, $city->villages->first());
    }

    /** @test */
    public function a_city_has_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');

        $city = City::first();

        $this->assertEquals('KABUPATEN ACEH SELATAN', $city->name);
    }

    /** @test */
    public function a_city_has_province_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');

        $city = City::first();

        $this->assertEquals('ACEH', $city->province_name);
    }

    /** @test */
    public function a_city_has_logo_path_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');

        $city = City::first();

        $this->assertNull($city->logo_path);
    }

    /** @test */
    public function a_city_can_store_meta_column()
    {
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');

        $city = City::first();
        $city->meta = ['luas_wilayah' => 200.2];
        $city->save();

        $this->assertEquals(['luas_wilayah' => 200.2], $city->meta);
    }
}
