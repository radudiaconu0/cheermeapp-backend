<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any comments.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function view(User $user, Comment $comment)
    {
        return !User::find($comment->author_id)->blocks($user);
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function create(User $user, Post $post)
    {
        return !User::find($post->author_id)->blocks($user);
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id == $comment->author_id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id == $comment->author_id;
    }

    /**
     * Determine whether the user can restore the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function restore(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function forceDelete(User $user, Comment $comment)
    {
        //
    }

    public function like(User $user, Comment $comment)
    {
        $author = $comment->author;
        return !$author->blocks($user) && ($author->account_type == 'public' || $user->follows($author));
    }

    public function unLike(User $user, Comment $comment)
    {
        $author = $comment->author;
        return !$author->blocks($user) && ($author->account_type == 'public' || $user->follows($author));
    }
}
