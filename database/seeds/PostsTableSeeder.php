<?php

use App\Http\Controllers\Admin\PostController;
use App\Post;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class PostsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        //Permissions
        Permission::generateFor('posts');

        if (env('APP_ENV') != 'production') {
            foreach (\App\Category::all() as $item) {
                if (!$item->children()->exists()) {
                    $data = [
                        'category_id' => $item->id,
                        'author_id' => 1,
                        'status' => Post::PUBLISHED
                    ];
                    if ($item->slug == 'instruire') {
                        $data = [
                            'category_id' => $item->id,
                            'author_id' => 1,
                            'status' => Post::PUBLISHED,
                            'privacy' => 1
                        ];
                    }
                    for ($i = 0; $i < 5; $i++) {
                        factory(Post::class)->create($data);
                    }
                }
            }
        }
    }

    /**
     * [post description].
     *
     * @param [type] $slug [description]
     *
     * @return [type] [description]
     */
    protected function findPost($slug)
    {
        return Post::firstOrNew(['slug' => $slug]);
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
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
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
