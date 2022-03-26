<?php

namespace KodePandai\Indonesia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Province extends Model
{
    use HasRelationships;

    protected $primaryKey = 'code';

    protected $fillable = [
        'code', 'name', 'latitude', 'longitude',
    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        if (empty($this->table)) {
            $this->setTable(config('indonesia.table_prefix').'provinces');
        }

        parent::__construct($attributes);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function districts(): HasManyThrough
    {
        return $this->hasManyThrough(District::class, City::class);
    }

    public function villages(): HasManyDeep
    {
        return $this->hasManyDeep(Village::class, [City::class, District::class]);
    }
}
