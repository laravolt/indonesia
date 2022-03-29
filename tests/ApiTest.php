<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use KodePandai\Indonesia\Tests\TestCase;

use function Pest\Laravel\getJson;

uses(TestCase::class);

// Province

it('can get provinces as json', function () {
    getJson(route('api.indonesia.provinces'))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('ACEH')
        ->assertSee('PAPUA');
});

it('can get provinces as html', function () {
    getJson(route('api.indonesia.provinces', ['as_html' => true]))
        ->assertOk()
        ->assertSee('<option value="11">ACEH</option>', false)
        ->assertSee('<option value="91">PAPUA</option>', false)
        ->assertDontSee('data');
});

it('can get provinces with latitude and longitude', function () {
    getJson(route('api.indonesia.provinces'))
        ->assertOk()
        ->assertDontSee('latitude')
        ->assertDontSee('longitude');
    Config::set('indonesia.api.reponse_columns.province', [
        'code', 'name', 'latitude', 'longitude',
    ]);
    getJson(route('api.indonesia.provinces'))
        ->assertOk()
        ->assertSee('latitude')
        ->assertSee('longitude');
});

// City

it('can get cities as json', function () {
    getJson(route('api.indonesia.cities'))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('KABUPATEN ACEH SELATAN')
        ->assertSee('KOTA SORONG');
});

it('can get cities as html', function () {
    getJson(route('api.indonesia.cities', ['as_html' => true]))
        ->assertOk()
        ->assertSee('<option value="1101">KABUPATEN ACEH SELATAN</option>', false)
        ->assertSee('<option value="9271">KOTA SORONG</option>', false)
        ->assertDontSee('data');
});

it('can get cities with latitude and longitude', function () {
    getJson(route('api.indonesia.cities'))
        ->assertOk()
        ->assertDontSee('latitude')
        ->assertDontSee('longitude');
    Config::set('indonesia.api.reponse_columns.city', [
        'code', 'name', 'latitude', 'longitude',
    ]);
    getJson(route('api.indonesia.cities'))
        ->assertOk()
        ->assertSee('latitude')
        ->assertSee('longitude')
        ->assertDontSee('province_code');
});

it('can get cities by province_code', function () {
    getJson(route('api.indonesia.cities', ['province_code' => 33]))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('KABUPATEN CILACAP')
        ->assertSee('KOTA TEGAL')
        ->assertJsonCount(35, 'data')
        ->assertDontSee('KABUPATEN ACEH UTARA');
});

it('can get cities by province_name', function () {
    getJson(route('api.indonesia.cities', ['province_name' => 'PAPUA']))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('KABUPATEN ASMAT')
        ->assertSee('KOTA JAYAPURA')
        ->assertJsonCount(29, 'data')
        ->assertDontSee('KABUPATEN PEKALONGAN');
});

// District

it('can get districts as json', function () {
    getJson(route('api.indonesia.districts'))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('BAKONGAN')
        ->assertSee('MALADUM MES');
});

it('can get districts as html', function () {
    getJson(route('api.indonesia.districts', ['as_html' => true]))
        ->assertOk()
        ->assertSee('<option value="110101">BAKONGAN</option>', false)
        ->assertSee('<option value="927110">MALADUM MES</option>', false)
        ->assertDontSee('data');
});

it('can get districts with latitude and longitude', function () {
    getJson(route('api.indonesia.districts'))
        ->assertOk()
        ->assertDontSee('latitude')
        ->assertDontSee('longitude');
    Config::set('indonesia.api.reponse_columns.district', [
        'code', 'name', 'latitude', 'longitude',
    ]);
    getJson(route('api.indonesia.districts'))
        ->assertOk()
        ->assertSee('latitude')
        ->assertSee('longitude')
        ->assertDontSee('city_code');
});

it('can get districts by city_code', function () {
    getJson(route('api.indonesia.districts', ['city_code' => 3315]))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('KEDUNGJATI')
        ->assertSee('TANGGUNGHARJO')
        ->assertJsonCount(19, 'data')
        ->assertDontSee('TAPAKTUAN');
});

it('can get districts by city_name', function () {
    getJson(route('api.indonesia.districts', ['city_name' => 'KOTA SEMARANG']))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('SEMARANG TENGAH')
        ->assertSee('TUGU')
        ->assertJsonCount(16, 'data')
        ->assertDontSee('PURWODADI');
});

// Village

it('must specify district_code or district_name to get villages', function () {
    getJson(route('api.indonesia.villages'))
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Parameter district_code or district_name is required')
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('can get villages as json', function () {
    getJson(route('api.indonesia.villages', ['district_code' => 110101]))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('KEUDE BAKONGAN')
        ->assertSee('GAMPONG BARO');
});

it('can get villages as html', function () {
    getJson(route('api.indonesia.villages', [
            'district_code' => 110101, 'as_html' => true,
        ]))
        ->assertOk()
        ->assertSee('<option value="1101012001">KEUDE BAKONGAN</option>', false)
        ->assertSee('<option value="1101012017">GAMPONG BARO</option>', false)
        ->assertDontSee('data');
});

it('can get villages with latitude, longitude and postal_code', function () {
    getJson(route('api.indonesia.villages', ['district_code' => 110101]))
        ->assertOk()
        ->assertDontSee('latitude')
        ->assertDontSee('longitude');
    Config::set('indonesia.api.reponse_columns.village', [
        'code', 'name', 'latitude', 'longitude', 'postal_code',
    ]);
    getJson(route('api.indonesia.villages', ['district_code' => 110101]))
        ->assertOk()
        ->assertSee('latitude')
        ->assertSee('longitude')
        ->assertDontSee('district_code');
});

it('can get villages by district_name', function () {
    getJson(route('api.indonesia.villages', ['district_name' => 'GROBOGAN']))
        ->assertOk()
        ->assertJsonStructure([
            'success', 'message',
            'data' => [['code', 'name']],
        ])
        ->assertSee('GROBOGAN')
        ->assertSee('SUMBERJATIPOHON')
        ->assertJsonCount(12, 'data')
        ->assertDontSee('GAMBIR');
});
