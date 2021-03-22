<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Payment
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $company
 * @property string|null $cod_fiscal
 * @property string|null $payment_method
 * @property string|null $phone
 * @property string|null $payed_company
 * @property string|null $payed_amount
 * @property string|null $payed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCodFiscal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayedCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @mixin \Eloquent
 * @property string $email
 * @property-read \App\Subscription|null $subscription
 * @property-read \App\User $userId
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereEmail($value)
 */
class Payment extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'company',
        'cod_fiscal',
        'payment_method',
        'phone',
        'payed_at',
        'payed_amount',
        'payed_company'
    ];

    public function userId()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'payment_id', 'id')->withTrashed();
    }

    public function documents()
    {
        return [
            'title' => 'Cont de plată',
            'url' => route('subscription.docs', $this->subscription)
        ];
    }
}
