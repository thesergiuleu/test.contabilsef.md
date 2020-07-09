<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use TCG\Voyager\Models\Translation;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $order
 * @property string $name
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read null $translated
 * @property-read Category $parentId
 * @property-read Collection|Post[] $posts
 * @property-read int|null $posts_count
 * @property-read Collection|Translation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereOrder($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category withTranslation($locale = null, $fallback = true)
 * @method static Builder|Category withTranslations($locales = null, $fallback = true)
 * @mixin Eloquent
 */
class Category extends Model
{
    use Translatable;

    protected $translatable = ['slug', 'name'];

    protected $table = 'categories';

    protected $fillable = ['slug', 'name'];

    public function posts()
    {
        return $this->hasMany(Post::class)
            ->published()
            ->orderBy('created_at', 'DESC');
    }

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }
}
