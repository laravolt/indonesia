<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VillagesSeeder extends Seeder
{
    public function run()
    {
        $csv = new CsvtoArray();
        $resourceFiles = File::allFiles(__DIR__.'/../../resources/csv/villages');
        foreach ($resourceFiles as $file) {
            $header = ['id', 'district_id', 'name'];
            $data = $csv->csv_to_array($file->getRealPath(), $header);
            $collection = collect($data);
            foreach ($collection->chunk(50) as $chunk) {
                DB::table(config('laravolt.indonesia.table_prefix').'villages')->insert($chunk->toArray());
            }
        }
    }
}
