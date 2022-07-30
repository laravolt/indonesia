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
        $this->command->info('> Start indonesia seeder...');

        $startTime = microtime(true);

        Schema::disableForeignKeyConstraints();

        $this->seedProvinces();
        $this->seedCities();
        $this->seedDistricts();
        $this->seedVillages();

        Schema::enableForeignKeyConstraints();

        $endTime = round(microtime(true) - $startTime, 2);

        $this->command->info("> ✔ OK: Took {$endTime} seconds.");
    }

    protected function seedProvinces(): void
    {
        Province::truncate();

        $content = file_get_contents(__DIR__.'/../database/raw/provinces.csv.gz');

        $data = $this->csvToArray(gzdecode($content));

        Province::insert($this->mapProvincesData($data));
    }

    protected function mapProvincesData(array $data): array
    {
        return array_map(function ($item) {
            return [
                'code' => $item[0],
                'name' => $item[1],
                'latitude' => $item[2],
                'longitude' => $item[3],
            ];
        }, $data);
    }

    protected function seedCities(): void
    {
        City::truncate();

        $content = file_get_contents(__DIR__.'/../database/raw/cities.csv.gz');

        $data = $this->csvToArray(gzdecode($content));

        City::insert($this->mapCitiesData($data));
    }

    protected function mapCitiesData(array $data): array
    {
        return array_map(function ($item) {
            return [
                'code' => $item[0],
                'province_code' => $item[1],
                'name' => $item[2],
                'latitude' => $item[3],
                'longitude' => $item[4],
            ];
        }, $data);
    }

    protected function seedDistricts(): void
    {
        District::truncate();

        $content = file_get_contents(__DIR__.'/../database/raw/districts.csv.gz');

        $data = $this->csvToArray(gzdecode($content));

        District::insert($this->mapDistrictsData($data));
    }

    protected function mapDistrictsData(array $data): array
    {
        return array_map(function ($item) {
            return [
                'code' => $item[0],
                'city_code' => $item[1],
                'name' => $item[2],
                'latitude' => $item[3],
                'longitude' => $item[4],
            ];
        }, $data);
    }

    protected function seedVillages(): void
    {
        Village::truncate();

        $path = __DIR__.'/../database/raw/villages';

        $files = array_diff(scandir($path), ['.', '..']);

        foreach ($files as $file) {
            $content = file_get_contents($path.'/'.$file);

            $data = $this->csvToArray(gzdecode($content));

            Village::insert($this->mapVillagesData($data));
        }
    }

    protected function mapVillagesData(array $data): array
    {
        return array_map(function ($item) {
            return [
                'code' => $item[0],
                'district_code' => $item[1],
                'name' => $item[2],
                'latitude' => $item[3],
                'longitude' => $item[4],
                'postal_code' => $item[5],
            ];
        }, $data);
    }

    protected function csvToArray(string $content): array
    {
        $data = [];

        foreach (explode("\n", $content) as $item) {
            if (! empty($item)) {
                $data[] = str_getcsv($item);
            }
        }

        return $data;
    }
}
