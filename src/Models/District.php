<?php

namespace Laravolt\Indonesia\Models;

class District extends Model
{
    protected $table = 'districts';

    protected $casts = [
        'meta' => 'array',
    ];

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('Laravolt\Indonesia\Models\City', 'city_code', 'code');
    }

    public function villages()
    {
        return $this->hasMany('Laravolt\Indonesia\Models\Village', 'district_code', 'code');
    }

    public function getCityNameAttribute()
    {
        return $this->city->name;
    }

    public function getProvinceNameAttribute()
    {
        return $this->city->province->name;
    }
}
