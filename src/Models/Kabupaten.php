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

    protected $searchableColumn = ['id', 'name', 'provinsi.name'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_id');
    }
}
