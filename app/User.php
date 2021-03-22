<?php

namespace App;

use App\Notifications\EmailVerificationNotification;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Models\Role;

/**
 * App\User
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string $email
 * @property string|null $avatar
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property mixed $locale
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Role|null $role
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereSettings($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $phone
 * @property string|null $company
 * @property string|null $position
 * @method static Builder|User whereCompany($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePosition($value)
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read EmailValidation $emailValidation
 * @property-read mixed $email_hash
 * @property-read Collection|\App\Payment[] $payments
 * @property-read int|null $payments_count
 */
class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'company', 'position',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendConfirmEmail()
    {
        /** @var EmailValidation $validation */
        $validation = $this->emailValidation()->create([
            'user_id' => $this->id,
            'token' => $this->email_hash
        ]);

        Notification::send($this, new EmailVerificationNotification($validation));
    }

    /**
     * @param array|int $id
     * @return mixed
     */
    public function activeSubscription($id)
    {
        $query = $this->subscriptions()->active()->orderByDesc('expired_at');

        if (is_array($id)) {
            return $query->whereIn('service_id', $id)->first();
        }

        return $query->where('service_id', $id)->first();
    }

    /**
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getEmailHashAttribute()
    {
        return md5(uniqid($this->id . '_' . $this->email, config('app.url')));
    }

    public function emailValidation()
    {
        return $this->belongsTo(EmailValidation::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public static function createUser(array $data)
    {
        return User::query()->create([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'position' => $data['position'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public static function validateUser($data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:9'],
            'company' => ['nullable', 'string'],
            'position' => ['nullable', 'string'],
            'terms' => ['required', 'accepted'],
            'newsletter' => ['nullable'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'user_posts')->withTimestamps();
    }

    public function hasSeen(Post $post)
    {
        return $this->posts()->where('post_id', $post->id)->exists();
    }
}
