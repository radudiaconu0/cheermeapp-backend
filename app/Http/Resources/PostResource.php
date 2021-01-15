<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Post */
class PostResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'author' => new UserResource($this->author),
            'likesCount' => $this->likes_count,
            'isLiked' => $this->is_liked,
            'commentsCount' => $this->comments_count,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
        ];
    }
}
