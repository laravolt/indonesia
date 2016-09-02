<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;

class ProvincesSeeder extends Seeder
{
    public function run()
    {
		$Csv = new CsvtoArray;
        $file = __DIR__. '/../../resources/csv/provinces.csv';
        $header = array('id', 'name');
        $data = $Csv->csv_to_array($file, $header);
        \DB::table(config('laravolt.indonesia.table_prefix') . 'provinces')->insert($data);
    }
}
