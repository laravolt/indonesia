<?php

namespace KodePandai\Indonesia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class City extends Model
{
    protected $primaryKey = 'code';

    protected $fillable = [
        'code', 'province_code', 'name', 'latitude', 'longitude',
    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        if (empty($this->table)) {
            $this->setTable(config('indonesia.table_prefix').'cities');
        }

        parent::__construct($attributes);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    public function villages(): HasManyThrough
    {
        return $this->hasManyThrough(Village::class, District::class);
    }
}
