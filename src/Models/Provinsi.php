<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Suitable\AutoFilter;
use Laravolt\Suitable\AutoSort;

class Provinsi extends Province
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'provinces';

    protected $guarded = [];
}
