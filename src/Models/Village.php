<?php

namespace Laravolt\Indonesia\Models;

class Village extends Model
{
    protected $table = 'villages';

    protected $searchableColumns = ['code', 'name', 'district.name'];

    public function district()
    {
        return $this->belongsTo('Laravolt\Indonesia\Models\District', 'district_code', 'code');
    }

    public function getDistrictNameAttribute()
    {
        return $this->district->name;
    }

    public function getCityNameAttribute()
    {
        return $this->district->city->name;
    }

    public function getProvinceNameAttribute()
    {
        return $this->district->city->province->name;
    }
}
