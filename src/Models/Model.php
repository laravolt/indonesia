<?php

namespace Laravolt\Indonesia\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $keyType = 'string';

    function __construct()
    {
    	$this->table = config('laravolt.indonesia.table_prefix') . $this->table;
    }

    public function scopeSearch($query, $location)
    {
    	return $query->where('name', 'like', '%'.$location.'%');
    }
}
