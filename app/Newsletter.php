<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Newsletter
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Newsletter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Newsletter extends Model
{
    protected $fillable = [
      'name',
      'email'
    ];
}
