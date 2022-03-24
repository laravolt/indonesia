<?php

namespace Laravolt\Indonesia\Models\Traits;

/**
 * getAddressAttribute.
 */
trait AddressTrait
{
    public function getAddressAttribute()
    {
        switch (get_class($this)) {
            case 'Laravolt\Indonesia\Models\Kabupaten':
                $this->load('province');

                $address = sprintf('%s, %s', $this->name, $this->province_name);
                break;

            case 'Laravolt\Indonesia\Models\Kecamatan':
                $this->load('city.province');

                $address = sprintf('%s, %s, %s', $this->name, $this->city_name, $this->province_name);
                break;

            case 'Laravolt\Indonesia\Models\Kelurahan':
                $this->load('district.city.province');

                $data = [$this->name, $this->district_name, $this->city_name, $this->province_name];
                $address = vsprintf('%s, %s, %s, %s', $data);
                break;

            default:
                $address = $this->name;
                break;
        }

        return "$address, Indonesia";
    }
}
