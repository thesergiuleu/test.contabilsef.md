<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Translation;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Page
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string|null $excerpt
 * @property string|null $body
 * @property string|null $image
 * @property string $slug
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read null $translated
 * @property-read Collection|Translation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Page active()
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereAuthorId($value)
 * @method static Builder|Page whereBody($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereExcerpt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereImage($value)
 * @method static Builder|Page whereMetaDescription($value)
 * @method static Builder|Page whereMetaKeywords($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereStatus($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page withTranslation($locale = null, $fallback = true)
 * @method static Builder|Page withTranslations($locales = null, $fallback = true)
 * @mixin Eloquent
 */
class Page extends Model
{
    use Translatable;

    /**
     * Statuses.
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * List of statuses.
     *
     * @var array
     */
    public static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];
    protected $translatable = ['title', 'slug', 'body'];
    protected $guarded = [];

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author_id && Auth::user()) {
            $this->author_id = Auth::user()->getKey();
        }

        return parent::save();
    }

    /**
     * Scope a query to only include active pages.
     *
     * @param  $query  Builder
     *
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }
}
