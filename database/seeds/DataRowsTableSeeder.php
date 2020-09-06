<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class DataRowsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $file = file_get_contents(database_path('seeds') . '/dataRows.json');
        foreach (json_decode($file, true) as $item) {
            /** @var DataRow $dataRow */
            $dataRow = $this->dataRow(DataType::whereId($item['data_type_id'])->firstOrFail(), $item['field']);

            $arr = [];
            $fillable = $dataRow->getConnection()->getSchemaBuilder()->getColumnListing($dataRow->getTable());
            $a = array_filter($fillable, function ($k) {
                return $k == 'id';
            });
            unset($fillable[key($a)]);
            foreach ($fillable as $field) {
                if ($field == 'details') {
                    if (empty($item[$field])) {
                        continue;
                    }
                }
                $arr[$field] = $item[$field];
            }
            if (!$dataRow->exists) {
                $dataRow->fill($arr)->save();
            }
        }
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::query()->firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }
}
