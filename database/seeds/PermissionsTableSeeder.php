<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            'browse_admin',
            'browse_bread',
            'browse_database',
            'browse_media',
            'browse_compass',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }

        Permission::generateFor('menus');
        Permission::generateFor('roles');
        Permission::generateFor('users');
        Permission::generateFor('settings');
        Permission::generateFor('offers');
        Permission::generateFor('pages');
        Permission::generateFor('post_registers');
        Permission::generateFor('pools');
        Permission::generateFor('pool_options');
        Permission::generateFor('pool_answers');
        Permission::generateFor('newsletters');
        Permission::generateFor('contacts');
        Permission::generateFor('banners');
        Permission::generateFor('subscriptions');
        Permission::generateFor('comments');
        Permission::generateFor('subscription_services');
        Permission::generateFor('glosaries');
        Permission::generateFor('payments');
        Permission::generateFor('packages');
        Permission::generateFor('options');
    }
}
