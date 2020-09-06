<?php

namespace App;

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
 */
class SubscriptionService extends Model
{
    protected $fillable = ['page_id', 'name', 'description', 'price'];

    public function pageId() {
        return $this->belongsTo(Page::class, 'page_id','id');
    }
}
