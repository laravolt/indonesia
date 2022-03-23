<?php

namespace Laravolt\Indonesia\Models;

class Kecamatan extends District
{
    public function kabupaten()
    {
        return $this->city();
    }

    public function getAddressAttribute()
    {
        $this->load('kabupaten.provinsi');

        return sprintf(
            '%s, %s, %s, Indonesia',
            $this->name,
            $this->kabupaten->name,
            $this->kabupaten->provinsi->name
        );
    }
}
