<?php

namespace Laravolt\Indonesia\Test;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;
use Laravolt\Indonesia\IndonesiaService;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;
use PHPUnit\Framework\Attributes\Test;

class CacheTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        // A persistent store that, like Laravel 13's default, refuses to unserialize objects.
        $app['config']->set('cache.serializable_classes', false);
        $app['config']->set('cache.default', 'file');
        $app['config']->set('laravolt.indonesia.cache.store', 'file');
    }

    public function setUp(): void
    {
        parent::setUp();

        Cache::store('file')->flush();
        $this->artisan('laravolt:indonesia:seed');
    }

    #[Test]
    public function it_reads_the_cache_settings_from_the_laravolt_namespace()
    {
        config()->set('laravolt.indonesia.cache.prefix', 'custom_prefix');

        \Indonesia::clearResolvedInstance('indonesia');
        \Indonesia::allProvinces();

        $this->assertTrue(Cache::store('file')->has('custom_prefix:v2:provinces'));
    }

    #[Test]
    public function it_restores_models_and_relations_from_a_persistent_cache()
    {
        $province = Province::first();

        $fresh = (new IndonesiaService())->findProvince($province->id, ['cities', 'villages']);
        $cached = (new IndonesiaService())->findProvince($province->id, ['cities', 'villages']);

        $this->assertInstanceOf(Province::class, $cached);
        $this->assertTrue($cached->exists);
        $this->assertSame($fresh->toJson(), $cached->toJson());
        $this->assertInstanceOf(EloquentCollection::class, $cached->cities);
        $this->assertInstanceOf(City::class, $cached->cities->first());

        $provinces = (new IndonesiaService())->allProvinces();
        $this->assertInstanceOf(EloquentCollection::class, (new IndonesiaService())->allProvinces());
        $this->assertSame($provinces->count(), Province::count());
    }

    #[Test]
    public function it_stores_only_plain_values_in_the_cache()
    {
        $provinceId = Province::first()->id;
        (new IndonesiaService())->findProvince($provinceId, ['cities']);
        (new IndonesiaService())->search('JAKARTA')->all();

        $values = [
            (new IndonesiaService())->getCached('find_province', ['id' => $provinceId, 'with' => ['cities']]),
        ];

        foreach (glob(storage_path('framework/cache/data/*/*/*')) as $file) {
            $values[] = file_get_contents($file);
        }

        foreach (array_slice($values, 1) as $raw) {
            $this->assertStringNotContainsString('O:', substr($raw, 10));
        }

        $this->assertInstanceOf(Province::class, $values[0]);
    }
}
