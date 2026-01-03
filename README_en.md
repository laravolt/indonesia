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

### Publish Configuration File (Optional)

```
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider" --tag="config"
```

### Database Connection Configuration (Optional)

If you want to store Indonesian region data in a separate database from your main application database, you can configure a custom database connection:

1. Define a new database connection in `config/database.php`:

```php
'connections' => [
    // ... other connections

    'indonesia' => [
        'driver' => 'mysql',
        'host' => env('INDONESIA_DB_HOST', '127.0.0.1'),
        'database' => env('INDONESIA_DB_DATABASE', 'indonesia'),
        'username' => env('INDONESIA_DB_USERNAME', 'root'),
        'password' => env('INDONESIA_DB_PASSWORD', ''),
        // ... other configuration
    ],
]
```

2. Set environment variables in your `.env` file:

```
INDONESIA_DB_CONNECTION=indonesia
INDONESIA_DB_HOST=127.0.0.1
INDONESIA_DB_DATABASE=indonesia_regions
INDONESIA_DB_USERNAME=root
INDONESIA_DB_PASSWORD=
```

3. Or configure directly in `config/laravolt/indonesia.php`:

```php
return [
    'table_prefix' => 'indonesia_',
    'database' => [
        'connection' => env('INDONESIA_DB_CONNECTION', null),
    ],
];
```

If not configured, the package will use your application's default database connection.

### Publish Migration (Only for Laravel 5.2)
If you are using Laravel version 5.3+, you can ignore this step.
```
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"
```

### Run Migration
```
php artisan migrate
```

### Run Database Seeder to Populate the Database
```
php artisan laravolt:indonesia:seed
```

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
