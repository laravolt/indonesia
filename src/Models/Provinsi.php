<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Support\Traits\AutoFilter;
use Laravolt\Support\Traits\AutoSort;

class Provinsi extends Province
{
    use AutoFilter;
    use AutoSort;

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
