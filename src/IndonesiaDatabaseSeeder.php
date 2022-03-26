<?php

namespace KodePandai\Indonesia;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use KodePandai\Indonesia\Models\City;
use KodePandai\Indonesia\Models\District;
use KodePandai\Indonesia\Models\Province;
use KodePandai\Indonesia\Models\Village;

class IndonesiaDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Start indonesia seeder...');

        $startTime = microtime(true);

        Schema::disableForeignKeyConstraints();

        $this->seedProvinces();
        $this->seedCities();
        $this->seedDistricts();
        $this->seedVillages();

        Schema::enableForeignKeyConstraints();

        $endTime = round(microtime(true) - $startTime, 2);

        $this->command->info("✔ OK: Took {$endTime} seconds.");
    }

    protected function seedProvinces(): void
    {
        Province::truncate();

        $content = file_get_contents(__DIR__.'/../database/raw/provinces.csv.gz');

        $provinces = array_map(function ($item) {
            return [
                'code' => $item[0],
                'name' => $item[1],
                'latitude' => $item[2],
                'longitude' => $item[3],
            ];
        }, $this->csvToArray(gzdecode($content)));

        Province::insert($provinces);
    }

    protected function seedCities(): void
    {
        City::truncate();

        $content = file_get_contents(__DIR__.'/../database/raw/cities.csv.gz');

        $cities = array_map(function ($item) {
            return [
                'code' => $item[0],
                'province_code' => $item[1],
                'name' => $item[2],
                'latitude' => $item[3],
                'longitude' => $item[4],
            ];
        }, $this->csvToArray(gzdecode($content)));

        City::insert($cities);
    }

    protected function seedDistricts(): void
    {
        District::truncate();

        $content = file_get_contents(__DIR__.'/../database/raw/districts.csv.gz');

        $districts = array_map(function ($item) {
            return [
                'code' => $item[0],
                'city_code' => $item[1],
                'name' => $item[2],
                'latitude' => $item[3],
                'longitude' => $item[4],
            ];
        }, $this->csvToArray(gzdecode($content)));

        District::insert($districts);
    }

    protected function seedVillages(): void
    {
        Village::truncate();

        $path = __DIR__.'/../database/raw/villages';

        $files = array_diff(scandir($path), ['.', '..']);

        foreach ($files as $file) {
            $content = file_get_contents($path.'/'.$file);

            $villages = array_map(function ($item) {
                return [
                    'code' => $item[0],
                    'district_code' => $item[1],
                    'name' => $item[2],
                    'latitude' => $item[3],
                    'longitude' => $item[4],
                ];
            }, $this->csvToArray(gzdecode($content)));

            Village::insert($villages);
        }
    }

    protected function csvToArray(string $content): array
    {
        $data = [];

        foreach (explode(PHP_EOL, $content) as $item) {
            $data[] = str_getcsv($item);
        }

        return $data;
    }
}
