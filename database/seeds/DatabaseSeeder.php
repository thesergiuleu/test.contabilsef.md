<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class DatabaseSeeder extends Seeder
{
    use Seedable;
    protected $seedersPath = __DIR__.'/';
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('DataTypesTableSeeder');
        $this->seed('DataRowsTableSeeder');
        $this->seed('MenusTableSeeder');
        $this->seed('MenuItemsTableSeeder');
        $this->seed('RolesTableSeeder');
        $this->seed('PermissionsTableSeeder');
        $this->seed('PermissionRoleTableSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('SettingsTableSeeder');
        $this->seed('CategoriesTableSeeder');
        $this->command->line('Posts importing');
        $this->seed('PostsTableSeeder');
        $this->command->line('posts done importing');
        $this->command->line('Instruire started');
        $this->seed('InstruireTableSeeder');
        $this->seed('PermissionRoleTableSeeder');
        $this->seed('OptionAndPackagesSeeder');
    }
}
