<?php

namespace Laravolt\Indonesia\Models;

class Kelurahan extends Village
{
    public function kecamatan()
    {
        return $this->district();
    }

    public function getAddressAttribute()
    {
        $this->load('kecamatan.kabupaten.provinsi');

        return sprintf(
            '%s, %s, %s, %s, Indonesia',
            $this->name,
            $this->kecamatan->name,
            $this->kecamatan->kabupaten->name,
            $this->kecamatan->kabupaten->provinsi->name
        );
    }
}
