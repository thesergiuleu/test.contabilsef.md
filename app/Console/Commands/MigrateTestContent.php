<?php

namespace App\Console\Commands;

use App\Category;
use App\Post;
use Illuminate\Console\Command;

class MigrateTestContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate some dummy content';

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
     * @return void
     */
    public function handle()
    {
        if (!Category::query()->exists()) {
            foreach ($this->categories() as $category) {
                factory(Category::class)->create($category);
            }
        }
        if (!Post::query()->exists()) {
            foreach ($this->posts() as $post) {
                factory(Post::class)->create($post);
            }
        }
    }

    private function categories()
    {
        return [
            [
                'parent_id' => null,
                'order' => 1
            ],
            [
                'parent_id' => 1,
                'order' => 2
            ],
            [
                'parent_id' => 1,
                'order' => 3
            ],
            [
                'parent_id' => null,
                'order' => 4
            ],
            [
                'parent_id' => 4,
                'order' => 5
            ]
        ];
    }

    private function posts()
    {
        return [
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ],
            [
                'category_id' => 5,
                'author_id' => 1,
                'status' => Post::PUBLISHED
            ]
        ];
    }
}
