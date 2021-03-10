<?php

namespace Laravolt\Indonesia\Models;

class Kecamatan extends District
{
    protected $table = 'districts';

    protected $guarded = [];

    protected $searchableColumns = ['code', 'name', 'kabupaten.name'];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'city_code');
    }

    public function getAddressAttribute()
    {
        return sprintf(
            '%s, %s, %s, Indonesia',
            $this->name,
            $this->kabupaten->name,
            $this->kabupaten->provinsi->name
        );
    }
}
