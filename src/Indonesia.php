<?php

namespace Laravolt\Indonesia;

class Indonesia
{
    public function allProvinces()
    {
        return Models\Province::all();
    }

    public function paginateProvinces($numRows = 15)
    {
        return Models\Province::paginate($numRows);
    }

    public function allCities()
    {
        return Models\Regency::all();
    }

    public function paginateCities($numRows = 15)
    {
        return Models\Regency::paginate($numRows);
    }

    public function allDistricts()
    {
        return Models\District::all();
    }

    public function paginateDistricts($numRows = 15)
    {
        return Models\District::paginate($numRows);
    }

    public function allVillages()
    {
        return Models\Village::all();
    }

    public function paginateVillages($numRows = 15)
    {
        return Models\Village::paginate($numRows);
    }

    public function findCitiesByProvince($provinceId)
    {
        return Models\Province::find($provinceId)->regencies;
    }

    public function findDistricsByRegency($cityId)
    {
        return Models\Regency::find($regencyId)->districts;
    }

    public function findVillagesByDistrict($districtId)
    {
        return Models\District::find($districtId)->villages;
    }



    public function findProvince($provinceId)
    {
        return Models\Province::find($provinceId);
    }

    public function findCity($cityId)
    {
        return Models\Regency::find($cityId);
    }

    public function findDistrict($districtId)
    {
        return Models\District::find($districtId);
    }

    public function findVillage($villageId)
    {
        return Models\Village::find($villageId);
    }



    public function findCityParents($cityId){
        $province = Models\Regency::find($cityId)->province;
        $parrents = collect(['province' => $province]);
        return $parrents;
    }

    public function findDistrictParents($districtId){
        $city = Models\District::find($districtId)->regency;
        $province = Models\Regency::find($city->id)->province;
        $parrents = collect(['city' =>  $city, 'province' =>  $province]);
        return $parrents;
    }

    public function findVillageParents($villageId){
        $district = Models\Village::find($villageId)->district;
        $city = Models\District::find($district->id)->regency;
        $province = Models\Regency::find($city->id)->province;
        $parrents = collect(['district' => $district, 'city' =>  $city, 'province' =>  $province]);
        return $parrents;
    }



    public function findProvinceChilds($provinceId){
        return Models\Province::where('id', $provinceId)->with('regencies.districts.villages')->get()[0];
    }

    public function findCityChilds($cityId){
        return Models\Regency::where('id', $cityId)->with('districts.villages')->get()[0];
    }

    public function findDistrictChilds($districtId){
        return Models\District::where('id', $districtId)->with('villages')->get()[0];
    }
}

