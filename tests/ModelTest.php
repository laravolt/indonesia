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
    expect((new Province)->getTable())->toBe('indonesia_provinces');

    Config::set('indonesia.table_prefix', '');
    expect((new Province)->getTable())
        ->toBe('provinces')
        ->not->toBe('indonesia_provinces');

    Config::set('indonesia.table_prefix', 'indonesia_');
    expect((new City)->getTable())->toBe('indonesia_cities');

    Config::set('indonesia.table_prefix', 'indo_');
    expect((new City)->getTable())
        ->toBe('indo_cities')
        ->not->toBe('indonesia_cities');

    Config::set('indonesia.table_prefix', 'indonesia_');
    expect((new District)->getTable())->toBe('indonesia_districts');

    Config::set('indonesia.table_prefix', 'master_');
    expect((new District)->getTable())
        ->toBe('master_districts')
        ->not->toBe('indonesia_districts');
});

it('can get a province', function () {
    expect(Province::first())->not->toBeEmpty();

    $province = Province::find(33);
    expect($province->code)->toBe(33);
    expect($province->name)->toBe('JAWA TENGAH');
    expect($province->latitude)->toBe('-7.150975');
    expect($province->longitude)->toBe('110.1402594');
});

it('can get province model relations', function () {
    $cities = Province::find(33)->cities;
    expect($cities)->toBeInstanceOf(Collection::class);
    expect($cities->count())->toBe(35);
    expect($cities->first()->code)->toBe(3301);
    expect($cities->first()->name)->toBe('KABUPATEN CILACAP');
    expect($cities->last()->code)->toBe(3376);
    expect($cities->last()->name)->toBe('KOTA TEGAL');

    $districts = Province::find(33)->districts;
    expect($districts)->toBeInstanceOf(Collection::class);
    expect($districts->count())->toBe(576);
    expect($districts->first()->code)->toBe(330101);
    expect($districts->first()->name)->toBe('KEDUNGREJA');
    expect($districts->last()->code)->toBe(337604);
    expect($districts->last()->name)->toBe('MARGADANA');

    $villlages = Province::find(33)->villages;
    expect($villlages)->toBeInstanceOf(Collection::class);
    expect($villlages->count())->toBe(8562);
    expect($villlages->first()->code)->toBe(3301012001);
    expect($villlages->first()->name)->toBe('TAMBAKREJA');
    expect($villlages->last()->code)->toBe(3376041007);
    expect($villlages->last()->name)->toBe('PESURUNGAN LOR');
});

it('can get a city', function () {
    expect(City::first())->not->toBeEmpty();

    $city = City::find(3374);
    expect($city->code)->toBe(3374);
    expect($city->name)->toBe('KOTA SEMARANG');
    expect($city->latitude)->toBe('-7.0051453');
    expect($city->longitude)->toBe('110.4381254');
});

it('can get city model relations', function () {
    $province = City::find(3374)->province;
    expect($province)->toBeInstanceOf(Province::class);
    expect($province->code)->toBe(33);
    expect($province->name)->toBe('JAWA TENGAH');

    $districts = City::find(3374)->districts;
    expect($districts)->toBeInstanceOf(Collection::class);
    expect($districts->count())->toBe(16);
    expect($districts->first()->code)->toBe(337401);
    expect($districts->first()->name)->toBe('SEMARANG TENGAH');
    expect($districts->last()->code)->toBe(337416);
    expect($districts->last()->name)->toBe('TUGU');

    $cities = City::find(3374)->villages;
    expect($cities)->toBeInstanceOf(Collection::class);
    expect($cities->count())->toBe(177);
    expect($cities->first()->code)->toBe(3374011001);
    expect($cities->first()->name)->toBe('MIROTO');
    expect($cities->last()->code)->toBe(3374161007);
    expect($cities->last()->name)->toBe('MANGUNHARJO');
});

it('can get a district', function () {
    expect(District::first())->not->toBeEmpty();

    $district = District::find(337401);
    expect($district->code)->toBe(337401);
    expect($district->name)->toBe('SEMARANG TENGAH');
    expect($district->latitude)->toBe('-6.9805495');
    expect($district->longitude)->toBe('110.4202505');
});

it('can get district model relations', function () {
    $province = District::find(337401)->province;
    expect($province)->toBeInstanceOf(Province::class);
    expect($province->code)->toBe(33);
    expect($province->name)->toBe('JAWA TENGAH');

    $city = District::find(337401)->city;
    expect($city)->toBeInstanceOf(City::class);
    expect($city->code)->toBe(3374);
    expect($city->name)->toBe('KOTA SEMARANG');

    $villlages = District::find(337401)->villages;
    expect($villlages)->toBeInstanceOf(Collection::class);
    expect($villlages->count())->toBe(15);
    expect($villlages->first()->code)->toBe(3374011001);
    expect($villlages->first()->name)->toBe('MIROTO');
    expect($villlages->last()->code)->toBe(3374011015);
    expect($villlages->last()->name)->toBe('PINDRIKAN LOR');
});

it('can get a village', function () {
    expect(Village::first())->not->toBeEmpty();

    $village = Village::find(3374011001);
    expect($village->code)->toBe(3374011001);
    expect($village->name)->toBe('MIROTO');
    expect($village->latitude)->toBe('-6.9837576');
    expect($village->longitude)->toBe('110.4195057');
});

it('can get village model relations', function () {
    $province = Village::find(3374011001)->province;
    expect($province)->toBeInstanceOf(Province::class);
    expect($province->code)->toBe(33);
    expect($province->name)->toBe('JAWA TENGAH');

    $city = Village::find(3374011001)->city;
    expect($city)->toBeInstanceOf(City::class);
    expect($city->code)->toBe(3374);
    expect($city->name)->toBe('KOTA SEMARANG');

    $district = Village::find(3374011001)->district;
    expect($district)->toBeInstanceOf(District::class);
    expect($district->code)->toBe(337401);
    expect($district->name)->toBe('SEMARANG TENGAH');
});

it('can get new districts added in v2', function() {
    $district = District::find(110115);
    expect($district->code)->toBe(110115);
    expect($district->name)->toBe('BAKONGAN TIMUR');
    expect($district->latitude)->toBe('NULL');
    expect($district->longitude)->toBe('NULL');
    
    $district = District::find(911823);
    expect($district->code)->toBe(911823);
    expect($district->name)->toBe('KOROWAY BULUANOP');
    expect($district->latitude)->toBe('NULL');
    expect($district->longitude)->toBe('NULL');
});

it('can get new villages added in v2', function() {
    $village = Village::find(1207212002);
    expect($village->code)->toBe(1207212002);
    expect($village->name)->toBe('PATUMBAK I');
    expect($village->latitude)->toBe('NULL');
    expect($village->longitude)->toBe('NULL');
    
    $village = Village::find(9201502009);
    expect($village->code)->toBe(9201502009);
    expect($village->name)->toBe('MLARON');
    expect($village->latitude)->toBe('NULL');
    expect($village->longitude)->toBe('NULL');
});
