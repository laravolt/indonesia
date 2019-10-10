<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Suitable\AutoFilter;
use Laravolt\Suitable\AutoSort;

class Kabupaten extends City
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'cities';

    protected $guarded = [];

    protected $searchableColumns = ['id', 'name', 'provinsi.name'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_id');
    }

    public function getAddressAttribute()
    {
        return sprintf(
            '%s, %s, Indonesia',
            $this->name,
            $this->provinsi->name
        );
    }
}
