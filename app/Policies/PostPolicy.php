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
    public function generalAuthorization(User $user, Post $post) {
        $author = $post->author;
        return !$author->blocks($user) && !$user->blocks($author) && ($author->account_type == 'public' || $user->follows($author));
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
        $author = $post->author;
        return !$author->blocks($user) && !$user->blocks($author) && ($author->account_type == 'public' || $user->follows($author));
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param User $user
     * @param User $timelineUser
     * @return bool
     */
    public function getTimeline(User $user, User $timelineUser)
    {
        return !$timelineUser->blocks($user) && ($timelineUser->account_type == 'public' || $user->follows($timelineUser));
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

    public function getComments(User $user, Post $post)
    {
        return $this->generalAuthorization($user, $post);
    }

    public function getLikes(User $user, Post $post)
    {
        return $this->generalAuthorization($user, $post);
    }

    public function like(User $user, Post $post)
    {
        return $this->generalAuthorization($user, $post);
    }

    public function unLike(User $user, Post $post)
    {
        return $this->generalAuthorization($user, $post);
    }

    public function comment(User $user, Post $post)
    {
        $author = $post->author;
        return !$author->blocks($user) && $user->blocks($author) && ($author->account_type == 'public' || $user->follows($author)) && !$post->blocked_comments;
    }

    public function blockComments(User $user, Post $post): bool
    {
        return $post->author_id == $user->id && !$post->blocked_comments;
    }

    public function unBlockComments(User $user, Post $post): bool
    {
        return $post->author_id == $user->id && $post->blocked_comments;
    }
}
