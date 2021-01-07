[![StyleCI](https://github.styleci.io/repos/63410706/shield?branch=master)](https://github.styleci.io/repos/63410706)
[![Build Status](https://travis-ci.org/laravolt/indonesia.svg?branch=master)](https://travis-ci.org/laravolt/indonesia)
[![Coverage Status](https://coveralls.io/repos/github/laravolt/indonesia/badge.svg?branch=master)](https://coveralls.io/github/laravolt/indonesia?branch=master)
# LARAVOLT INDONESIA

Package Laravel yang berisi data Provinsi, Kabupaten/Kota, dan Kecamatan/Desa di seluruh Indonesia.
Data wilayah diambil dari [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia)

## Instalasi

### Install Package Via Composer
`composer require laravolt/indonesia`

### Daftarkan Service Provider dan Facade (Untuk Laravel < 5.5)

Mulai versi 5.5 ke atas, Laravel sudah support fitur auto discover sehingga tidak perlu lagi mendaftarkan Service Provider dan Facade secara manual.

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

### Daftarkan Service Provider dan Facade untuk Lumen
Dalam file `bootstrap/app.php`, uncomment baris berikut
```
$app->withFacades();
$app->withEloquent();
```

Dalam file `bootstrap/app.php`, daftarkan service provider dan alias/facade dengan menambahkan kode berokut.
```
$app->register(Laravolt\Indonesia\ServiceProvider::class);


// class aliases
class_alias(Laravolt\Indonesia\Facade::class, 'Indonesia');
```

Untuk mengatur prefix tabel, buat file `config/laravolt.php`, lalu copy kode berikut (ganti `indonesia_` dengan nilai prefix tabel yang diinginkan),
```
<?php

return [
    'indonesia' => [
        'table_prefix' => 'id_',
    ],
];
```
Lalu daftarkan konfigurasi dalam `bootstrap/app.php` dengan menambahkan kode berikut.
```
$app->configure('laravolt');
```

Untuk selanjutnya, konfigurasi bisa dipanggil dengan cara `config('laravolt.indonesia.table_prefix')`.

### Publish Migration (Hanya Untuk Laravel/Lumen 5.2)

Jika Anda menggunakan Laravel/Lumen versi 5.3 ke atas, abaikan langkah di bawah ini.
Untuk Laravel:
```
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"
```
Untuk Lumen, file migrations harus di-copy manual dari direktori `vendor/laravolt/indonesia/database/migrations` atau [Migrations](database/migrations/)

### Jalankan Migration
```
php artisan migrate
```

### Jalankan Seeder Untuk Mengisi Data Wilayah
```
php artisan laravolt:indonesia:seed
```

## Penggunaan

`\Indonesia::allProvinces()`
`\Indonesia::paginateProvinces($numRows = 15)`
`\Indonesia::allCities()`
`\Indonesia::paginateCities($numRows = 15)`
`\Indonesia::allDistricts()`
`\Indonesia::paginateDistricts($numRows = 15)`
`\Indonesia::allVillages()`
`\Indonesia::paginateVillages($numRows = 15)`

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

Indonesia::findProvince(11, ['cities', 'districts.villages']);

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
