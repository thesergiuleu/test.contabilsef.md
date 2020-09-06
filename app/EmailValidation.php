<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EmailValidation
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailValidation whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\User $user
 */
class EmailValidation extends Model
{
    protected $fillable = ['user_id', 'token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
