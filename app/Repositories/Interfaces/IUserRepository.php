<?php


namespace App\Repositories\Interfaces;


use App\Models\User;
use Illuminate\Http\Request;

interface IUserRepository
{
    public function followUser(User $user);

    public function unfollowUser(User $user);

    public function blockUser(User $user);

    public function unBlockUser(User $user);

    public function getFollowersList(User $user);

    public function getFollowingList(User $user);

    public function getBlockList();

    public function changeAccountType();

    public function followRequestUser(User $user);

    public function acceptFollowRequest(User $user);

    public function cancelFollowRequest(User $user);

    public function declineFollowRequest(User $user);

}
