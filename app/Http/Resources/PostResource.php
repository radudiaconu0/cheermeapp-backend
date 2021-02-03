<?php

namespace App\Http\Resources;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

/** @mixin Post */
class PostResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'author' => new UserResource($this->whenLoaded('author')),
            'likesCount' => $this->likes_count,
            'isLiked' => $this->is_liked,
            'commentsCount' => $this->comments_count,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'can' => $this->permissions()
        ];
    }

    protected function permissions()
    {
        return [
            'update' => Gate::allows('update', $this->resource),
            'delete' => Gate::allows('delete', $this->resource),
            'like' => Gate::allows('like', $this->resource),
            'comment' => Gate::allows('comment', $this->resource),
            'blockComments' => Gate::allows('blockComments', $this->resource),
            'unBlockComments' => Gate::allows('unBlockComments', $this->resource),
        ];
    }
}
