<?php

namespace Laravolt\Indonesia;

use Closure;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class IndonesiaService
{
    protected $search;
    protected $cacheTtl;
    protected $cachePrefix;
    protected $cacheStore;

    /**
     * Bump when the cached payload format changes, so old entries are ignored.
     */
    private const CACHE_VERSION = 'v2';

    public function __construct($cacheTtl = null, $cachePrefix = null, $cacheStore = null)
    {
        $this->cacheTtl = $cacheTtl ?? config('laravolt.indonesia.cache.ttl');
        $this->cachePrefix = $cachePrefix ?? config('laravolt.indonesia.cache.prefix');
        $this->cacheStore = $cacheStore ?? config('laravolt.indonesia.cache.store');
    }

    private function cache()
    {
        return Cache::store($this->cacheStore);
    }

    /**
     * Cache plain arrays only and rebuild the models on read.
     *
     * Laravel 13 refuses to unserialize objects from the cache by default
     * (cache.serializable_classes = false), so cached models would come back
     * as __PHP_Incomplete_Class.
     */
    private function remember($cacheKey, Closure $callback)
    {
        $cached = $this->cache()->get($cacheKey);

        if (is_array($cached) && array_key_exists('payload', $cached)) {
            return $this->decode($cached['payload']);
        }

        $value = $callback();
        $this->cache()->put($cacheKey, ['payload' => $this->encode($value)], $this->cacheTtl);

        return $value;
    }

    private function encode($value)
    {
        if ($value instanceof Models\Model) {
            return [
                'model' => $value::class,
                'connection' => $value->getConnectionName(),
                'attributes' => array_map(fn ($attribute) => $this->encode($attribute), $value->getAttributes()),
                'relations' => array_map(fn ($relation) => $this->encode($relation), $value->getRelations()),
            ];
        }

        if ($value instanceof Collection) {
            return [
                'collection' => $value instanceof EloquentCollection ? 'eloquent' : 'support',
                'items' => $value->map(fn ($item) => $this->encode($item))->all(),
            ];
        }

        return $value;
    }

    private function decode($value)
    {
        if (!is_array($value)) {
            return $value;
        }

        if (isset($value['model']) && is_a($value['model'], Models\Model::class, true)) {
            $model = (new $value['model']())->newFromBuilder(
                array_map(fn ($attribute) => $this->decode($attribute), $value['attributes'] ?? []),
                $value['connection'] ?? null
            );

            foreach ($value['relations'] ?? [] as $name => $relation) {
                $model->setRelation($name, $this->decode($relation));
            }

            return $model;
        }

        if (isset($value['collection'], $value['items'])) {
            $items = array_map(fn ($item) => $this->decode($item), $value['items']);

            return $value['collection'] === 'eloquent' ? new EloquentCollection($items) : collect($items);
        }

        return $value;
    }

    public function search($location)
    {
        $this->search = strtoupper($location);

        return $this;
    }

    public function setCacheTtl($ttl)
    {
        $this->cacheTtl = $ttl;

        return $this;
    }

    private function getCacheKey($method, $params = [])
    {
        $key = $this->cachePrefix.':'.self::CACHE_VERSION.':'.$method;

        if ($this->search) {
            $key .= ':search:'.$this->search;
        }

        if (!empty($params)) {
            $key .= ':'.md5(serialize($params));
        }

        return $key;
    }

    public function all()
    {
        $cacheKey = $this->getCacheKey('all');

        return $this->remember($cacheKey, function () {
            $result = collect([]);

            if ($this->search) {
                $provinces = Models\Province::search($this->search)->get();
                $cities = Models\City::search($this->search)->get();
                $districts = Models\District::search($this->search)->get();
                $villages = Models\Village::search($this->search)->get();
                $result->push($provinces);
                $result->push($cities);
                $result->push($districts);
                $result->push($villages);
            }

            return $result->collapse();
        });
    }

    public function allProvinces()
    {
        $cacheKey = $this->getCacheKey('provinces');

        return $this->remember($cacheKey, function () {
            if ($this->search) {
                return Models\Province::search($this->search)->get();
            }

            return Models\Province::all();
        });
    }

    public function paginateProvinces($numRows = 15)
    {
        // Note: Pagination results are typically not cached as they can vary by page
        // But we can cache the underlying query and paginate the cached results
        $cacheKey = $this->getCacheKey('provinces_paginate', ['rows' => $numRows]);

        if ($this->search) {
            return Models\Province::search($this->search)->paginate($numRows);
        }

        return Models\Province::paginate($numRows);
    }

    public function allCities()
    {
        $cacheKey = $this->getCacheKey('cities');

        return $this->remember($cacheKey, function () {
            if ($this->search) {
                return Models\City::search($this->search)->get();
            }

            return Models\City::all();
        });
    }

    public function paginateCities($numRows = 15)
    {
        if ($this->search) {
            return Models\City::search($this->search)->paginate($numRows);
        }

        return Models\City::paginate($numRows);
    }

    public function allDistricts()
    {
        $cacheKey = $this->getCacheKey('districts');

        return $this->remember($cacheKey, function () {
            if ($this->search) {
                return Models\District::search($this->search)->get();
            }

            return Models\District::all();
        });
    }

    public function paginateDistricts($numRows = 15)
    {
        if ($this->search) {
            return Models\District::search($this->search)->paginate($numRows);
        }

        return Models\District::paginate($numRows);
    }

    public function allVillages()
    {
        $cacheKey = $this->getCacheKey('villages');

        return $this->remember($cacheKey, function () {
            if ($this->search) {
                return Models\Village::search($this->search)->get();
            }

            return Models\Village::all();
        });
    }

    public function paginateVillages($numRows = 15)
    {
        if ($this->search) {
            return Models\Village::search($this->search)->paginate($numRows);
        }

        return Models\Village::paginate($numRows);
    }

    public function findProvince($provinceId, $with = null)
    {
        $cacheKey = $this->getCacheKey('find_province', ['id' => $provinceId, 'with' => $with]);

        return $this->remember($cacheKey, function () use ($provinceId, $with) {
            $with = (array) $with;

            if ($with) {
                $withVillages = array_search('villages', $with);

                if ($withVillages !== false) {
                    unset($with[$withVillages]);

                    $province = Models\Province::with($with)->find($provinceId);
                    $province = $this->loadRelation($province, 'cities.districts.villages');
                } else {
                    $province = Models\Province::with($with)->find($provinceId);
                }

                return $province;
            }

            return Models\Province::find($provinceId);
        });
    }

    public function findCity($cityId, $with = null)
    {
        $cacheKey = $this->getCacheKey('find_city', ['id' => $cityId, 'with' => $with]);

        return $this->remember($cacheKey, function () use ($cityId, $with) {
            $with = (array) $with;

            if ($with) {
                return Models\City::with($with)->find($cityId);
            }

            return Models\City::find($cityId);
        });
    }

    public function findDistrict($districtId, $with = null)
    {
        $cacheKey = $this->getCacheKey('find_district', ['id' => $districtId, 'with' => $with]);

        return $this->remember($cacheKey, function () use ($districtId, $with) {
            $with = (array) $with;

            if ($with) {
                $withProvince = array_search('province', $with);

                if ($withProvince !== false) {
                    unset($with[$withProvince]);

                    $district = Models\District::with($with)->find($districtId);
                    $district = $this->loadRelation($district, 'city.province', true);
                } else {
                    $district = Models\District::with($with)->find($districtId);
                }

                return $district;
            }

            return Models\District::find($districtId);
        });
    }

    public function findVillage($villageId, $with = null)
    {
        $cacheKey = $this->getCacheKey('find_village', ['id' => $villageId, 'with' => $with]);

        return $this->remember($cacheKey, function () use ($villageId, $with) {
            $with = (array) $with;

            if ($with) {
                $withCity = array_search('city', $with);
                $withProvince = array_search('province', $with);

                if ($withCity !== false && $withProvince !== false) {
                    unset($with[$withCity]);
                    unset($with[$withProvince]);

                    $village = Models\Village::with($with)->find($villageId);
                    $village = $this->loadRelation($village, 'district.city', true);
                    $village = $this->loadRelation($village, 'district.city.province', true);
                } elseif ($withCity !== false) {
                    unset($with[$withCity]);

                    $village = Models\Village::with($with)->find($villageId);
                    $village = $this->loadRelation($village, 'district.city', true);
                } elseif ($withProvince !== false) {
                    unset($with[$withProvince]);

                    $village = Models\Village::with($with)->find($villageId);
                    $village = $this->loadRelation($village, 'district.city.province', true);
                } else {
                    $village = Models\Village::with($with)->find($villageId);
                }

                return $village;
            }

            return Models\Village::find($villageId);
        });
    }

    public function clearCache()
    {
        $pattern = $this->cachePrefix.':*';

        // If using Redis
        if ($this->cache()->getStore() instanceof \Illuminate\Cache\RedisStore) {
            $keys = $this->cache()->getRedis()->keys($pattern);
            if (!empty($keys)) {
                $this->cache()->getRedis()->del($keys);
            }
        } else {
            // For other cache drivers, you might need to implement differently
            // or use cache tags if supported
            $this->cache()->flush(); // This clears ALL cache, use carefully
        }

        return $this;
    }

    public function clearCacheFor($method, $params = [])
    {
        $cacheKey = $this->getCacheKey($method, $params);
        $this->cache()->forget($cacheKey);

        return $this;
    }

    public function getCached($method, $params = [])
    {
        $cacheKey = $this->getCacheKey($method, $params);

        $cached = $this->cache()->get($cacheKey);

        return is_array($cached) && array_key_exists('payload', $cached) ? $this->decode($cached['payload']) : null;
    }

    public function isCached($method, $params = [])
    {
        $cacheKey = $this->getCacheKey($method, $params);

        return $this->cache()->has($cacheKey);
    }

    private function loadRelation($object, $relation, $belongsTo = false)
    {
        if (!$object) {
            return $object;
        }

        $exploded = explode('.', $relation);
        $targetRelationName = end($exploded);

        // We need to clone it first because $object->load() below will call related relation.
        // I don't know why
        $newObject = clone $object;

        // https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
        // because Eloquent hasManyThrough cannot get through more than one deep relationship
        $object->load([$relation => function ($q) use (&$createdValue, $belongsTo) {
            if ($belongsTo) {
                $createdValue = $q->first();
            } else {
                $createdValue = $q->get()->unique();
            }
        }]);

        $newObject[$targetRelationName] = $createdValue;

        return $newObject;
    }
}
