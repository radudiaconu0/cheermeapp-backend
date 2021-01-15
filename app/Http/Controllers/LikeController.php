<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function likePost(Post $post): Response
    {
        $user = auth()->user();
        if ($user->like($post)) {
            $data = [
                'likes' => $post->likers(User::class)->count()
            ];
            return ResponseBuilder::success($data);
        } else return ResponseBuilder::error(BaseApiCodes::EX_HTTP_EXCEPTION())->setStatusCode(400);
    }

    public function unLikePost(Post $post): Response
    {
        $user = Auth::user();
        if ($user->unlike($post)) {
            $data = [
                'likes' => $post->likers(User::class)->count()
            ];
            return ResponseBuilder::success($data);
        } else return ResponseBuilder::error(BaseApiCodes::EX_HTTP_EXCEPTION())->setStatusCode(400);
    }

    public function likeComment(Comment $comment): Response
    {
        $user = Auth::user();
        if ($user->like($comment)) {
            $data = [
                'likes' => $comment->likers(User::class)->count()
            ];
            return ResponseBuilder::success($data);
        } else return ResponseBuilder::error(BaseApiCodes::EX_HTTP_EXCEPTION())->setStatusCode(400);
    }

    public function unLikeComment(Comment $comment): Response
    {
        $user = Auth::user();
        if ($user->unlike($comment)) {
            $data = [
                'likes' => $comment->likers(User::class)->count()
            ];
            return ResponseBuilder::success($data);
        } else return ResponseBuilder::error(BaseApiCodes::EX_HTTP_EXCEPTION())->setStatusCode(400);
    }
}
