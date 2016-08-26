<?php

namespace Laravolt\Indonesia\Models;

class District extends Model
{
	protected $table = 'districts';

    public function city()
	{
	    return $this->belongsTo('Laravolt\Indonesia\Models\City', 'city_id');
	}

	public function villages()
    {
        return $this->hasMany('Laravolt\Indonesia\Models\Village', 'district_id');
    }
}
