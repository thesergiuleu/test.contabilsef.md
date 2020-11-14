<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class RemoveCategoriesWithoutPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all categories if there are no posts attached to it.';

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
     * @throws \Exception
     */
    public function handle()
    {
        $categories = Category::query()->whereNotNull('parent_id')->doesntHave('posts')->delete();
    }
}
