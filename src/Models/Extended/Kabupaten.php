<?php

namespace Laravolt\Indonesia\Models\Extended;

use Laravolt\Support\Traits\AutoFilter;
use Laravolt\Support\Traits\AutoSort;

class Kabupaten extends \Laravolt\Indonesia\Models\Kabupaten
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'cities';
}
