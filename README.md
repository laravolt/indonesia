# LARAVOLT INDONESIA

Package Laravel yang berisi data Provinsi, Kabupaten/Kota, dan Kecamatan/Desa di seluruh Indonesia.  
Data wilayah diambil dari [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia)

## Instalasi

`composer require laravolt/indonesia`

Tambahkan Service Provider dan Facade pada `config.app`

```
'providers' => [

    Laravolt\Indonesia\ServiceProvider::class

]
```

```
'aliases' => [

    'Indonesia' => Laravolt\Indonesia\Facade::class

]
```

```
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"
```
```
php artisan migrate
```
```
php artisan laravolt:indonesia:seed
```

## Penggunaan

`Indonesia::allProvinces()`  
`Indonesia::paginateProvinces($numRows = 15)`  
`Indonesia::allCities()`  
`Indonesia::paginateCities($numRows = 15)`  
`Indonesia::allDistricts()`  
`Indonesia::paginateDistricts($numRows = 15)`  
`Indonesia::allVillages()`  
`Indonesia::paginateVillages($numRows = 15)`  

---

`Indonesia::findProvince($provinceId, $with = null)`  
`array $with` : `cities, districts, villages, cities.districts, cities.districts.villages, districts.villages`

`Indonesia::findCity($cityId, $with = null)`  
`array $with` : `province, districts, villages, districts.villages`

`Indonesia::findDistrict($districtId, $with = null)`  
`array $with`: `province, city, city.province, villages`

`Indonesia::findVillage($villageId, $with = null)`  
`array $with`: `province, city, district, district.city, district.city.province`

#### Examples

```php
Indonesia::findProvince(11, ['cities']);

/*
Will return
Province Object {
    'id' => 11,
    'name' => 'ACEH',
    'cities' => City Collections {
        City Object,
        City Object,
        City Object,
        ...
    }
}
*/

Indonesia::findProvince(11, ['cities', 'districts.villages'])

/*
Will return
Province Object {
    'id' => 11,
    'name' => 'ACEH',
    'cities' => City Collections {
        City Object,
        City Object,
        City Object,
        ...
    },
    'districts' => District Collections {
        District Object {
            'id' => 1101010
            'city_id' => '1101'
            'name' => 'TEUPAH SELATAN'
            'province_id' => '11'
            'villages' => Village Colletions {
                Village Object,
                Village Object,
                Village Object,
                ...
            }
        },
        ...
    }
}
*/
```
