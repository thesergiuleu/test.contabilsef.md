<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Comment
 *
 * @property int $id
 * @property int $post_id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereBody($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereEmail($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereName($value)
 * @method static Builder|Comment whereParentId($value)
 * @method static Builder|Comment wherePostId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Comment[] $children
 * @property-read int|null $children_count
 * @property-read Post $post
 * @property int $is_approved
 * @method static Builder|Comment whereIsApproved($value)
 */
class Comment extends Model
{

    protected $fillable = ['name', 'parent_id', 'body', 'email', 'is_approved'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->where('is_approved', 1)->with('children');
    }
}
