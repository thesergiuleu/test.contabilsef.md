<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CacheSeminare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:seminare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cache seminare';

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
        dispatch(new \App\Jobs\CacheSeminare());
    }
}
