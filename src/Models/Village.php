<?php

namespace KodePandai\Indonesia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Village extends Model
{
    use HasRelationships;

    protected $primaryKey = 'code';

    protected $fillable = [
        'code', 'district_code', 'name', 'latitude', 'longitude', 'postal_code',
    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        if (empty($this->table)) {
            $this->setTable(config('indonesia.table_prefix') . 'villages');
        }

        parent::__construct($attributes);
    }

    public function province(): HasOneDeep
    {
        return $this->hasOneDeep(
            Province::class,
            [District::class, City::class],
            ['code', 'code', 'code'],
            ['district_code', 'city_code', 'province_code'],
        );
    }

    public function city(): HasOneThrough
    {
        return $this->hasOneThrough(
            City::class,
            District::class,
            'code',
            'code',
            'district_code',
            'city_code'
        );
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
