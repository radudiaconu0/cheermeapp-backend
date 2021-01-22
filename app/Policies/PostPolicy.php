<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\This;

class PostPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function view(User $user, Post $post)
    {
        $author = User::findOrFail($post->author_id);
        return !$author->blocks($user) && $author->account_type == 'public';
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->author_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->author_id;
    }
}
