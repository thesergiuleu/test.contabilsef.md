<?php

use Illuminate\Database\Seeder;

class OptionAndPackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = file_get_contents(database_path('seeds') . '/options.json');
        foreach (json_decode($file, true) as $item) {
            $option = \App\Option::query()->where('alias', $item['alias'])->first();
            if (!$option) {
                $option = new \App\Option();
                $option->fill([
                    'alias' => $item['alias'],
                    'name' => $item['name'],
                ])->save();
            }
        }

        $file = file_get_contents(database_path('seeds') . '/packages.json');
        foreach (json_decode($file, true) as $item) {
            $optionIds = array_map(function ($v) {
                return $v['id'];
            }, $item['options']);
            $package = \App\Package::query()->where('alias', $item['alias'])->first();
            if (!$package) {
                $package = new \App\Package();
                $package->fill([
                    'alias' => $item['alias'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'discount_started_at' => $item['discount_started_at'],
                    'discount_ended_at' => $item['discount_ended_at'],
                ])->save();

                $package->options()->syncWithoutDetaching($optionIds);
            }
        }
    }
}
