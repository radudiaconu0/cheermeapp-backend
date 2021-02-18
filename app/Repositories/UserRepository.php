<?php


namespace App\Repositories;


use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

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
            $user->unfollow($authUser);
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

    public function changeAccountType(): \Illuminate\Http\JsonResponse
    {
        $updated = match (auth()->user()->account_type) {
            'public' => auth()->user()->update(['account_type' => 'private']),
            'private' => auth()->user()->update(['account_type' => 'public'])
        };
        return response()->json([
            'success' => $updated
        ], $updated ? 202 : 415);

    }

    public function followRequestUser(User $user): ResponseBuilder|Response
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

    public function cancelFollowRequest(User $user): ResponseBuilder|Response
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

    public function declineFollowRequest(User $user): ResponseBuilder|Response
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
