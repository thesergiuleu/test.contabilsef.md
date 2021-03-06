<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class MenuBuilder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the site menu in dependence of content.';

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
        $categories = Category::query()->orderBy('parent_id')->get();

        foreach ($categories as $key => $category) {
            if ($category->slug != 'instruire')
                if (MenuItem::where('title', $category->name)->exists()) continue;

            $this->buildMenu($category, $key);
        }

        $lastKey = array_key_last($categories->toArray());

        $menu = Menu::query()->where('name', 'site')->first();

        if (!$menuItem = MenuItem::query()->where('menu_id', $menu->id)->where('title', 'contacte')->first()) {
            MenuItem::create([
                'title' => 'contacte',
                'menu_id' => $menu->id,
                'url' => '/contacte',
                'target' => '_self',
                'order' => $lastKey + 1,
            ]);
        }
    }

    private function buildMenu(Category $category, $key)
    {
        $menu = Menu::query()->where('name', 'site')->firstOrCreate([
            'name' => 'site'
        ]);

        $params = json_encode([
            'slug' => $category->slug
        ]);

        MenuItem::create([
            'title' => $category->name,
            'menu_id' => $menu->id,
            'url' => '',
            'target' => '_self',
            'order' => $key,
            'parent_id' => $category->parentId ? MenuItem::query()->where('title', $category->parentId->name)->first()->id : null,
            'route' => 'category.view',
            'parameters' => $params
        ]);
    }
}
