<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * App\Banner
 *
 * @property int $id
 * @property string $image_path
 * @property string $redirect_url
 * @property int $position
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $image_url
 * @method static Builder|Banner active()
 * @method static Builder|Banner newModelQuery()
 * @method static Builder|Banner newQuery()
 * @method static Builder|Banner query()
 * @method static Builder|Banner whereCreatedAt($value)
 * @method static Builder|Banner whereId($value)
 * @method static Builder|Banner whereImagePath($value)
 * @method static Builder|Banner whereIsActive($value)
 * @method static Builder|Banner wherePosition($value)
 * @method static Builder|Banner whereRedirectUrl($value)
 * @method static Builder|Banner whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Banner extends Model
{
    const POSITION_MAIN_TOP = 'main_top';
    const POSITION_MAIN_CENTER = 'main_center';
    const POSITION_SIDEBAR = 'sidebar';
    const POSITION_INDIVIDUAL = 'individual';

    protected $appends = ['image_url'];

    protected $fillable = ['image_path', 'redirect_url', 'position', 'is_active'];

    public static function getBanners($position)
    {
//        $dummyBanner = new Banner();
//        $dummyBanner->fill([
//            'redirect_url' => config('app.url'),
//            'position' => $position,
//        ]);
//
//        $dummyBanner->image_url = asset('assets/imgs/y.png');

        $banners = [];
        $items = self::active()->wherePosition($position)->get();
        if ($items->count() >= 1) {
            $banners = $items;
        }

        return $banners;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? config('app.url') . Storage::url($this->image_path) : asset('assets/imgs/y.png');
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->whereIsActive(1);
    }
}
