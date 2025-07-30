<?php

namespace Laravolt\Indonesia\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Laravolt\Indonesia\Models\Kabupaten;
use Laravolt\Indonesia\Models\Kecamatan;
use Laravolt\Indonesia\Models\Kelurahan;
use Laravolt\Indonesia\Models\Provinsi;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->extractCompressedFiles();
        $this->reset();

        $this->call(ProvincesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(VillagesSeeder::class);
    }

    public function reset()
    {

        Schema::disableForeignKeyConstraints();

        Kelurahan::truncate();
        Kecamatan::truncate();
        Kabupaten::truncate();
        Provinsi::truncate();

        Schema::disableForeignKeyConstraints();
    }

    /**
     * Extract compressed CSV files if they exist and CSV files don't exist
     *
     * @return void
     */
    protected function extractCompressedFiles()
    {
        $csvPath = __DIR__.'/../../resources/csv';

        // Extract main CSV files
        $mainFiles = ['provinces.csv', 'cities.csv', 'districts.csv'];
        foreach ($mainFiles as $file) {
            $csvFile = $csvPath.'/'.$file;
            $gzFile = $csvFile.'.gz';

            if (File::exists($gzFile) && !File::exists($csvFile)) {
                $this->extractGzFile($gzFile, $csvFile);
            }
        }

        // Extract villages CSV files
        $villagesPath = $csvPath.'/villages';
        if (File::isDirectory($villagesPath)) {
            $gzFiles = File::glob($villagesPath.'/*.csv.gz');
            foreach ($gzFiles as $gzFile) {
                $csvFile = str_replace('.gz', '', $gzFile);
                if (!File::exists($csvFile)) {
                    $this->extractGzFile($gzFile, $csvFile);
                }
            }
        }
    }

    /**
     * Extract a gzipped file
     *
     * @param string $gzFile
     * @param string $csvFile
     * @return void
     */
    protected function extractGzFile($gzFile, $csvFile)
    {
        $gzHandle = gzopen($gzFile, 'rb');
        $csvHandle = fopen($csvFile, 'wb');

        if ($gzHandle && $csvHandle) {
            while (!gzeof($gzHandle)) {
                fwrite($csvHandle, gzread($gzHandle, 4096));
            }
            gzclose($gzHandle);
            fclose($csvHandle);

            echo "Extracted: ".basename($csvFile)."\n";
        } else {
            throw new \Exception("Failed to extract: {$gzFile}");
        }
    }
}
