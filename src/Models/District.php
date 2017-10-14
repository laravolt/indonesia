<?php

namespace Laravolt\Indonesia\Models;

class District extends Model
{
	protected $table = 'districts';

    public $timestamps = false;

    public function city()
	{
	    return $this->belongsTo('Laravolt\Indonesia\Models\City', 'city_id');
	}

	public function villages()
    {
        return $this->hasMany('Laravolt\Indonesia\Models\Village', 'district_id');
    }

    public function getNameAttribute()
    {
        return title_case($this->attributes['name']);
    }

    public function getCityNameAttribute()
    {
        return title_case($this->city->name);
    }

    public function getProvinceNameAttribute()
    {
        return title_case($this->city->province->name);
    }
}
