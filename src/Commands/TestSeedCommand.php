<?php

namespace Laravolt\Indonesia\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class TestSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravolt:indonesia:test:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed test database';

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
        DB::raw('PRAGMA foreign_keys=0');

        Artisan::call('db:seed', ['--class' => 'Laravolt\Indonesia\Seeds\DatabaseSeeder']);
        $this->info('Seeded: Laravolt\Indonesia\Seeds\IndonesiaSeeder');

        DB::raw('PRAGMA foreign_keys=1');
    }
}
