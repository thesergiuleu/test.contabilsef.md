<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::where('name', 'admin')->firstOrFail();

        $file = file_get_contents(database_path('seeds') . '/menuItems.json');

        foreach (json_decode($file, true) as $item) {
            $menuItem = MenuItem::firstOrNew([
                'menu_id' => $item['menu_id'],
                'title'   => $item['title'],
                'url'     => $item['url'],
                'route'   => $item['route'],
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => $item['target'],
                    'icon_class' => $item['icon_class'],
                    'color'      => $item['color'],
                    'parent_id'  => $item['parent_id'],
                    'order'      => $item['order'],
                ])->save();
            }
        }
    }
}
