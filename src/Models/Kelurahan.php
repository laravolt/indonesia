<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Indonesia\Models\Traits\AddressTrait;

class Kelurahan extends Village
{
    use AddressTrait;

    public function kecamatan()
    {
        return $this->district();
    }
}
