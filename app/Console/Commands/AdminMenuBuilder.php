<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class AdminMenuBuilder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:admin_menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates admin menu';

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
        $dataTypes = DataType::all();

        foreach ($dataTypes as $key => $dataType) {
            if (MenuItem::where('title', $dataType->display_name_plural)->exists()) continue;

            MenuItem::query()->create([
                'title' => $dataType->display_name_plural,
                'menu_id' => Menu::query()->where('name', 'admin')->first()->id,
                'url' => '',
                'icon_class' => $dataType->icon,
                'target' => '_self',
                'order' => $key,
                'parent_id' => null,
                'route' => 'voyager.' . $dataType->name . '.index',
            ]);
        }
    }
}
