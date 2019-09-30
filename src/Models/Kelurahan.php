<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Suitable\AutoFilter;
use Laravolt\Suitable\AutoSort;

class Kelurahan extends Village
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'villages';

    protected $guarded = [];

    protected $searchableColumn = ['id', 'name', 'kecamatan.name'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'district_id');
    }
}
