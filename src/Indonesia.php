<?php

namespace Laravolt\Indonesia;

class Indonesia
{
    public function getProvinces()
    {
        return Models\Province::all();
    }

    public function getProvincesPaginate($numRows = 15)
    {
        return Models\Province::paginate($numRows);
    }

    public function getCities()
    {
        return Models\Regency::all();
    }

    public function getCitiesPaginate($numRows = 15)
    {
        return Models\Regency::paginate($numRows);
    }

    public function getDistricts()
    {
        return Models\District::all();
    }

    public function getDistrictsPaginate($numRows = 15)
    {
        return Models\District::paginate($numRows);
    }

    public function getVillages()
    {
        return Models\Village::all();
    }

    public function getVillagesPaginate($numRows = 15)
    {
        return Models\Village::paginate($numRows);
    }

    public function getCitiesByProvince($provinceId)
    {
        return Models\Province::find($provinceId)->regencies;
    }

    public function getDistricsByRegency($cityId)
    {
        return Models\Regency::find($regencyId)->districts;
    }

    public function getVillagesByDistrict($districtId)
    {
        return Models\District::find($districtId)->villages;
    }



    public function getProvince($provinceId)
    {
        return Models\Province::find($provinceId);
    }

    public function getCity($cityId)
    {
        return Models\Regency::find($cityId);
    }

    public function getDistrict($districtId)
    {
        return Models\District::find($districtId);
    }

    public function getVillage($villageId)
    {
        return Models\Village::find($villageId);
    }



    public function getCityParents($cityId){
        $province = Models\Regency::find($cityId)->province;
        $parrents = collect(['province' => $province]);
        return $parrents;
    }

    public function getDistrictParents($districtId){
        $city = Models\District::find($districtId)->regency;
        $province = Models\Regency::find($city->id)->province;
        $parrents = collect(['city' =>  $city, 'province' =>  $province]);
        return $parrents;
    }

    public function getVillageParents($villageId){
        $district = Models\Village::find($villageId)->district;
        $city = Models\District::find($district->id)->regency;
        $province = Models\Regency::find($city->id)->province;
        $parrents = collect(['district' => $district, 'city' =>  $city, 'province' =>  $province]);
        return $parrents;
    }



    public function getProvinceChilds($provinceId){
        return Models\Province::where('id', $provinceId)->with('regencies.districts.villages')->get()[0];
    }

    public function getCityChilds($cityId){
        return Models\Regency::where('id', $cityId)->with('districts.villages')->get()[0];
    }

    public function getDistrictChilds($districtId){
        return Models\District::where('id', $districtId)->with('villages')->get()[0];
    }



}

