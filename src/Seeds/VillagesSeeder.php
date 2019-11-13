<?php

namespace Laravolt\Indonesia\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VillagesSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $csv = new CsvtoArray();
        $resourceFiles = File::allFiles(__DIR__.'/../../resources/csv/villages');
        foreach ($resourceFiles as $file) {
            $header = ['id', 'district_id', 'name', 'lat', 'long'];
            $data = $csv->csv_to_array($file->getRealPath(), $header);

            $data = array_map(function ($arr) use ($now) {
                $arr['meta'] = json_encode(['lat' => $arr['lat'], 'long' => $arr['long']]);
                unset($arr['lat'], $arr['long']);

                return $arr + ['created_at' => $now, 'updated_at' => $now];
            }, $data);

            $collection = collect($data);
            foreach ($collection->chunk(50) as $chunk) {
                DB::table(config('laravolt.indonesia.table_prefix').'villages')->insert($chunk->toArray());
            }
        }
    }
}
