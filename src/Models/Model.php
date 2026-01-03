<?php

namespace Laravolt\Indonesia\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $keyType = 'string';

    protected $searchableColumns = ['code', 'name'];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $guarded = [];

    public $timestamps = false;

    public function getConnectionName()
    {
        return config('indonesia.database.connection')
            ?: parent::getConnectionName();
    }

    public function getTable(): string
    {
        $table = parent::getTable();
        $prefix = config('laravolt.indonesia.table_prefix');

        // ✅ idempotent — prefix only once
        if (str_starts_with($table, $prefix)) {
            return $table;
        }

        return $prefix.$table;
    }

    public function scopeSearch($query, $keyword)
    {
        if ($keyword && $this->searchableColumns) {
            $query->whereLike($this->searchableColumns, $keyword);
        }
    }
}
