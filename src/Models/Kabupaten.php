<?php

namespace Laravolt\Indonesia\Models;

class Kabupaten extends City
{
    protected $table = 'cities';

    protected $guarded = [];

    protected $searchableColumns = ['code', 'name', 'provinsi.name'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_code');
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
