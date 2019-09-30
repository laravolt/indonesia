<?php

namespace Laravolt\Indonesia\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $keyType = 'string';

    protected $searchableColumns = ['id', 'name'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('laravolt.indonesia.table_prefix').$this->table;
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword && $this->searchableColumns) {
            $query->whereLike($this->searchableColumns, $keyword);
        }
    }
}
