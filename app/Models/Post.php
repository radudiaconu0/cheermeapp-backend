<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Traits\CanBeLiked;

class Post extends Model implements Likeable
{
    use CanBeLiked;

    protected $fillable = ['text'];

    protected $appends = ['isLiked'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function likes()
    {
        return $this->likers(User::class);
    }

    public function getIsLikedAttribute(): bool
    {
        return auth()->user()->likes($this);
    }

}
