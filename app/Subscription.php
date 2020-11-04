<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Subscription
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string $type revista electronica sau consultant SNC
 * @property string|null $company
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $cod_fiscal
 * @property string|null $payment_method
 * @property string|null $message
 * @property string|null $from_date
 * @property string|null $to_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereCodFiscal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $start_date
 * @property string|null $end_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereStartDate($value)
 * @property int $service_id
 * @property-read mixed $display_type
 * @property-read null $translated
 * @property-read \App\SubscriptionService $service
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @property-read \App\User $userId
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription withTranslations($locales = null, $fallback = true)
 * @property string|null $payed_at
 * @property string|null $price
 * @property-read \App\SubscriptionService $serviceId
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription wherePayedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription wherePrice($value)
 */
class Subscription extends Model
{
    use Translatable;

    const TYPE_REVISTA = 'revista';
    const TYPE_CONSULTANT = 'consultant';

    const TYPES = [
        self::TYPE_REVISTA,
        self::TYPE_CONSULTANT
    ];

    protected $fillable = [
        'user_id', 'service_id', 'cod_fiscal', 'payment_method', 'message', 'name', 'email', 'phone', 'company', 'start_date', 'end_date', 'price', 'payed_at'
    ];

    /** for voyager BREAD */
    public function userId()
    {
        return $this->belongsTo(User::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->whereNotNull('end_date')->whereRaw('DATE(end_date) > ' . "'" . Carbon::now()->format('Y-m-d') . "'");
    }

    public function serviceId()
    {
        return $this->belongsTo(SubscriptionService::class, 'service_id', 'id');
    }

    public function getDisplayTypeAttribute()
    {
        return $this->serviceId
            ? $this->serviceId->name
            : null;
    }
}
