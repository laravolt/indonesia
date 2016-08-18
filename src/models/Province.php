<?php

namespace Laravolt\Indonesia\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function regencies()
    {
        return $this->hasMany('Laravolt\Indonesia\Models\Regency', 'province_id');
    }
}
