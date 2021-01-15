<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $authUser = auth()->user();
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'email' => $this->email,
            'email_verified' => !!$this->email_verified_at,
            'isFollowMe' => $this->isFollowing($authUser),
            'isFollowedByMe' => $authUser->isFollowing($this->resource),
            'isBlockedByMe' => $authUser->isBlocking($this->resource),
            'followersCount' => $this->followers_count,
            'followingCount' => $this->following_count,
            'has2FA' => $this->two_factor_secret ? true : false
        ];
    }
}
