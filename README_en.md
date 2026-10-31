[![run-tests](https://github.com/laravolt/indonesia/actions/workflows/run-tests.yml/badge.svg)](https://github.com/laravolt/indonesia/actions/workflows/run-tests.yml)
[![StyleCI](https://github.styleci.io/repos/63410706/shield?branch=master)](https://github.styleci.io/repos/63410706)

# LARAVOLT INDONESIA

[Bahasa Indonesia](README.md)

A Laravel package with every Indonesian province, regency/city, district and village, plus Eloquent models, seeders and a facade to query them.

## Data source

Region codes and names follow **Kepmendagri No. 300.2.2-2138 of 2025** (the Ministry of Home Affairs decree on region codes and data): 38 provinces, 514 regencies/cities, 7,285 districts and 83,762 villages. Its amendment, Kepmendagri No. 300.2.2-2430 of 2025, only changes island data. Names are cross-checked against [cahyadsn/wilayah](https://github.com/cahyadsn/wilayah) (MIT). Early versions of this package used data from [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia).

## Requirements

- PHP 8.3 or later
- Laravel 12.68+ or 13.29+

## Installation

```bash
composer require laravolt/indonesia
```

The service provider and the `Indonesia` facade are registered automatically.

### Configuration (optional)

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=config
```

This creates `config/laravolt/indonesia.php`. Every value is read from `laravolt.indonesia.*`, and some can be set in `.env`:

| Key | `.env` | Default | Purpose |
|---|---|---|---|
| `table_prefix` | | `indonesia_` | Table name prefix |
| `database.connection` | `INDONESIA_DB_CONNECTION` | the app's default connection | Keep region data in a separate database |
| `cache.store` | `INDONESIA_CACHE_STORE` | the app's default cache store | Store for query results |
| `cache.ttl` | `INDONESIA_CACHE_TTL` | `3600` | Cache lifetime in seconds |
| `cache.prefix` | `INDONESIA_CACHE_PREFIX` | `indonesia_service` | Cache key prefix |
| `route.enabled` | | `false` | Enable the region management pages |
| `menu.enabled` | | `false` | Show their menu in the Laravolt sidebar |

To use a separate connection, define it in `config/database.php` first. Models, migrations and seeders all use it.

### Migrations

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=migrations
php artisan migrate
```

### Seeding the regions

```bash
php artisan laravolt:indonesia:seed
```

The seeder is safe to run again. It adds new rows and updates the names of existing ones to the latest data. It leaves `id` and the `meta` column (coordinates) unchanged.

To run it from your `DatabaseSeeder`:

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

## Usage

```php
use Laravolt\Indonesia\Facade as Indonesia; // or the global \Indonesia alias

Indonesia::allProvinces();
Indonesia::paginateProvinces($numRows = 15);
Indonesia::allCities();
Indonesia::paginateCities($numRows = 15);
Indonesia::allDistricts();
Indonesia::paginateDistricts($numRows = 15);
Indonesia::allVillages();
Indonesia::paginateVillages($numRows = 15);
```

### Finding one region with its relations

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

Example:

```php
$aceh = Indonesia::findProvince(11, ['cities']);

$aceh->name;            // "ACEH"
$aceh->cities->count(); // 23
```

### Search

```php
Indonesia::search('jakarta')->all();               // provinces, cities, districts and villages together
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

The results of `all*()`, `find*()` and `search()` are cached for `cache.ttl` seconds. The package stores plain arrays and rebuilds the models on read, so this works on Laravel 13 (`cache.serializable_classes = false`) with any store. `paginate*()` results are not cached.

```php
Indonesia::clearCache();                                   // clear this package's cache
Indonesia::clearCacheFor('find_province', ['id' => 11, 'with' => ['cities']]);
```

On a store other than Redis, `clearCache()` flushes the **whole** store. Use a dedicated store (`INDONESIA_CACHE_STORE`) if that matters.

## Testing

```bash
composer install
vendor/bin/phpunit
```

## License

MIT
