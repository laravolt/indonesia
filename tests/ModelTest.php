<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use KodePandai\Indonesia\Models\City;
use KodePandai\Indonesia\Models\District;
use KodePandai\Indonesia\Models\Province;
use KodePandai\Indonesia\Models\Village;
use KodePandai\Indonesia\Tests\TestCase;

uses(TestCase::class);

it('can set table_prefix config', function () {
    expect(new Province())->getTable()->toBe('indonesia_provinces');

    Config::set('indonesia.table_prefix', '');
    expect(new Province())->getTable()
        ->toBe('provinces')
        ->not->toBe('indonesia_provinces');

    Config::set('indonesia.table_prefix', 'indonesia_');
    expect(new City())->getTable()->toBe('indonesia_cities');

    Config::set('indonesia.table_prefix', 'indo_');
    expect(new City())->getTable()
        ->toBe('indo_cities')
        ->not->toBe('indonesia_cities');

    Config::set('indonesia.table_prefix', 'indonesia_');
    expect(new District())->getTable()->toBe('indonesia_districts');

    Config::set('indonesia.table_prefix', 'master_');
    expect(new District())->getTable()
        ->toBe('master_districts')
        ->not->toBe('indonesia_districts');
});

it('can get a province', function () {
    expect(Province::first())->not->toBeEmpty();

    expect(Province::find(33))
        ->code->toBe(33)
        ->name->toBe('JAWA TENGAH')
        ->latitude->toBe('-7.150975')
        ->longitude->toBe('110.1402594');
});

it('can get province model relations', function () {
    expect(Province::find(33)->cities)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(35)
        ->first()->code->toBe(3301)
        ->first()->name->toBe('KABUPATEN CILACAP')
        ->last()->code->toBe(3376)
        ->last()->name->toBe('KOTA TEGAL');

    expect(Province::find(33)->districts)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(576)
        ->first()->code->toBe(330101)
        ->first()->name->toBe('KEDUNGREJA')
        ->last()->code->toBe(337604)
        ->last()->name->toBe('MARGADANA');

    expect(Province::find(33)->villages)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(8562)
        ->first()->code->toBe(3301012001)
        ->first()->name->toBe('TAMBAKREJA')
        ->last()->code->toBe(3376041007)
        ->last()->name->toBe('PESURUNGAN LOR');
});

it('can get a city', function () {
    expect(City::first())->not->toBeEmpty();

    expect(City::find(3374))
        ->code->toBe(3374)
        ->name->toBe('KOTA SEMARANG')
        ->latitude->toBe('-7.0051453')
        ->longitude->toBe('110.4381254');
});

it('can get city model relations', function () {
    expect(City::find(3374)->province)
        ->toBeInstanceOf(Province::class)
        ->code->toBe(33)
        ->name->toBe('JAWA TENGAH');

    expect(City::find(3374)->districts)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(16)
        ->first()->code->toBe(337401)
        ->first()->name->toBe('SEMARANG TENGAH')
        ->last()->code->toBe(337416)
        ->last()->name->toBe('TUGU');

    expect(City::find(3374)->villages)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(177)
        ->first()->code->toBe(3374011001)
        ->first()->name->toBe('MIROTO')
        ->last()->code->toBe(3374161007)
        ->last()->name->toBe('MANGUNHARJO');
});

it('can get a district', function () {
    expect(District::first())->not->toBeEmpty();

    expect(District::find(337401))
        ->code->toBe(337401)
        ->name->toBe('SEMARANG TENGAH')
        ->latitude->toBe('-6.9805495')
        ->longitude->toBe('110.4202505');
});

it('can get district model relations', function () {
    expect(District::find(337401)->province)
        ->toBeInstanceOf(Province::class)
        ->code->toBe(33)
        ->name->toBe('JAWA TENGAH');

    expect(District::find(337401)->city)
        ->toBeInstanceOf(City::class)
        ->code->toBe(3374)
        ->name->toBe('KOTA SEMARANG');

    expect(District::find(337401)->villages)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(15)
        ->first()->code->toBe(3374011001)
        ->first()->name->toBe('MIROTO')
        ->last()->code->toBe(3374011015)
        ->last()->name->toBe('PINDRIKAN LOR');
});

it('can get a village', function () {
    expect(Village::first())->not->toBeEmpty();

    expect(Village::find(3374011001))
        ->code->toBe(3374011001)
        ->name->toBe('MIROTO')
        ->latitude->toBe('-6.9837576')
        ->longitude->toBe('110.4195057');
});

it('can get village model relations', function () {
    expect(Village::find(3374011001)->province)
        ->toBeInstanceOf(Province::class)
        ->code->toBe(33)
        ->name->toBe('JAWA TENGAH');

    expect(Village::find(3374011001)->city)
        ->toBeInstanceOf(City::class)
        ->code->toBe(3374)
        ->name->toBe('KOTA SEMARANG');

    expect(Village::find(3374011001)->district)
        ->toBeInstanceOf(District::class)
        ->code->toBe(337401)
        ->name->toBe('SEMARANG TENGAH');
});
