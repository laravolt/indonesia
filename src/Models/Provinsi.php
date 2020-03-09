<?php

namespace Laravolt\Indonesia\Models;

class Provinsi extends Province
{
    protected $table = 'provinces';

    protected $guarded = [];

    public function getAddressAttribute()
    {
        return sprintf(
            '%s, Indonesia',
            $this->name
        );
    }
}
