<?php

namespace Laravolt\Indonesia\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
	public function district()
	{
	    return $this->belongsTo('Laravolt\Indonesia\Models\District', 'district_id');
	}
     
}
