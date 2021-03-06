<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function followUser(User $user, User $followable): bool
    {
        return !$user->blocks($followable) && !$followable->blocks($user);
    }
    public function unFollowUser(User $user, User $followable): bool
    {
        return !$user->blocks($followable) && !$followable->blocks($user);
    }
    public function getFollowingList(User $user, User $followable): bool
    {
        return !$user->blocks($followable) && !$followable->blocks($user) && $user->account_type==='public';
    }
    public function getFollowersList(User $user, User $followable): bool
    {
        return !$user->blocks($followable) && !$followable->blocks($user)  && $user->account_type==='public';
    }
    public function followRequestUser(User $user, User $followable): bool
    {
        return !$user->blocks($followable) && !$followable->blocks($user);
    }

    public function view(User $viewer, User $viewable): bool
    {
        return !$viewable->blocks($viewer);
    }
}
