<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build the app';

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
        $this->comment('php artisan migrate:fresh');
        $this->call('migrate:fresh');

        $this->comment('php artisan db:seed');
        $this->call('db:seed');

//        $this->comment('php artisan build:menu');
//        $this->call('build:menu');

        $this->comment('php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"');
        exec('php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"');

        $this->comment('php artisan vendor:publish --provider="TCG\Voyager\VoyagerServiceProvider"');
        exec('php artisan vendor:publish --provider="TCG\Voyager\VoyagerServiceProvider"');
    }
}
