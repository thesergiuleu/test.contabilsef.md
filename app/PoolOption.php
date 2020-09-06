<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PoolOption
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PoolAnswer[] $answers
 * @property-read int|null $answers_count
 * @property-read mixed $percentage
 * @property-read mixed $votes
 * @property-read \App\Pool $pool
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PoolOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PoolOption extends Model
{
    protected $fillable = ['name'];

    public function answers()
    {
        return $this->hasMany(PoolAnswer::class);
    }


    public function getVotes(Pool $pool)
    {
        return $pool->answers()->where('pool_option_id', $this->id)->count();
    }

    public function getPercentage(Pool $pool)
    {
        return ($this->getVotes($pool) * 100) / $pool->answers()->count();
    }
}
