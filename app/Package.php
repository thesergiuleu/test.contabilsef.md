<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Package
 *
 * @property int $id
 * @property string $alias
 * @property string $name
 * @property string $price
 * @property string $discount
 * @property string|null $discount_started_at
 * @property string|null $discount_ended_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDiscountEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDiscountStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Package extends Model
{
    protected $fillable = [
        'alias',
        'name',
        'price',
        'discount',
        'discount_started_at',
        'discount_ended_at'
    ];

    public function options()
    {
        return $this->belongsToMany(Option::class, 'package_options');
    }

    public function getDiscount()
    {
        $date = Carbon::now()->format('Y-m-d');

        if ($this->discount_ended_at && $this->discount_started_at && $date <= Carbon::parse($this->discount_ended_at)->format('Y-m-d') && $date >= Carbon::parse($this->discount_started_at)->format('Y-m-d')) {
            return (int)$this->discount ?? $this->discount;
        }

        return 0;
    }
}
