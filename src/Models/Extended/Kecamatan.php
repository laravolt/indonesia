<?php

namespace Laravolt\Indonesia\Models\Extended;

use Laravolt\Support\Traits\AutoFilter;
use Laravolt\Support\Traits\AutoSort;

class Kecamatan extends \Laravolt\Indonesia\Models\Kecamatan
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'districts';
}
