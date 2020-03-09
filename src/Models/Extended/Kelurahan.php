<?php

namespace Laravolt\Indonesia\Models\Extended;

use Laravolt\Support\Traits\AutoFilter;
use Laravolt\Support\Traits\AutoSort;

class Kelurahan extends \Laravolt\Indonesia\Models\Kelurahan
{
    use AutoFilter;
    use AutoSort;

    protected $table = 'villages';
}
