<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\ILikeRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function __construct(private ILikeRepository $likeRepository)
    {
    }

    public function likePost(Post $post): Response
    {
        try {
            $this->authorize('like', $post);
        } catch (AuthorizationException $e) {
        }
        $this->likeRepository->likePost($post);
    }

    public function unLikePost(Post $post): Response
    {
        try {
            $this->authorize('unLike', $post);
        } catch (AuthorizationException $e) {
        }
        return $this->likeRepository->likePost($post);
    }

    public function likeComment(Comment $comment): Response
    {
        try {
            $this->authorize('like', $comment);
        } catch (AuthorizationException $e) {
        }
        return $this->likeRepository->likeComment($comment);
    }

    public function unLikeComment(Comment $comment): Response
    {
        try {
            $this->authorize('unLike', $comment);
        } catch (AuthorizationException $e) {
        }
        return $this->likeRepository->unLikeComment($comment);
    }
}
