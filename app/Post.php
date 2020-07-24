<?php

namespace App;

use Eloquent;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Models\Translation;
use TCG\Voyager\Traits\Resizable;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Post
 *
 * @property int $id
 * @property int $author_id
 * @property int|null $category_id
 * @property string $title
 * @property string|null $seo_title
 * @property string|null $excerpt
 * @property string $body
 * @property string|null $image
 * @property string $slug
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string $status
 * @property int $featured
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $authorId
 * @property-read Category|null $category
 * @property-read null $translated
 * @property-read Collection|Translation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post published()
 * @method static Builder|Post query()
 * @method static Builder|Post whereAuthorId($value)
 * @method static Builder|Post whereBody($value)
 * @method static Builder|Post whereCategoryId($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereExcerpt($value)
 * @method static Builder|Post whereFeatured($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereImage($value)
 * @method static Builder|Post whereMetaDescription($value)
 * @method static Builder|Post whereMetaKeywords($value)
 * @method static Builder|Post whereSeoTitle($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereStatus($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post withTranslation($locale = null, $fallback = true)
 * @method static Builder|Post withTranslations($locales = null, $fallback = true)
 * @mixin Eloquent
 * @property-read string $date
 * @property-read string $link
 * @property-read string $new
 * @property-read string $post_url
 * @property-read string $short
 * @property-read string $thumbnail_url
 * @property-read string $views
 */
class Post extends Model
{
    use Translatable;
    use Resizable;

    const PUBLISHED = 'PUBLISHED';
    protected $translatable = ['title', 'seo_title', 'excerpt', 'body', 'slug', 'meta_description', 'meta_keywords'];
    protected $guarded = [];

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author_id && Auth::user()) {
            $this->author_id = Auth::user()->getKey();
        }

        return parent::save();
    }

    public function authorId()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Scope a query to only published scopes.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', static::PUBLISHED);
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return string
     */
    public function getPostUrlAttribute()
    {
        return route('post.view', $this->slug);
    }

    /**
     * @return string
     */
    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d.m.Y');
    }

    /**
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        return asset('storage' . '/' . $this->image);
    }

    /**
     * @return string
     */
    public function getViewsAttribute()
    {
        return '300';
    }

    /**
     * @return string
     */
    public function getNewOnPicAttribute()
    {
        $diff = Carbon::now()->diffInDays(Carbon::parse($this->created_at));

        if ($diff <= 5)
            return '<div class="nou">NOU</div>';
    }

    public function getNewOnTextAttribute()
    {
        $diff = Carbon::now()->diffInDays(Carbon::parse($this->created_at));

        if ($diff <= 5)
            return '<div style="position: initial; display: inline-block" class="nou">NOU</div>';
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return "<a target='blank' href='#'> Something more than something</a>";
    }

    /**
     * @param $length
     * @return string
     */
    public function getShort($length)
    {
        $body = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/is', "$1$3", $this->body);
        $short = mb_substr( strip_tags( $body)  , 0 , $length);
        if (strlen( strip_tags($body) )  > $length){
            $short .= '...';
        }
        return $short;
    }

    public function getCommentsCountAttribute()
    {
        return 20;
    }

}
