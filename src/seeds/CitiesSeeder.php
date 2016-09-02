<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run()
    {
    	$Csv = new CsvtoArray;
        $file = __DIR__. '/../../resources/csv/cities.csv';
        $header = array('id', 'province_id', 'name');
        $data = $Csv->csv_to_array($file, $header);
        \DB::table(config('laravolt.indonesia.table_prefix') . 'cities')->insert($data);
    }
}
