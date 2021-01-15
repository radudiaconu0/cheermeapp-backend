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

    public function follow(User $follower, User $followable): bool
    {
        return !$follower->blocks($followable);
    }

    public function view(User $viewer, User $viewable): bool
    {
        return $viewable->blocks($viewer);
    }
}
