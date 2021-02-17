<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class BlockController extends Controller
{
    public function __construct(private IUserRepository $userRepository)
    {
    }

    public function blockUser(User $user)
    {
        return $this->userRepository->blockUser($user);
    }

    public function unBlockUser(User $user)
    {
        return $this->userRepository->unBlockUser($user);
    }

    public function getBlockList()
    {
        return $this->userRepository->getBlockList();
    }
}
