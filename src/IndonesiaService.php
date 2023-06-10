<?php

namespace Laravolt\Indonesia;

class IndonesiaService
{
    protected $search;

    public function search($location)
    {
        $this->search = strtoupper($location);

        return $this;
    }

    public function all()
    {
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
    }

    public function allProvinces()
    {
        if ($this->search) {
            return Models\Province::search($this->search)->get();
        }

        return Models\Province::all();
    }

    public function paginateProvinces($numRows = 15)
    {
        if ($this->search) {
            return Models\Province::search($this->search)->paginate();
        }

        return Models\Province::paginate($numRows);
    }

    public function allCities()
    {
        if ($this->search) {
            return Models\City::search($this->search)->get();
        }

        return Models\City::all();
    }

    public function paginateCities($numRows = 15)
    {
        if ($this->search) {
            return Models\City::search($this->search)->paginate();
        }

        return Models\City::paginate($numRows);
    }

    public function allDistricts()
    {
        if ($this->search) {
            return Models\District::search($this->search)->get();
        }

        return Models\District::all();
    }

    public function paginateDistricts($numRows = 15)
    {
        if ($this->search) {
            return Models\District::search($this->search)->paginate();
        }

        return Models\District::paginate($numRows);
    }

    public function allVillages()
    {
        if ($this->search) {
            return Models\Village::search($this->search)->get();
        }

        return Models\Village::all();
    }

    public function paginateVillages($numRows = 15)
    {
        if ($this->search) {
            return Models\Village::search($this->search)->paginate();
        }

        return Models\Village::paginate($numRows);
    }

    public function findProvince($provinceId, $with = null, $whereCode = false)
    {
        $with = (array) $with;

        if ($with) {
            $withVillages = array_search('villages', $with);

            if ($withVillages !== false) {
                unset($with[$withVillages]);

                if (!$whereCode) {
                    $province = Models\Province::with($with)->find($provinceId);
                }
                else {
                    $province = Models\Province::with($with)->where('code', $provinceId)->firstOrFail();
                }

                $province = $this->loadRelation($province, 'cities.districts.villages');
            } else {
                if (!$whereCode) {
                    $province = Models\Province::with($with)->find($provinceId);
                }
                else {
                    $province = Models\Province::with($with)->where('code', $provinceId)->firstOrFail();
                }
            }

            return $province;
        }

        if (!$whereCode) {
            return Models\Province::find($provinceId);
        }
        else {
            return Models\Province::where('code', $provinceId)->firstOrFail();
        }

    }

    public function findCity($cityId, $with = null, $whereCode = false)
    {
        $with = (array) $with;

        if ($with) {
            if (!$whereCode) {
                return Models\City::with($with)->find($cityId);
            }
            else {
                return Models\City::with($with)->where('code', $cityId)->firstOrFail();
            }
        }

        if (!$whereCode) {
            return Models\City::find($cityId);
        }
        else {
            return Models\City::where('code', $cityId)->firstOrFail();
        }
    }

    public function findDistrict($districtId, $with = null, $whereCode = false)
    {
        $with = (array) $with;

        if ($with) {
            $withProvince = array_search('province', $with);

            if ($withProvince !== false) {
                unset($with[$withProvince]);

                if (!$whereCode) {
                    $district = Models\District::with($with)->find($districtId);
                }
                else {
                    $district = Models\District::with($with)->where('code', $districtId)->firstOrFail();
                }

                $district = $this->loadRelation($district, 'city.province', true);
            } else {
                if (!$whereCode) {
                    $district = Models\District::with($with)->find($districtId);
                }
                else {
                    $district = Models\District::with($with)->where('code', $districtId)->firstOrFail();
                }
            }

            return $district;
        }

        if (!$whereCode) {
            return Models\District::find($districtId);
        }
        else {
            return Models\District::where('code', $districtId)->firstOrFail();
        }
    }

    public function findVillage($villageId, $with = null, $whereCode = false)
    {
        $with = (array) $with;

        if ($with) {
            $withCity = array_search('city', $with);
            $withProvince = array_search('province', $with);

            if ($withCity !== false && $withProvince !== false) {
                unset($with[$withCity]);
                unset($with[$withProvince]);

                if (!$whereCode) {
                    $village = Models\Village::with($with)->find($villageId);
                }
                else {
                    $village = Models\Village::with($with)->where('code', $villageId)->firstOrFail();
                }

                $village = $this->loadRelation($village, 'district.city', true);

                $village = $this->loadRelation($village, 'district.city.province', true);
            } elseif ($withCity !== false) {
                unset($with[$withCity]);

                if (!$whereCode) {
                    $village = Models\Village::with($with)->find($villageId);
                }
                else {
                    $village = Models\Village::with($with)->where('code', $villageId)->firstOrFail();
                }

                $village = $this->loadRelation($village, 'district.city', true);
            } elseif ($withProvince !== false) {
                unset($with[$withProvince]);

                if (!$whereCode) {
                    $village = Models\Village::with($with)->find($villageId);
                }
                else {
                    $village = Models\Village::with($with)->where('code', $villageId)->firstOrFail();
                }

                $village = $this->loadRelation($village, 'district.city.province', true);
            } else {
                if (!$whereCode) {
                    $village = Models\Village::with($with)->find($villageId);
                }
                else {
                    $village = Models\Village::with($with)->where('code', $villageId)->firstOrFail();
                }
            }

            return $village;
        }

        if (!$whereCode) {
            return Models\Village::find($villageId);
        }
        else {
            return Models\Village::where('code', $villageId)->firstOrFail();
        }
    }

    private function loadRelation($object, $relation, $belongsTo = false)
    {
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
