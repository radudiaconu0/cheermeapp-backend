<?php


namespace App\Repositories\Interfaces;


use App\Models\Comment;
use App\Models\Post;

interface ICommentRepository
{
    public function createComment(array $data, Post $post);

    public function createReply(array $data, Comment $comment);

    public function updateComment(array $data, Comment $comment);

    public function deleteComment(Comment $comment);

    public function getReplies(Comment $comment);

    public function getCommentById(Comment $comment);

    public function getCommentLikes(Comment $comment);
}
