<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncStagingDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $this->alert(env('DB_STAGING_USERNAME'));
        $this->alert(env('DB_STAGING_PASSWORD'));
        $this->alert(env('DB_STAGING_DATABASE'));
        $this->alert("mysqldump --column-statistics=0 -P 3306 -h " . env('DB_STAGING_HOST') . " -u" . env('DB_STAGING_USERNAME') . " -p" . env('DB_STAGING_PASSWORD') . ' ' . env('DB_STAGING_DATABASE') . ' > database/full_db.sql');

        exec("mysqldump --column-statistics=0 -P 3306 -h " . env('DB_STAGING_HOST') . " -u" . env('DB_STAGING_USERNAME') . " -p" . env('DB_STAGING_PASSWORD') . ' ' . env('DB_STAGING_DATABASE') . ' > database/full_db.sql');

        $this->alert('DUMP from staging done.');

        $this->alert(env('DB_USERNAME'));
        $this->alert(env('DB_PASSWORD'));
        $this->alert(env('DB_DATABASE'));
        $this->alert('mysql -u' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' < database/full_db.sql');

        exec('mysql -u' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' < database/full_db.sql');

        $this->alert('IMPORT to local db done');
    }
}
