<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Indonesia\Models\Traits\AddressTrait;

class Kecamatan extends District
{
    use AddressTrait;

    public function kabupaten()
    {
        return $this->city();
    }
}
