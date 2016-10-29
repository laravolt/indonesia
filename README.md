# LARAVOLT INDONESIA

Package Laravel yang berisi data Provinsi, Kabupaten/Kota, dan Kecamatan/Desa di seluruh Indonesia.  
Data wilayah diambil dari [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia)

## Instalasi

### Install dan Daftarkan Package
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

### Publish Migration (Hanya Untuk Laravel 5.2)
Jika Anda menggunakan Laravel versi 5.3, abaikan langkah di bawah ini.
```
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"
```

### Jalankan Migration
```
php artisan migrate
```

### Jalankan Seeder Untuk Mengisi Data Wilayah
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

---

`Indonesia::search('jakarta')->all()`  
`Indonesia::search('jakarta')->allProvinces()`  
`Indonesia::search('jakarta')->paginateProvinces()`  
`Indonesia::search('jakarta')->allCities()`  
`Indonesia::search('jakarta')->paginateCities()`  
`Indonesia::search('jakarta')->allDistricts()`  
`Indonesia::search('jakarta')->paginateDistricts()`  
`Indonesia::search('jakarta')->allVillages()`  
`Indonesia::search('jakarta')->paginateVillages()`  

---

# Testing

Run

```
vendor/bin/phpunit tests
```
