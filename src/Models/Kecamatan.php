<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Suitable\AutoFilter;
use Laravolt\Suitable\AutoSort;

class Kecamatan extends District
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'districts';

    protected $guarded = [];

    protected $searchableColumn = ['id', 'name', 'kabupaten.name'];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'city_id');
    }
}
