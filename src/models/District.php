<?php

namespace Laravolt\Indonesia\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function regency()
	{
	    return $this->belongsTo('Laravolt\Indonesia\Models\Regency', 'regency_id');
	}

	public function villages()
    {
        return $this->hasMany('Laravolt\Indonesia\Models\Village', 'district_id');
    }
}
