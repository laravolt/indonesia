<?php

namespace Laravolt\Indonesia\Models;

use Laravolt\Indonesia\Models\Traits\AddressTrait;

class Kabupaten extends City
{
    use AddressTrait;

    public function provinsi()
    {
        return $this->province();
    }
}
