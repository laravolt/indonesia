# Laravel Indonesia

Laravel package for Indonesia administrative data.

This is a lightweight version of [laravolt/indonesia](https://github.com/laravel/indonesia)
which **ONLY** provides model, migration, seeder and a simple API endpoint.

## Comparison

| feature            | kodepandai/laravel-indonesia | laravolt/indonesia     |
|--------------------| ---------------------------- | ---------------------- |
| installed size     | 1.6 MB                       | 4.6 MB                 |
| raw data           | compressed with gzip         | uncompressed           |
| api                | simple                       | complex, for laravolt  |

## Installation

Install with composer:

```sh
composer require kodepandai/laravel-indonesia
```

(Optional) publish the package migration and configuration:

```
php artisan vendor:publish --provider="KodePandai\Indonesia\IndonesiaServiceProvider"
```

## Configuration

Open the `config/indonesia.php` file and suits your need.

## Usage

### Seeder

This package automatically load indonesia migration, but to seed the database
you must configure it manually.

Call `IndonesiaDatabaseSeeder` in your `DatabaseSeeder`:

```php
// file: database/seeders/DatabaseSeeder.php

use KodePandai\Indonesia\IndonesiaDatabaseSeeder;

//..
public function run(): void
{
    $this->call(IndonesiaDatabaseSeeder::class);
}
//..
```

### Model

This package has 4 base models (`Province`, `City`, `District`, `Village`)
and each model has relations to other models.

```php
use \KodePandai\Indonesia\Models\Province;
use \KodePandai\Indonesia\Models\City;
use \KodePandai\Indonesia\Models\District;
use \KodePandai\Indonesia\Models\Village;

$province = Province::first();
$province->cities; // get cities of the province
$province->districts; // get districts of the province
$province->villages; // get villages of the province

$city = City::first();
$city->province; // get province of the city
$city->districts; // get districts of the city
$city->villages; // get villages of the city

$district = District::first();
$district->province; // get province of the district
$district->city; // get city of the district
$district->villages; // get villages of the district

$village = Village::first();
$village->province; // get province of the village
$village->city; // get city of the village
$village->district; // get district of the village
```

### API

This package provides API endpoint to get administrative data. 
The API is enabled by default, to disable it, change the configuration file.

#### Province

* Get all provinces

```sh
$ curl "http://localhost:8000/api/indonesia/provinces"
```

*Note: add parameter `as_html=true` to get response as html options.

#### City

* Get all cities

```sh
$ curl "http://localhost:8000/api/indonesia/cities"
```

* Get cities by province_code or province_name

```sh
$ curl "http://localhost:8000/api/indonesia/cities?province_code=33"
$ curl "http://localhost:8000/api/indonesia/cities?province_name=PAPUA"
```

*Note: add parameter `as_html=true` to get response as html options.

#### District

* Get all districts

```sh
$ curl "http://localhost:8000/api/indonesia/districts"
```

* Get districts by city_code or city_name

```sh
$ curl "http://localhost:8000/api/indonesia/districts?city_code=3315"
$ curl "http://localhost:8000/api/indonesia/districts?city_name=KOTA SEMARANG"
```

*Note: add parameter `as_html=true` to get response as html options.

#### Village

* Get all villages

```sh
$ curl "http://localhost:8000/api/indonesia/villages"
```

* Get villages by district_code or district_name

```sh
$ curl "http://localhost:8000/api/indonesia/villages?district_code=337401"
$ curl "http://localhost:8000/api/indonesia/villages?district_name=SEMARANG TENGAH"
```

*Note: add parameter `as_html=true` to get response as html options.
