<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * App\PostRegister
 *
 * @property int $id
 * @property int $post_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $cod_fiscal
 * @property string|null $company_name
 * @property string|null $payment_method
 * @property string|null $message
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereCodFiscal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Post $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostRegister instruire()
 * @property-read \App\Post $post
 */
class PostRegister extends Model
{
    protected $fillable = [
        'name',
        'post_id',
        'email',
        'phone',
        'cod_fiscal',
        'company_name',
        'payment_method',
        'message'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeInstruire($query)
    {
        $postIds = Post::whereCategoryId(Category::whereSlug(Category::INSTRUIRE_CATEGORY)->first()->id)->pluck('id')->toArray();
        return $query->whereIn('post_id', $postIds);
    }
}
