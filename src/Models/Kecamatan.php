<?php

namespace Laravolt\Indonesia\Models;

class Kecamatan extends District
{
    protected $table = 'districts';

    protected $guarded = [];

    protected $searchableColumns = ['id', 'name', 'kabupaten.name'];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'city_id');
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
