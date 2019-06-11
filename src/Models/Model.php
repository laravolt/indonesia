<?php

namespace Laravolt\Indonesia\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $keyType = 'string';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    	$this->table = config('laravolt.indonesia.table_prefix') . $this->table;
    }

    public function scopeSearch($query, $location)
    {
    	return $query->where('name', 'like', '%'.$location.'%');
    }
}
