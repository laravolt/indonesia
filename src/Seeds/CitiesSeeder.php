<?php

namespace Laravolt\Indonesia\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $Csv = new CsvtoArray();
        $file = __DIR__.'/../../resources/csv/cities.csv';
        $header = ['code', 'province_code', 'name', 'lat', 'long'];
        $data = $Csv->csv_to_array($file, $header);
        $data = array_map(function ($arr) use ($now) {
            $arr['meta'] = json_encode(['lat' => $arr['lat'], 'long' => $arr['long']]);
            unset($arr['lat'], $arr['long']);

            return $arr + ['created_at' => $now, 'updated_at' => $now];
        }, $data);

        $collection = collect($data);
        foreach ($collection->chunk(50) as $chunk) {
            DB::table(config('laravolt.indonesia.table_prefix').'cities')->insertOrIgnore($chunk->toArray());
        }
    }
}
