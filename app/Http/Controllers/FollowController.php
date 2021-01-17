<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class FollowController extends Controller
{
    public function __construct(private IUserRepository $userRepository)
    {
    }

    public function followRequestUser(User $user)
    {
        $this->authorize('follow', $user);
        return $this->userRepository->followRequestUser($user);
    }

    public function acceptFollowRequest(User $user)
    {
        return $this->userRepository->acceptFollowRequest($user);
    }

    public function cancelFollowRequest(User $user)
    {
        return $this->userRepository->cancelFollowRequest($user);

    }

    public function declineFollowRequest(User $user)
    {
        return $this->userRepository->declineFollowRequest($user);
    }

    public function getFollowersList(User $user)
    {
        return $this->userRepository->getFollowersList($user);
    }

    public function getFollowingList(User $user)
    {
        return $this->userRepository->getFollowingList($user);

    }

    public function followUser(User $user)
    {
        $this->authorize('follow-user', $user);
        //return response()->json(['blocked' => !$user->blocks(auth()->user()) || !auth()->user()->blocks($user)]);
         return $this->userRepository->followUser($user);
    }

    public function unFollowUser(User $user)
    {
        return $this->userRepository->unfollowUser($user);

    }
}
