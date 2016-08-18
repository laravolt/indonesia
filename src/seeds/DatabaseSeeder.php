<?php

namespace Laravolt\IndonesiaLogo\Seeds;

use Illuminate\Database\Seeder;

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
        $this->call(RegenciesSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(VillagesSeeder::class);
    }

    function clear_data(){
        \DB::table('villages')->delete();
        \DB::table('districts')->delete();
        \DB::table('regencies')->delete();
        \DB::table('provinces')->delete();
    }
}


