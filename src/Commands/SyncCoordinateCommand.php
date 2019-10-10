<?php

namespace Laravolt\Indonesia\Commands;

use GuzzleHttp\Exception\ServerException;
use Illuminate\Console\Command;
use Laravolt\Indonesia\Models\Kabupaten;
use Laravolt\Indonesia\Models\Kecamatan;
use Laravolt\Indonesia\Models\Kelurahan;
use Laravolt\Indonesia\Models\Provinsi;

class SyncCoordinateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravolt:indonesia:sync-coordinate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize latitude longitude data in database directly using Google\'s geocoding service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = Provinsi::count();
        $this->info("Processing {$count} Provinsi");
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        Provinsi::cursor()->each(function ($item) use ($bar) {
            $meta = $item->meta;
            $geocoding = \Geocoder::getCoordinatesForAddress($item->address);
            $meta['lat'] = $geocoding['lat'] ?? null;
            $meta['long'] = $geocoding['lng'] ?? null;
            $item->meta = $meta;
            $item->save();
            $bar->advance();
        });

        $this->line('');

        $count = Kabupaten::count();
        $this->info("Processing {$count} Kabupaten");
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        Kabupaten::with('provinsi')->cursor()->each(function ($item) use ($bar) {
            $meta = $item->meta;
            $geocoding = \Geocoder::getCoordinatesForAddress($item->address);
            $meta['lat'] = $geocoding['lat'] ?? null;
            $meta['long'] = $geocoding['lng'] ?? null;
            $item->meta = $meta;
            $item->save();
            $bar->advance();
        });

        $this->line('');

        $count = Kecamatan::count();
        $this->info("Processing {$count} Kecamatan");
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        Kecamatan::with('kabupaten.provinsi')->cursor()->each(function ($item) use ($bar) {
            $meta = $item->meta;
            $geocoding = \Geocoder::getCoordinatesForAddress($item->address);
            $meta['lat'] = $geocoding['lat'] ?? null;
            $meta['long'] = $geocoding['lng'] ?? null;
            $item->meta = $meta;
            $item->save();
            $bar->advance();
        });

        $this->line('');

        $count = Kelurahan::whereNull('meta')->count();
        $this->info("Processing {$count} Kelurahan");
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        Kelurahan::whereNull('meta')->cursor()->each(function ($item) use ($bar) {
            $meta = $item->meta;
            if (!$meta) {
                try {
                    $geocoding = \Geocoder::getCoordinatesForAddress($item->address);
                    $meta['lat'] = $geocoding['lat'] ?? null;
                    $meta['long'] = $geocoding['lng'] ?? null;
                    $item->meta = $meta;
                    $item->save();
                } catch (ServerException $e) {
                    $this->error($e->getMessage());
                    sleep(1);
                }
            }
            $bar->advance();
        });
    }
}
