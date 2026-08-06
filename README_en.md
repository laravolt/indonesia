# LARAVOLT INDONESIA

Laravel Package that contains Provinces Data, City/Districts, and Villages in Indonesia.
Data was taken from [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia)

## Installation

### Package Installation

Add Laravolt/Indonesia package with

`composer require laravolt/indonesia`

Add Facade and Service Provider in `config/app.php`

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

### Publish Configuration

Publish the package configuration with:

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=config
```

The configuration file will be published to:

```text
config/laravolt/indonesia.php
```

Runtime configuration is read from the `laravolt.indonesia` namespace:

```php
config('laravolt.indonesia')
```

Examples:

```php
config('laravolt.indonesia.table_prefix');
config('laravolt.indonesia.database.connection');
config('laravolt.indonesia.cache.data_format');
```

### Publish Migrations

This package provides table structures for provinces, cities/regencies, districts, and villages. If you want to keep the migration files inside your application and manage them with your own migrations, publish them with:

```bash
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag=migrations
```

The migration files will be published to:

```text
database/migrations
```

For Lumen, migration files must be copied manually from `vendor/laravolt/indonesia/database/migrations` or [Migrations](database/migrations/).

### Run Migration

After the migrations are available, run:

```bash
php artisan migrate
```

### Run Database Seeder to Populate the Database

The main value of this package is the Indonesia administrative area data. After the tables are created, populate them with:

```bash
php artisan laravolt:indonesia:seed
```

## Configuration

Main configuration example:

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

### Database Configuration

By default, this package uses Laravel's default database connection. To store Indonesia data in a dedicated connection, set:

```env
INDONESIA_DB_CONNECTION=mysql
```

The value is read from:

```php
config('laravolt.indonesia.database.connection')
```

### Cache Configuration

The package caches the main query results to make repeated calls faster.

```env
INDONESIA_CACHE_TTL=3600
INDONESIA_CACHE_PREFIX=indonesia_service
INDONESIA_CACHE_STORE=redis
INDONESIA_CACHE_DATA_FORMAT=model
```

`INDONESIA_CACHE_DATA_FORMAT` accepts two values:

| Value | Behavior |
| --- | --- |
| `model` | Stores Eloquent models/collections in cache. This is the default and preserves the existing behavior. |
| `array` | Stores plain array data in cache. |

Use `array` when your application uses Redis cache on newer Laravel versions that restrict unserializing PHP objects.

```env
INDONESIA_CACHE_DATA_FORMAT=array
```

With this configuration:

- Redis stores plain array data.
- The public API still returns Eloquent models/collections.
- Existing code keeps working:

```php
Indonesia::allProvinces()->first()->name;
```

Cache payload example:

```text
# data_format=model
O:39:"Illuminate\Database\Eloquent\Collection":...

# data_format=array
a:38:{i:0;a:6:{s:2:"id";i:1;s:4:"code";s:2:"11";s:4:"name";s:4:"ACEH";...}}
```

After changing cache configuration in `.env`, run:

```bash
php artisan optimize:clear
php artisan cache:clear
```

If Redis still contains serialized Eloquent objects like:

```text
O:39:"Illuminate\Database\Eloquent\Collection":...
O:34:"Laravolt\Indonesia\Models\Province":...
```

Make sure the active configuration is:

```php
config('laravolt.indonesia.cache.data_format'); // array
config('laravolt.indonesia.cache.store');       // redis
```

Then delete the old cache key according to your application prefix:

```bash
redis-cli -n 1 del "indonesia_service:provinces"
```

After the cache is rebuilt, the Redis payload for `array` mode should not contain Eloquent class names such as `Illuminate\Database\Eloquent\Collection` or `Laravolt\Indonesia\Models\Province`.

## Usage

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

`\Indonesia::search('jakarta')->all()`
`\Indonesia::search('jakarta')->allProvinces()`
`\Indonesia::search('jakarta')->paginateProvinces()`
`\Indonesia::search('jakarta')->allCities()`
`\Indonesia::search('jakarta')->paginateCities()`
`\Indonesia::search('jakarta')->allDistricts()`
`\Indonesia::search('jakarta')->paginateDistricts()`
`\Indonesia::search('jakarta')->allVillages()`
`\Indonesia::search('jakarta')->paginateVillages()`

---

# Testing

Run

```
vendor/bin/phpunit tests
```
