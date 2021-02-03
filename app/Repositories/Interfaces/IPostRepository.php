<?php


namespace App\Repositories\Interfaces;


use App\Models\Post;
use App\Models\User;

interface IPostRepository
{
    public function getFollowersPosts();

    public function createPost(array $data);

    public function getPost(Post $post);

    public function updatePost(array $data, Post $post);

    public function deletePost(Post $post);

    public function getPostsByUserId(User $user);

    public function getComments(Post $post);

    public function getPostLikes(Post $post);

    public function blockComments(Post $post);

    public function unBlockComments(Post $post);
}
