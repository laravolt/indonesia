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

    public function findProvince($provinceId, $with = null)
    {
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
    }

    public function findCity($cityId, $with = null)
    {
        $with = (array) $with;

        if ($with) {
            return Models\City::with($with)->find($cityId);
        }

        return Models\City::find($cityId);
    }

    public function findDistrict($districtId, $with = null)
    {
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
    }

    public function findVillage($villageId, $with = null)
    {
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
