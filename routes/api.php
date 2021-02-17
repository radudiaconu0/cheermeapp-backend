<?php

use App\Http\Controllers\BlockController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OtherBrowserSessionsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::apiResource('comments', CommentController::class)->except([
        'show'
    ]);
    Route::apiResource('posts', PostController::class)->except([
        'index'
    ]);
    Route::get('sessions', function (Request $request) {
       return $request->session()->all();
    });
    Route::get('user/{user}/timeline', [PostController::class, 'getTimeline']);
    Route::get('feed', [PostController::class, 'getFeed']);
    Route::get('posts/{post}/comments', [PostController::class, 'getComments']);
    Route::post('posts/{post}/comments', [CommentController::class, 'store']);
    Route::post('comments/{post}/replies', [CommentController::class, 'storeReply']);
    Route::get('comments/{post}/replies', [CommentController::class, 'getReplies']);

    Route::post('posts/{post}/comments/block', [PostController::class, 'blockComments']);
    Route::post('posts/{post}/comments/unBlock', [PostController::class, 'unBlockComments']);
    Route::post('posts/{post}/likes', [LikeController::class, 'likePost']);
    Route::delete('posts/{post}/likes', [LikeController::class, 'unLikePost']);
    Route::get('posts/{post}/likes', [PostController::class, 'getPostLikes']);
    Route::post('comments/{comment}/likes', [LikeController::class, 'likeComment']);
    Route::delete('comments/{comment}/likes', [LikeController::class, 'unLikeComment']);
    Route::get('comments/{comment}/likes', [CommentController::class, 'getCommentLikes']);
    Route::get('user/{user}', [UserController::class, 'getUserById']);
    Route::get('user/{user:username}', [UserController::class, 'getUserByUsername']);
    Route::post('user/{user}/block', [BlockController::class, 'blockUser']);
    Route::delete('user/{user}/block', [BlockController::class, 'unBlockUser']);
    Route::post('user/{user}/follow', [FollowController::class, 'followUser']);
    Route::delete('user/{user}/follow', [FollowController::class, 'unFollowUser']);
    Route::get('user/block-list', [BlockController::class, 'getBlockList']);
    Route::get('user/{user}/follower-list', [FollowController::class, 'getFollowersList']);
    Route::get('user/{user}/following-list', [FollowController::class, 'getFollowingList']);

    Route::delete('user/{user}/follow/cancel', [FollowController::class, 'cancelFollowRequest']);
    Route::post('user/{user}/follow/request', [FollowController::class, 'followRequestUser']);
    Route::post('user/{user}/follow/decline', [FollowController::class, 'declineFollowRequest']);
    Route::post('user/{user}/follow/accept', [FollowController::class, 'acceptFollowRequest']);

    Route::put('user/change-account-type', [UserController::class, 'changeAccountType']);
});

