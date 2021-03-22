<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;


/**
 * App\Subscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $package_id
 * @property int $payment_id
 * @property int $service_id
 * @property string|null $started_at
 * @property string|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $display_type
 * @property-read null $translated
 * @property-read \App\Package $package
 * @property-read \App\Package $packageId
 * @property-read \App\Payment $payment
 * @property-read \App\Payment $paymentId
 * @property-read \App\SubscriptionService $service
 * @property-read \App\SubscriptionService $serviceId
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @property-read \App\User $user
 * @property-read \App\User $userId
 * @method static Builder|Subscription active()
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereExpiredAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription wherePackageId($value)
 * @method static Builder|Subscription wherePaymentId($value)
 * @method static Builder|Subscription whereServiceId($value)
 * @method static Builder|Subscription whereStartedAt($value)
 * @method static Builder|Subscription whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static Builder|Subscription whereUpdatedAt($value)
 * @method static Builder|Subscription whereUserId($value)
 * @method static Builder|Subscription withTranslation($locale = null, $fallback = true)
 * @method static Builder|Subscription withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 */
class Subscription extends Model
{
    use Translatable, SoftDeletes;

    protected $fillable = [
        'user_id', 'package_id', 'payment_id', 'service_id', 'started_at', 'expired_at'
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
        return $builder->whereNotNull('expired_at')->whereRaw('DATE(expired_at) > ' . "'" . Carbon::now()->format('Y-m-d') . "'");
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
    public function packageId()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
    public function paymentId()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(SubscriptionService::class, 'service_id', 'id');
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
    public function status()
    {
        switch (true) {
            case $this->deleted_at:
                return "Anulată";
            case is_null($this->expired_at):
                return "Așteaptă achitarea";
            case Carbon::parse($this->expired_at)->format('Y-m-d') > now()->format('Y-m-d'):
                return "Activă";
        }
    }
}
