<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private IUserRepository $userRepository)
    {
    }

    public function changeAccountType()
    {
        return $this->userRepository->changeAccountType();
    }

    public function getUserById(User $user)
    {
        return new UserResource($user);
    }

    public function getUserByUsername(User $user)
    {
        return new UserResource($user);
    }
}
