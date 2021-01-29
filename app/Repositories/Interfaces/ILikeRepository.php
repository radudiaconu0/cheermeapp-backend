<?php


namespace App\Repositories\Interfaces;


use App\Models\Comment;
use App\Models\Post;

interface ILikeRepository
{
    public function likePost(Post $post);

    public function unLikePost(Post $post);

    public function likeComment(Comment $comment);

    public function unLikeComment(Comment $comment);
}
