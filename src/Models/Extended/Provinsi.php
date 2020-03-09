<?php

namespace Laravolt\Indonesia\Models\Extended;

use Laravolt\Support\Traits\AutoFilter;
use Laravolt\Support\Traits\AutoSort;

class Provinsi extends \Laravolt\Indonesia\Models\Provinsi
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'provinces';
}
