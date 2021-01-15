<?php


namespace App\Repositories;


use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class UserRepository implements IUserRepository
{

    public function followUser(User $user)
    {
        $authUser = auth()->user();
        try {
            if ($authUser->follow($user)) {
                return ResponseBuilder::success([
                    'followersCount' => $user->followers()->count()
                ])->setStatusCode(200);
            } else return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }

    public function unfollowUser(User $user)
    {
        $authUser = auth()->user();
        try {
            if ($authUser->unfollow($user)) {
                return ResponseBuilder::success([
                    'followersCount' => $user->followers()->count()
                ])->setStatusCode(200);
            }
            return ResponseBuilder::error(BaseApiCodes::EX_UNCAUGHT_EXCEPTION());
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }

    public function blockUser(User $user)
    {
        $authUser = auth()->user();
        try {
            $authUser->unfollow($user);
            if ($authUser->block($user))
                return response()->json([
                    "success" => true,
                ]);
            return response()->json([
                "success" => false,
                "message" => "Something went wrong"
            ], 401);
        } catch (ModelNotFoundException $e) {
            return ResponseBuilder::asError(BaseApiCodes::EX_HTTP_NOT_FOUND())->withMessage($e->getMessage());
        }
    }

    public function unBlockUser(User $user)
    {
        try {
            $authUser = auth()->user();
            if ($authUser->unblock($user))
                return ResponseBuilder::asSuccess(BaseApiCodes::OK());
            return ResponseBuilder::asError(BaseApiCodes::EX_HTTP_EXCEPTION());
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::asError(BaseApiCodes::EX_HTTP_NOT_FOUND())->withHttpCode(404);
        }
    }

    public function getFollowersList(User $user)
    {
        try {
            $followersList = UserResource::collection($user->followers()->get());
            return ResponseBuilder::asSuccess(BaseApiCodes::OK())->withData($followersList);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }

    public function getFollowingList(User $user)
    {
        try {
            $followingList = UserResource::collection($user->following()->get());
            return ResponseBuilder::asSuccess(BaseApiCodes::OK())->withData($followingList);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }

    public function getBlockList()
    {
        $authUser = auth()->user();
        $blockingList = UserResource::collection($authUser->blocking()->get());
        return ResponseBuilder::asSuccess(BaseApiCodes::OK())->withData($blockingList);
    }

    public function changeAccountType()
    {
        $authUser = auth()->user();
        $accountType = $authUser->account_type;
        $updated = match ($accountType) {
            'public' => $authUser->update(['account_type' => 'private']),
            'private' => $authUser->update(['account_type' => 'public'])
        };
        if ($updated) {
            return response()->json([
                'success' => true
            ], 202);
        } else {
            return response()->json([
                'success' => false
            ], 415);
        }
    }

    public function followRequestUser(User $user)
    {
        try {
            $authUser = auth()->user();
            $requested = $authUser->followRequest($user);
            if ($requested) {
                return ResponseBuilder::asSuccess(BaseApiCodes::OK());
            }
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }

    public function acceptFollowRequest(User $user)
    {
        try {
            $authUser = auth()->user();
            $accepted = $authUser->acceptFollowRequest($user);
            if ($accepted) {
                return ResponseBuilder::asSuccess(BaseApiCodes::OK());
            }
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }

    public function cancelFollowRequest(User $user)
    {
        try {
            $authUser = auth()->user();
            $canceled = $authUser->cancelFollowRequest($user);
            if ($canceled) {
                return ResponseBuilder::asSuccess(BaseApiCodes::OK());
            }
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }

    public function declineFollowRequest(User $user)
    {
        try {
            $authUser = auth()->user();
            $declined = $authUser->declineFollowRequest($user);
            if ($declined) {
                return ResponseBuilder::asSuccess(BaseApiCodes::OK());
            }
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND());
        }
    }
}
