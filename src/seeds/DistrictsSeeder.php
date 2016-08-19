<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;

class DistrictsSeeder extends Seeder
{
    public function run()
    {
    	$Csv = new CsvtoArray;
        $file = __DIR__. '/../../resources/csv/districts.csv';
        $header = array('id', 'regency_id', 'name');
        $data = $Csv->csv_to_array($file, $header);
        \DB::table('districts')->insert($data);
    }
}
