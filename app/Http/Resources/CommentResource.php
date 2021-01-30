<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

/** @mixin \App\Models\Comment */
class CommentResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author_id' => $this->author_id,
            'post_id' => $this->post_id,
            'likesCount' => $this->likes_count,
            'repliesCount' => $this->replies_count,
            'author' => new UserResource($this->whenLoaded('author')),
            'can' => $this->permissions(),
        ];
    }

    protected function permissions()
    {
        return [
            'update' => Gate::allows('update', $this->resource),
            'delete' => Gate::allows('delete', $this->resource),
            'like' => Gate::allows('like', $this->resource)
        ];
    }
}
