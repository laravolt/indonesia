<?php

namespace Laravolt\Indonesia\Models;

class City extends Model
{
    protected $table = 'cities';

    public $timestamps = false;

    public function province()
	{
	    return $this->belongsTo('Laravolt\Indonesia\Models\Province', 'province_id');
	}

	public function districts()
    {
        return $this->hasMany('Laravolt\Indonesia\Models\District', 'city_id');
    }

    public function villages()
    {
        return $this->hasManyThrough('Laravolt\Indonesia\Models\Village', 'Laravolt\Indonesia\Models\District');
    }

    public function getNameAttribute()
    {
        return title_case($this->attributes['name']);
    }

    public function getProvinceNameAttribute()
    {
        return title_case($this->province->name);
    }

	public function getLogoPathAttribute()
    {
    	$folder = 'indonesia-logo/';
    	$id = $this->getAttributeValue('id');
     	$arr_glob = glob(public_path().'/'. $folder. $id.'.*');
     	if(count($arr_glob) == 1){
     		$logo_name = basename($arr_glob[0]);
     		$logo_path = url($folder.$logo_name);
     		return $logo_path;
     	}
     	return null;
    }
}
