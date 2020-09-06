<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;

class DataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $file = file_get_contents(database_path('seeds') . '/dataTypes.json');
        foreach (json_decode($file, true) as $item) {
            $dataType = $this->dataType('slug', $item['slug']);
            if (!$dataType->exists) {
                $dataType->fill([
                    'name'                  => $item['name'],
                    'display_name_singular' => $item['display_name_singular'],
                    'display_name_plural'   => $item['display_name_plural'],
                    'icon'                  => $item['icon'],
                    'model_name'            => $item['model_name'],
                    'policy_name'           => $item['policy_name'],
                    'controller'            => $item['controller'],
                    'generate_permissions'  => $item['generate_permissions'],
                    'description'           => $item['description'],
                    'server_side'           => $item['server_side'],
                    'details' => $item['details']
                ])->save();
            }
        }
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
