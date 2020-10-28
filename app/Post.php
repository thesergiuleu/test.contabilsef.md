<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
 * @property string $views
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
 * @property int $privacy
 * @property-read mixed $comments_count
 * @property-read string $new_on_pic
 * @property-read mixed $new_on_text
 * @method static Builder|Post wherePrivacy($value)
 * @property string|null $event_date
 * @property-read Collection|Comment[] $comments
 * @method static Builder|Post whereEventDate($value)
 * @method static Builder|Post whereViews($value)
 * @property string|null $external_author
 * @property-read Collection|PostRegister[] $postRegisters
 * @property-read int|null $post_registers_count
 * @method static Builder|Post whereExternalAuthor($value)
 * @property string|null $emails
 * @property int $is_own
 * @method static Builder|Post whereEmails($value)
 * @method static Builder|Post whereIsOwn($value)
 * @property int $cant_copy
 * @property string|null $price
 * @method static Builder|Post whereCantCopy($value)
 * @method static Builder|Post wherePrice($value)
 * @property string|null $scheduled_at
 * @method static Builder|Post whereScheduledAt($value)
 */
class Post extends Model
{
    use Translatable;
    use Resizable;

    const PUBLISHED = 'PUBLISHED';
    const PENDING = 'PENDING';
    const DRAFT = 'DRAFT';

    const PAYMENT_METHODS = [
        '' => 'Alege',
        'cash' => 'Numerar',
        'transfer' => 'Transfer'
    ];

    protected $translatable = ['title', 'seo_title', 'views', 'privacy', 'body', 'slug', 'meta_description', 'meta_keywords', 'emails'];
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
        if ($this->external_link && trim($this->external_link) !== '') {
            return $this->external_link;
        }
        return route('post.view', [$this->category->slug ?? '', $this->slug ?? '']);
    }


    /**
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->image ? asset('storage' . '/' . $this->image) : null;
    }

    /**
     * @return string
     */
    public function getNewOnPicAttribute()
    {
        $diff = Carbon::now()->diffInDays(Carbon::parse($this->created_at));

        if ($diff <= 5)
            return $this->thumbnail_url ? '<div class="nou">NOU</div>' : '';
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
        return $this->external_author;
    }

    /**
     * @param $length
     * @return string
     */
    public function getShort($length)
    {
        $body = preg_replace('/(<(script|style)\b[^>]*>).*?(<\/\2>)/is', "$1$3", $this->excerpt ?: $this->body);
        $short = mb_substr(strip_tags($body), 0, $length);
        if (strlen(strip_tags($body)) > $length) {
            $short .= '...';
        }
        return $short;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', 1);
    }

    public function postRegisters()
    {
        return $this->hasMany(PostRegister::class);
    }

    public function hasCommentsComponent()
    {
        return in_array($this->category->slug, Category::CATEGORIES_WITH_COMMENTS) || in_array($this->category->parent_category->slug, Category::CATEGORIES_WITH_COMMENTS);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeInstruire($query)
    {
        return $query->whereCategoryId(Category::whereSlug(Category::INSTRUIRE_CATEGORY)->first()->id);
    }
}
