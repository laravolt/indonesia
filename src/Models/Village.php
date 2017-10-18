<?php

namespace Laravolt\Indonesia\Models;

class Village extends Model
{
	protected $table = 'villages';

    public $timestamps = false;

	public function district()
	{
	    return $this->belongsTo('Laravolt\Indonesia\Models\District', 'district_id');
	}

	public function getNameAttribute()
    {
        return title_case($this->attributes['name']);
    }

	public function getDistrictNameAttribute()
    {
        return title_case($this->district->name);
    }

	public function getCityNameAttribute()
    {
        return title_case($this->district->city->name);
    }

	public function getProvinceNameAttribute()
    {
        return title_case($this->district->city->province->name);
    }
}
