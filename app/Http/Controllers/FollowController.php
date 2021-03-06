<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Auth\Access\AuthorizationException;

class FollowController extends Controller
{
    public function __construct(private IUserRepository $userRepository)
    {
    }

    public function followRequestUser(User $user)
    {
        try {
            $this->authorize('followRequestUser', $user);
        } catch (AuthorizationException $e) {
        }
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
        $this->authorize('getFollowersList', $user);
        return $this->userRepository->getFollowersList($user);
    }

    public function getFollowingList(User $user)
    {
        try {
            $this->authorize('getFollowingList', $user);
        } catch (AuthorizationException $e) {
        }
        return $this->userRepository->getFollowingList($user);
    }

    public function followUser(User $user)
    {
        try {
            $this->authorize('follow-user', $user);
        } catch (AuthorizationException $e) {
        }
        return $this->userRepository->followUser($user);
    }

    public function unFollowUser(User $user)
    {
        $this->authorize('unFollowUser', $user);
        return $this->userRepository->unfollowUser($user);
    }
}
