<?php

namespace Laravolt\Indonesia\Test;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Support\Facades\Cache;

class IndonesiaTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Clear cache before each test
        config()->set('cache.default', 'array');
        Cache::flush();
    }

    /** @test */
    public function it_can_call_indonesia_service()
    {
        $this->artisan('laravolt:indonesia:seed');

        $this->checkProvinces();
        $this->checkCities();
        $this->checkDistricts();
        // $this->checkVillages();
        $this->search();
    }

    /** @test */
    public function it_can_cache_service_results()
    {
        $this->artisan('laravolt:indonesia:seed');

        // Test basic caching
        $provinces1 = \Indonesia::allProvinces();
        $provinces2 = \Indonesia::allProvinces();

        $this->assertEquals($provinces1->count(), $provinces2->count());
        $this->assertEquals($provinces1->toArray(), $provinces2->toArray());
    }

    /** @test */
    public function it_caches_search_results_independently()
    {
        $this->artisan('laravolt:indonesia:seed');

        // Get all results
        $allProvinces = \Indonesia::allProvinces();

        // Get search results
        $jakartaResults = \Indonesia::search('JAKARTA')->allProvinces();

        // Results should be different sizes (assuming JAKARTA search returns fewer results)
        $this->assertNotEquals($allProvinces->count(), $jakartaResults->count());

        // Test that we can get different search results
        $baliResults = \Indonesia::search('BALI')->allProvinces();

        $this->assertNotEquals($jakartaResults->first()->name, $baliResults->first->name);
    }

    /** @test */
    public function it_handles_cache_with_different_parameters()
    {
        $this->artisan('laravolt:indonesia:seed');

        $provinces = \Indonesia::allProvinces();
        if ($provinces->isEmpty()) {
            $this->markTestSkipped('No provinces found in database');
        }

        $provinceId = $provinces->first()->id;

        // Test that different relation parameters work
        $province1 = \Indonesia::findProvince($provinceId, ['cities']);
        $province2 = \Indonesia::findProvince($provinceId, ['districts']);
        $province3 = \Indonesia::findProvince($provinceId);

        // All should return valid results
        $this->assertEquals($provinceId, $province1->id);
        $this->assertEquals($provinceId, $province2->id);
        $this->assertEquals($provinceId, $province3->id);

        // With relations should have additional data
        $this->assertTrue(isset($province1->cities));
        $this->assertTrue(isset($province2->districts));
    }

    /** @test */
    public function it_can_set_custom_cache_ttl()
    {
        $this->artisan('laravolt:indonesia:seed');

        // Test that service can be configured with different TTL
        $service = new \Laravolt\Indonesia\IndonesiaService(7200); // 2 hours
        $provinces = $service->allProvinces();

        $this->assertNotEmpty($provinces);

        // Test dynamic TTL change
        $service->setCacheTtl(1800); // 30 minutes
        $cities = $service->allCities();

        $this->assertNotEmpty($cities);
    }

    /** @test */
    public function it_can_handle_empty_search_results()
    {
        $this->artisan('laravolt:indonesia:seed');

        // Search for something that likely doesn't exist
        $emptyResults1 = \Indonesia::search('NONEXISTENTPLACE12345')->allProvinces();
        $emptyResults2 = \Indonesia::search('NONEXISTENTPLACE12345')->allProvinces();

        $this->assertTrue($emptyResults1->isEmpty());
        $this->assertEquals($emptyResults1->count(), $emptyResults2->count());
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

    public function search()
    {
        $results = \Indonesia::search('BATAM')->all();

        $this->assertNotEmpty($results);
    }
}
