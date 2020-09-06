<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PoolAnswer
 *
 * @property int $id
 * @property int $pool_id
 * @property int $pool_option_id
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Pool $pool
 * @property-read \App\PoolOption $poolOption
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer wherePoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer wherePoolOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolAnswer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PoolAnswer extends Model
{
    protected $fillable = ['pool_id', 'pool_option_id', 'ip_address'];

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function poolOption()
    {
        return $this->belongsTo(PoolOption::class);
    }
}
