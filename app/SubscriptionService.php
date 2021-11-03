<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * App\SubscriptionService
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Package[] $packages
 * @property-read int|null $packages_count
 * @property-read \App\Page|null $page
 * @property-read \App\Page|null $pageId
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubscriptionService extends Model
{
    protected $appends = [
        'service_link'
    ];
    protected $fillable = ['page_id', 'name', 'description'];

    public function pageId() {
        return $this->belongsTo(Page::class, 'page_id','id');
    }
    public function page() {
        return $this->belongsTo(Page::class, 'page_id','id');
    }

    /**
     * todo
     * @return int
     */
    public function getDiscount()
    {

        $date = Carbon::now()->format('Y-m-d');

        if ($this->discount_end_date && $this->discount_start_date && $date <= Carbon::parse($this->discount_end_date)->format('Y-m-d') && $date >= Carbon::parse($this->discount_start_date)->format('Y-m-d')) {
            return (int)$this->discount ?? $this->discount;
        }

        return 0;
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'subscription_service_packages');
    }

    public function getServiceLinkAttribute(): string
    {
        return "/service/" . $this->id;
    }
}
