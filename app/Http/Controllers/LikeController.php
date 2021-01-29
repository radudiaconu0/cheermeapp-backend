<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\ILikeRepository;
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
        $this->authorize('like', $post);
        $this->likeRepository->likePost($post);
    }

    public function unLikePost(Post $post): Response
    {
        $this->authorize('unLike', $post);
        return $this->likeRepository->likePost($post);
    }

    public function likeComment(Comment $comment): Response
    {
        $this->authorize('like', $comment);
        return $this->likeRepository->likeComment($comment);
    }

    public function unLikeComment(Comment $comment): Response
    {
        $this->authorize('unLike', $comment);
        return $this->likeRepository->unLikeComment($comment);
    }
}
