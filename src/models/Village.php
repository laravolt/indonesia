<?php

namespace Laravolt\Indonesia\Models;

class Village extends Model
{
	protected $table = 'villages';

	public function district()
	{
	    return $this->belongsTo('Laravolt\Indonesia\Models\District', 'district_id');
	}

}
