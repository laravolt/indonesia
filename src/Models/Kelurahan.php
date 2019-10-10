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

    protected $searchableColumns = ['id', 'name', 'kecamatan.name'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'district_id');
    }

    public function getAddressAttribute()
    {
        return sprintf(
            "%s, %s, %s, %s, Indonesia",
            $this->name,
            $this->kecamatan->name,
            $this->kecamatan->kabupaten->name,
            $this->kecamatan->kabupaten->provinsi->name
        );
    }
}
