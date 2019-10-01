<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;

class ProvincesSeeder extends Seeder
{
    public function run()
    {
        $Csv = new CsvtoArray();
        $file = __DIR__.'/../../resources/csv/provinces.csv';
        $header = ['id', 'name'];
        $data = $Csv->csv_to_array($file, $header);
        $data = array_map(function ($arr) {
            return $arr + ['created_at' => now()];
        }, $data);

        \DB::table(config('laravolt.indonesia.table_prefix').'provinces')->insert($data);
    }
}
