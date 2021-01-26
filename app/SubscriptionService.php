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
 * @property int $page_id
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Page $pageId
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $discount_end_date
 * @property string|null $discount_start_date
 * @property int $discount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereDiscountEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionService whereDiscountStartDate($value)
 */
class SubscriptionService extends Model
{
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
}
