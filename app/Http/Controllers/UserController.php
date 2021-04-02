<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeProfilePictureRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Auth;
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

    public function changeProfilePicture(ChangeProfilePictureRequest $request)
    {
        if ($request->hasFile('profile_pic')) {
            $avatar = $request->file('profile_pic');
            $path = '/src/uploads/' . Auth::id() . '/images';
            $filename = 'IMG_' . time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->save(public_path($path . $filename));
            $request->user()->profile_pic = $filename;
            $request->user()->save();
            return response()->json([
                'profile_pic' => $filename
            ], 201);
        }
        return response()->json([],202);
    }
}
