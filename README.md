[![StyleCI](https://github.styleci.io/repos/63410706/shield?branch=master)](https://github.styleci.io/repos/63410706)
[![Build Status](https://travis-ci.org/laravolt/indonesia.svg?branch=master)](https://travis-ci.org/laravolt/indonesia)
[![Coverage Status](https://coveralls.io/repos/github/laravolt/indonesia/badge.svg?branch=master)](https://coveralls.io/github/laravolt/indonesia?branch=master)

# LARAVOLT INDONESIA

Package Laravel yang berisi data Provinsi, Kabupaten/Kota, dan Kecamatan/Desa di seluruh Indonesia.
Data wilayah diambil dari [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia)

## Instalasi

### Install Package Via Composer

```
composer require laravolt/indonesia
```

### Daftarkan Service Provider dan Facade (Untuk Laravel < 5.5)

Mulai versi 5.5 ke atas, Laravel sudah support fitur auto discover sehingga tidak perlu lagi mendaftarkan Service Provider dan Facade secara manual.

Tambahkan Service Provider dan Facade pada `config.app`

```php
'providers' => [

    Laravolt\Indonesia\ServiceProvider::class

]
```

```php
'aliases' => [

    'Indonesia' => Laravolt\Indonesia\Facade::class

]
```

### Daftarkan Service Provider dan Facade untuk Lumen

Dalam file `bootstrap/app.php`, uncomment baris berikut

```php
$app->withFacades();
$app->withEloquent();
```

Dalam file `bootstrap/app.php`, daftarkan service provider dan alias/facade dengan menambahkan kode berikut.

```php
$app->register(Laravolt\Indonesia\ServiceProvider::class);


// class aliases
class_alias(Laravolt\Indonesia\Facade::class, 'Indonesia');
```

Untuk mengatur prefix tabel, buat file `config/laravolt.php`, lalu copy kode berikut (ganti `indonesia_` dengan nilai prefix tabel yang diinginkan),

```php
<?php

return [
    'indonesia' => [
        'table_prefix' => 'id_',
    ],
];
```

Lalu daftarkan konfigurasi dalam `bootstrap/app.php` dengan menambahkan kode berikut.

```php
$app->configure('laravolt');
```

Untuk selanjutnya, konfigurasi bisa dipanggil dengan cara `config('laravolt.indonesia.table_prefix')`.

### Publish Konfigurasi

Untuk mempublikasikan konfigurasi package:

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=config
```

File konfigurasi akan dibuat di:

```text
config/laravolt/indonesia.php
```

Semua konfigurasi runtime dibaca melalui namespace:

```php
config('laravolt.indonesia')
```

Contoh:

```php
config('laravolt.indonesia.table_prefix');
config('laravolt.indonesia.database.connection');
config('laravolt.indonesia.cache.data_format');
```

### Publish Migration

Package ini menyediakan struktur tabel untuk data provinsi, kota/kabupaten, kecamatan, dan desa/kelurahan. Jika Anda ingin menyimpan file migration di aplikasi dan mengontrolnya bersama migration lain, publish migration dengan:

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=migrations
```

File migration akan dipublish ke direktori:

```text
database/migrations
```

Untuk Lumen, file migrations harus di-copy manual dari direktori `vendor/laravolt/indonesia/database/migrations` atau [Migrations](database/migrations/).

### Jalankan Migration

Setelah migration tersedia, jalankan:

```bash
php artisan migrate
```

### Jalankan Seeder Untuk Mengisi Data Wilayah

Nilai utama package ini adalah data wilayah Indonesia. Setelah tabel dibuat, isi data wilayah dengan:

```bash
php artisan laravolt:indonesia:seed
```

### Untuk menambahkan seedernya ke file `DatabaseSeeder.php` ikuti contoh berikut:

```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
        ]);
    }
}

```

## Konfigurasi

Contoh konfigurasi utama:

```php
return [
    'table_prefix' => 'indonesia_',

    'cache' => [
        'ttl' => env('INDONESIA_CACHE_TTL', 3600),
        'prefix' => env('INDONESIA_CACHE_PREFIX', 'indonesia_service'),
        'store' => env('INDONESIA_CACHE_STORE', 'redis'),
        'data_format' => env('INDONESIA_CACHE_DATA_FORMAT', 'model'),
    ],

    'database' => [
        'connection' => env('INDONESIA_DB_CONNECTION', null),
    ],
];
```

### Konfigurasi Database

Secara default package menggunakan koneksi database default Laravel. Jika data Indonesia ingin disimpan di koneksi database khusus, set nilai berikut:

```env
INDONESIA_DB_CONNECTION=mysql
```

Konfigurasi tersebut dibaca melalui:

```php
config('laravolt.indonesia.database.connection')
```

### Konfigurasi Cache

Package ini menyimpan hasil query utama ke cache agar pemanggilan berikutnya lebih cepat.

```env
INDONESIA_CACHE_TTL=3600
INDONESIA_CACHE_PREFIX=indonesia_service
INDONESIA_CACHE_STORE=redis
INDONESIA_CACHE_DATA_FORMAT=model
```

Opsi `INDONESIA_CACHE_DATA_FORMAT` mendukung dua nilai:

| Nilai | Perilaku |
| --- | --- |
| `model` | Menyimpan Eloquent Model/Collection di cache. Ini adalah default dan mempertahankan perilaku lama. |
| `array` | Menyimpan data array biasa di cache. |

Gunakan `array` jika aplikasi Anda memakai Redis cache pada Laravel versi baru yang membatasi unserialize object PHP.

```env
INDONESIA_CACHE_DATA_FORMAT=array
```

Dengan konfigurasi tersebut:

- Redis menyimpan array data biasa.
- Public API tetap mengembalikan Eloquent Model/Collection.
- Kode lama tetap berjalan:

```php
Indonesia::allProvinces()->first()->name;
```

Contoh perbedaan isi cache:

```text
# data_format=model
O:39:"Illuminate\Database\Eloquent\Collection":...

# data_format=array
a:38:{i:0;a:6:{s:2:"id";i:1;s:4:"code";s:2:"11";s:4:"name";s:4:"ACEH";...}}
```

Setelah mengubah konfigurasi cache di `.env`, jalankan:

```bash
php artisan optimize:clear
php artisan cache:clear
```

Jika Redis masih berisi serialized Eloquent object seperti berikut:

```text
O:39:"Illuminate\Database\Eloquent\Collection":...
O:34:"Laravolt\Indonesia\Models\Province":...
```

Pastikan konfigurasi yang aktif adalah:

```php
config('laravolt.indonesia.cache.data_format'); // array
config('laravolt.indonesia.cache.store');       // redis
```

Lalu hapus key cache lama sesuai prefix aplikasi Anda:

```bash
redis-cli -n 1 del "indonesia_service:provinces"
```

Setelah cache dibuat ulang, payload Redis untuk mode `array` tidak boleh berisi nama class Eloquent seperti `Illuminate\Database\Eloquent\Collection` atau `Laravolt\Indonesia\Models\Province`.

## Penggunaan

```php
\Indonesia::allProvinces()
\Indonesia::paginateProvinces($numRows = 15)
\Indonesia::allCities()
\Indonesia::paginateCities($numRows = 15)
\Indonesia::allDistricts()
\Indonesia::paginateDistricts($numRows = 15)
\Indonesia::allVillages()
\Indonesia::paginateVillages($numRows = 15)
```

---

```php
\Indonesia::findProvince($provinceId, $with = null)
// array $with : ['cities', 'districts', 'villages', 'cities.districts', 'cities.districts.villages', 'districts.villages']

\Indonesia::findCity($cityId, $with = null)
// array $with : ['province', 'districts', 'villages', 'districts.villages']

Indonesia::findDistrict($districtId, $with = null)
// array $with : ['province', 'city', 'city.province', 'villages']

\Indonesia::findVillage($villageId, $with = null)
// array $with : ['province', 'city', 'district', 'district.city', 'district.city.province']
```

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

```php
\Indonesia::search('jakarta')->all()
\Indonesia::search('jakarta')->allProvinces()
\Indonesia::search('jakarta')->paginateProvinces()
\Indonesia::search('jakarta')->allCities()
\Indonesia::search('jakarta')->paginateCities()
\Indonesia::search('jakarta')->allDistricts()
\Indonesia::search('jakarta')->paginateDistricts()
\Indonesia::search('jakarta')->allVillages()
\Indonesia::search('jakarta')->paginateVillages()
```

---

# Testing

Run

```
vendor/bin/phpunit tests
```
