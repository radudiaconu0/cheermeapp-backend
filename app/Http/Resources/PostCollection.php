<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Post */
class PostCollection extends ResourceCollection
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
