<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use TCG\Voyager\Models\Translation;

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
 * @method static Builder|\TCG\Voyager\Models\Page active()
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
 * @method static Builder|\TCG\Voyager\Models\Page whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|\TCG\Voyager\Models\Page withTranslation($locale = null, $fallback = true)
 * @method static Builder|\TCG\Voyager\Models\Page withTranslations($locales = null, $fallback = true)
 * @mixin Eloquent
 * @property int $has_sidebar
 * @property string|null $seo_title
 * @method static Builder|Page whereHasSidebar($value)
 * @method static Builder|Page whereSeoTitle($value)
 */
class Page extends \TCG\Voyager\Models\Page
{
    const SUBSCRIBE = "revista-electronica-contabilsef-md";
    const CONSULTANT_SNC = "ro-consultant-snc-ru-en";

    const TERMS_AND_CONDITIONS_SNC = "termeni-si-conditii-consultant-snc";
    const TERMS_AND_CONDITIONS_REVISTA = "termeni-si-conditii-revista-electronica-contabilsef-md";
    const TERMS_AND_CONDITIONS_INSTRUIRE = "termeni-si-conditii-seminar";
}
