<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;

class VillagesSeeder extends Seeder
{
    public function run()
    {
        $file = __DIR__.'/../../resources/csv/villages.csv';
        $delimiter = ',';

        if (!file_exists($file) || !is_readable($file)) {
            return false;
        }

        $chunk = [];
        $header = ['id', 'district_id', 'name'];
        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $chunk[] = array_combine($header, $row);

                if (count($chunk) === 100) {
                    \DB::table(config('laravolt.indonesia.table_prefix').'villages')->insert($chunk);
                    $chunk = [];
                }
            }

            if (count($chunk) > 0) {
                \DB::table(config('laravolt.indonesia.table_prefix').'villages')->insert($chunk);
            }

            fclose($handle);
        }
    }
}
