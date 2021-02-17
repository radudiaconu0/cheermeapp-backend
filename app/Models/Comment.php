<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Traits\CanBeLiked;

class Comment extends Model implements Likeable
{
    use CanBeLiked;

    protected $fillable = ['author', 'text', 'parent', 'post'];

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function replies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->where('parent_id', '!=');
    }
}
