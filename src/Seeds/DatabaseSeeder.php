<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clear_data();

        $this->call(ProvincesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(VillagesSeeder::class);
    }

    function clear_data(){
        DB::table(config('laravolt.indonesia.table_prefix') . 'villages')->delete();
        DB::table(config('laravolt.indonesia.table_prefix') . 'districts')->delete();
        DB::table(config('laravolt.indonesia.table_prefix') . 'cities')->delete();
        DB::table(config('laravolt.indonesia.table_prefix') . 'provinces')->delete();
    }
}


