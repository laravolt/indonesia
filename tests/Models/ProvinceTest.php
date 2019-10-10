<?php

namespace Laravolt\Indonesia\Test\Models;

use Illuminate\Database\Eloquent\Collection;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Test\TestCase;

class ProvinceTest extends TestCase
{
    /** @test */
    public function a_province_has_many_cities_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $province = Province::first();

        $this->assertInstanceOf(Collection::class, $province->cities);
        $this->assertInstanceOf(City::class, $province->cities->first());
    }

    /** @test */
    public function a_province_has_many_districts_relation()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\CitiesSeeder');
        $this->seed('Laravolt\Indonesia\Seeds\DistrictsSeeder');
        $province = Province::first();

        $this->assertInstanceOf(Collection::class, $province->districts);
        $this->assertInstanceOf(District::class, $province->districts->first());
    }

    /** @test */
    public function a_province_has_name_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $province = Province::first();

        $this->assertEquals('ACEH', $province->name);
    }

    /** @test */
    public function a_province_has_logo_path_attribute()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $province = Province::first();

        $this->assertNull($province->logo_path);
    }

    /** @test */
    public function a_province_can_store_meta_column()
    {
        $this->seed('Laravolt\Indonesia\Seeds\ProvincesSeeder');
        $province = Province::first();
        $province->meta = ['luas_wilayah' => 200.2];
        $province->save();
        $this->assertEquals(['luas_wilayah' => 200.2], $province->meta);
    }
}
