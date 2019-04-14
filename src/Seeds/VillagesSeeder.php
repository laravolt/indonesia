<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;

class VillagesSeeder extends Seeder
{
    public function run()
    {
    	$csv = new CsvtoArray;
        $resourceFiles = \File::allFiles(__DIR__. '/../../resources/csv/villages');
        foreach ($resourceFiles as $file) {
            $header = array('id', 'district_id', 'name');
            $data = $csv->csv_to_array($file->getRealPath(), $header);
            $collection = collect($data);
            foreach($collection->chunk(50) as $chunk) {
                \DB::table(config('laravolt.indonesia.table_prefix') . 'villages')->insert($chunk->toArray());
            }
        }
    }

}
