<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Pool
 *
 * @property int $id
 * @property string $question
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|PoolAnswer[] $answers
 * @property-read int|null $answers_count
 * @property-read mixed $decoded_options
 * @property-read Collection|PoolOption[] $poolOptions
 * @property-read int|null $pool_options_count
 * @method static Builder|Pool newModelQuery()
 * @method static Builder|Pool newQuery()
 * @method static Builder|Pool query()
 * @method static Builder|Pool whereCreatedAt($value)
 * @method static Builder|Pool whereId($value)
 * @method static Builder|Pool whereQuestion($value)
 * @method static Builder|Pool whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Pool extends Model
{
    protected $fillable = ['question', 'options'];

    public function getDecodedOptionsAttribute()
    {
        return json_decode($this->options, true);
    }

    public function answers()
    {
        return $this->hasMany(PoolAnswer::class);
    }

    public function poolOptions()
    {
        return $this->belongsToMany(PoolOption::class, 'pool_pool_options', 'pool_id', 'pool_option_id');
    }
}
