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
            $header = ['code', 'district_code', 'name', 'lat', 'long', 'pos'];
            $data = $csv->csv_to_array($file->getRealPath(), $header);

            $data = array_map(function ($arr) use ($now) {
                $arr['meta'] = json_encode(['lat' => $arr['lat'], 'long' => $arr['long'], 'pos' => $arr['pos']]);
                unset($arr['lat'], $arr['long'], $arr['pos']);

                return $arr + ['created_at' => $now, 'updated_at' => $now];
            }, $data);

            $collection = collect($data);
            foreach ($collection->chunk(50) as $chunk) {
                DB::table(config('laravolt.indonesia.table_prefix').'villages')->insertOrIgnore($chunk->toArray());
            }
        }
    }
}
