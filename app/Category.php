<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
 * @property-read Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read mixed $parent_category
 * @property-read Collection|Post[] $subPosts
 * @property-read int|null $sub_posts_count
 */
class Category extends Model
{
    use Translatable;

    const DESPRE_NOI = 'ro-despre-noi-ru-en';
    const NOUTATI = 'ro-nout-i-ru-en';
    const ARTICOLE = 'ro-articole-ru-en-articole';
    const LEGISLATIA = 'ro-legisla-ia-ru-en-legisla-ia';
    const INFORMATII_UTILE = 'ro-informa-ii-utile-ru-en-informa-ii-utile';
    const FORMULARE = 'ro-formulare-ru-en';
    const CONTABILITATE = 'ro-contabile-ru-en';
    const FISCALE = 'ro-fiscale-ru-en';

    const PARENT_CATEGORIES = [
        self::DESPRE_NOI => 'despre-noi',
        self::NOUTATI => 'nouta-i',
        self::ARTICOLE => 'articole',
        self::LEGISLATIA => 'legisla-ia',
        self::INFORMATII_UTILE => 'informa-ii-utile',
        self::FORMULARE => 'formulare',
        self::CONTABILITATE => 'contabile',
        self::FISCALE => 'fiscale',
    ];

    const NEWS_CATEGORY = 'nouta-i';
    const CONTABIL_SEF_NEWS_CATEGORY = 'nouta-i-contabilsef';
    const GENERAL_NEWS_CATEGORY = 'nouta-i-generale';
    const ARTICLES_CATEGORY = 'articole';
    const INSTRUIRE_CATEGORY = 'instruire';
    const LEGISLATION_CATEGORY = 'legisla-ia';
    const INFORMATII_UTILE_CATEGORY = 'informa-ii-utile';
    const SNC_2020_CATEGORY = 'snc-2020';
    const INDICATORI_FISCALI_CATEGORY = 'indicatori-fiscali';
    const SINTEZA_MONITORULUI_OFICIAL_CATEGORY = 'sinteza-monitorului-oficial';
    const GLOSARY_CATEGORY = 'dic-ionar-contabil';

    const CATEGORIES_WITH_COMMENTS = [
        self::ARTICLES_CATEGORY,
        self::NEWS_CATEGORY
    ];

    const CATEGORIES = [
        self::NEWS_CATEGORY => [
            'slug' => self::NEWS_CATEGORY,
            'order' => 1,
            'name' => 'Noutăţi',
        ],
        self::CONTABIL_SEF_NEWS_CATEGORY => [
            'slug' => self::CONTABIL_SEF_NEWS_CATEGORY,
            'parent_id' => 1,
            'order' => 2,
            'name' => 'Noutăţi ContabilȘef'
        ],
        self::GENERAL_NEWS_CATEGORY => [
            'slug' => self::GENERAL_NEWS_CATEGORY,
            'parent_id' => 1,
            'order' => 3,
            'name' => 'Noutăţi generale',
        ],
        self::ARTICLES_CATEGORY => [
            'slug' => self::ARTICLES_CATEGORY,
            'order' => 4,
            'name' => 'Articole',
        ],
        self::INSTRUIRE_CATEGORY => [
            'slug' => self::INSTRUIRE_CATEGORY,
            'order' => 5,
            'name' => 'Instruire',
        ],
        self::LEGISLATION_CATEGORY => [
            'slug' => self::LEGISLATION_CATEGORY,
            'order' => 6,
            'name' => 'Legislaţia',
        ],
        self::INFORMATII_UTILE_CATEGORY => [
            'slug' => self::INFORMATII_UTILE_CATEGORY,
            'order' => 7,
            'name' => 'Informaţii utile'
        ],
        self::SNC_2020_CATEGORY => [
            'slug' => self::SNC_2020_CATEGORY,
            'parent_id' => 7,
            'order' => 8,
            'name' => 'SNC 2020',
        ],
        self::INDICATORI_FISCALI_CATEGORY => [
            'slug' => self::INDICATORI_FISCALI_CATEGORY,
            'parent_id' => 7,
            'order' => 9,
            'name' => 'Indicatori fiscali',
        ],
        self::SINTEZA_MONITORULUI_OFICIAL_CATEGORY => [
            'slug' => self::SINTEZA_MONITORULUI_OFICIAL_CATEGORY,
            'parent_id' => 6,
            'order' => 10,
            'name' => 'Sinteza Monitorului Oficial',
        ]
    ];


    protected $translatable = ['slug', 'name'];

    protected $table = 'categories';

    protected $fillable = ['slug', 'name'];

    public function posts()
    {
        return $this->hasMany(Post::class)
            ->published();
    }

    public function parentId()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function getParentCategoryAttribute()
    {
        return $this->getParentCategory($this->parentId);
    }

    protected function getParentCategory($parent)
    {
        if ($parent) {
            $this->getParentCategory($parent->parentId);
            return $parent;
        }
        return $this;
    }

    public function subPosts()
    {
        return $this
            ->hasManyThrough(Post::class, self::class, 'parent_id', 'category_id')
            ->published();
    }

    public function getPosts()
    {
        return $this->posts()
            ->when($this->slug === Category::INSTRUIRE_CATEGORY, function (Builder $query) {
                $query
                    ->where(DB::raw('DATE(event_date)'), '>=', Carbon::now()->format('Y-m-d'))
                    ->orderBy(DB::raw('DATE(event_date)'));
            });
    }
}
