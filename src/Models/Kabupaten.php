<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Suitable\AutoFilter;
use Laravolt\Suitable\AutoSort;

class Kabupaten extends City
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'cities';

    protected $guarded = [];
}
