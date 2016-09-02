<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;

class VillagesSeeder extends Seeder
{
    public function run()
    {
    	$Csv = new CsvtoArray;
        $file = __DIR__. '/../../resources/csv/villages.csv';
        $header = array('id', 'district_id', 'name');
        $data_all = $Csv->csv_to_array($file, $header);

        $datas = array_chunk($data_all, ceil(count($data_all)/16));

        foreach ($datas as $data) {
            $value = "";
            foreach ($data as $row) {
                if(stripos($row['name'], "'") !== false){
                    $row['name'] = str_replace("'", "''", $row['name']);
                }
                if($value == ""){
                    $value = "(".$row['id'].",".$row['district_id'].",'".$row['name']."')";
                }
                else{
                    $value = $value . ",(".$row['id'].",".$row['district_id'].",'".$row['name']."')";
                }
            }
            \DB::insert("insert ignore into " . config('laravolt.indonesia.table_prefix') . "villages values " . $value);
        }


    }

}
