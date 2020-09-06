<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $file = file_get_contents(database_path('seeds') . '/menus.json');

        foreach (json_decode($file, true) as $item) {
            Menu::query()->create([
                'name' => $item['name']
            ]);
        }
    }
}
