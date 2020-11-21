<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Glosary
 *
 * @property int $id
 * @property string $keyword
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Glosary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Glosary extends Model
{
    protected $fillable = [
        'keyword',
        'description'
    ];
}
