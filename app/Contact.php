<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereEmail($value)
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereMessage($value)
 * @method static Builder|Contact whereName($value)
 * @method static Builder|Contact wherePhone($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $ip_address
 * @property string $page
 * @method static Builder|Contact whereIpAddress($value)
 * @method static Builder|Contact wherePage($value)
 */
class Contact extends Model
{
    const PAGE_PROFILE = 'profile';
    const PAGE_CONTACT = 'contact_page';
    const CONTACT_FORM = 'contact_form';

    const PAGES = [
        self::PAGE_PROFILE,
        self::CONTACT_FORM,
        self::PAGE_CONTACT
    ];

    protected $fillable = ['name', 'phone', 'email', 'message', 'page', 'ip_address'];
}
