[![run-tests](https://github.com/laravolt/indonesia/actions/workflows/run-tests.yml/badge.svg)](https://github.com/laravolt/indonesia/actions/workflows/run-tests.yml)
[![StyleCI](https://github.styleci.io/repos/63410706/shield?branch=master)](https://github.styleci.io/repos/63410706)

# LARAVOLT INDONESIA

[English](README_en.md)

Package Laravel berisi data provinsi, kabupaten/kota, kecamatan, dan desa/kelurahan di seluruh Indonesia, lengkap dengan model Eloquent, seeder, dan facade untuk mengambil datanya.

## Sumber data

Kode dan nama wilayah mengikuti **Kepmendagri No. 300.2.2-2138 Tahun 2025** tentang Pemberian dan Pemutakhiran Kode, Data Wilayah Administrasi Pemerintahan, dan Pulau: 38 provinsi, 514 kabupaten/kota, 7.285 kecamatan, dan 83.762 desa/kelurahan. Perubahannya, Kepmendagri No. 300.2.2-2430 Tahun 2025, hanya menyangkut data pulau. Nama diperiksa silang dengan [cahyadsn/wilayah](https://github.com/cahyadsn/wilayah) (MIT). Versi awal paket ini memakai data [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia).

## Kebutuhan

- PHP 8.3 atau lebih baru
- Laravel 12.68+ atau 13.29+

## Instalasi

```bash
composer require laravolt/indonesia
```

Service provider dan facade `Indonesia` terdaftar otomatis.

### Konfigurasi (opsional)

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=config
```

Perintah ini membuat `config/laravolt/indonesia.php`. Semua nilai dibaca dari `laravolt.indonesia.*`, dan sebagian bisa diatur lewat `.env`:

| Kunci | `.env` | Bawaan | Keterangan |
|---|---|---|---|
| `table_prefix` | | `indonesia_` | Prefix nama tabel |
| `database.connection` | `INDONESIA_DB_CONNECTION` | koneksi bawaan aplikasi | Simpan data wilayah di database terpisah |
| `cache.store` | `INDONESIA_CACHE_STORE` | cache store bawaan aplikasi | Store untuk hasil query |
| `cache.ttl` | `INDONESIA_CACHE_TTL` | `3600` | Lama cache, dalam detik |
| `cache.prefix` | `INDONESIA_CACHE_PREFIX` | `indonesia_service` | Prefix kunci cache |
| `route.enabled` | | `false` | Aktifkan halaman pengelolaan data wilayah |
| `menu.enabled` | | `false` | Tampilkan menu-nya di sidebar Laravolt |

Bila memakai koneksi terpisah, definisikan dulu koneksinya di `config/database.php`. Model, migration, dan seeder semuanya memakai koneksi tersebut.

### Migration

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=migrations
php artisan migrate
```

### Mengisi data wilayah

```bash
php artisan laravolt:indonesia:seed
```

Seeder aman dijalankan ulang. Baris baru akan ditambahkan, dan nama wilayah yang sudah ada diperbarui sesuai data terbaru. `id` dan kolom `meta` (koordinat) tidak diubah.

Untuk menjalankannya dari `DatabaseSeeder`:

```php
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;

public function run(): void
{
    $this->call([
        ProvincesSeeder::class,
        CitiesSeeder::class,
        DistrictsSeeder::class,
        VillagesSeeder::class,
    ]);
}
```

## Penggunaan

```php
use Laravolt\Indonesia\Facade as Indonesia; // atau alias global \Indonesia

Indonesia::allProvinces();
Indonesia::paginateProvinces($numRows = 15);
Indonesia::allCities();
Indonesia::paginateCities($numRows = 15);
Indonesia::allDistricts();
Indonesia::paginateDistricts($numRows = 15);
Indonesia::allVillages();
Indonesia::paginateVillages($numRows = 15);
```

### Mencari satu wilayah beserta relasinya

```php
Indonesia::findProvince($provinceId, $with = null);
// $with: ['cities', 'districts', 'villages', 'cities.districts', 'cities.districts.villages', 'districts.villages']

Indonesia::findCity($cityId, $with = null);
// $with: ['province', 'districts', 'villages', 'districts.villages']

Indonesia::findDistrict($districtId, $with = null);
// $with: ['province', 'city', 'city.province', 'villages']

Indonesia::findVillage($villageId, $with = null);
// $with: ['province', 'city', 'district', 'district.city', 'district.city.province']
```

Contoh:

```php
$aceh = Indonesia::findProvince(11, ['cities']);

$aceh->name;           // "ACEH"
$aceh->cities->count(); // 23
```

### Pencarian

```php
Indonesia::search('jakarta')->all();               // provinsi, kota, kecamatan, dan desa sekaligus
Indonesia::search('jakarta')->allProvinces();
Indonesia::search('jakarta')->paginateProvinces();
Indonesia::search('jakarta')->allCities();
Indonesia::search('jakarta')->paginateCities();
Indonesia::search('jakarta')->allDistricts();
Indonesia::search('jakarta')->paginateDistricts();
Indonesia::search('jakarta')->allVillages();
Indonesia::search('jakarta')->paginateVillages();
```

### Cache

Hasil `all*()`, `find*()`, dan `search()` disimpan di cache selama `cache.ttl`. Yang disimpan berupa array biasa, lalu dibangun ulang menjadi model saat dibaca, sehingga aman untuk Laravel 13 (`cache.serializable_classes = false`) dengan store apa pun. Hasil `paginate*()` tidak di-cache.

```php
Indonesia::clearCache();                                   // hapus semua cache paket ini
Indonesia::clearCacheFor('find_province', ['id' => 11, 'with' => ['cities']]);
```

`clearCache()` pada store selain Redis mengosongkan **seluruh** store tersebut. Gunakan store terpisah (`INDONESIA_CACHE_STORE`) bila itu tidak diinginkan.

## Testing

```bash
composer install
vendor/bin/phpunit
```

## Lisensi

MIT
