<?php

namespace Laravolt\Indonesia\Models;

class Kelurahan extends Village
{
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
            '%s, %s, %s, %s, Indonesia',
            $this->name,
            $this->kecamatan->name,
            $this->kecamatan->kabupaten->name,
            $this->kecamatan->kabupaten->provinsi->name
        );
    }
}
