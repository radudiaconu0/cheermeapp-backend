<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;

use App\Models\User;
use App\Repositories\Interfaces\IPostRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\ApiCodesHelpers;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Response;

class PostController extends Controller
{

    public function __construct(private IPostRepository $postRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function getFeed()
    {
        return $this->postRepository->getFollowersPosts();
    }

    public function getTimeline(User $user)
    {
        $this->authorize('getTimeline', $user);
        return $this->postRepository->getPostsByUserId($user->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePostRequest $request
     * @return Response
     */
    public function store(CreatePostRequest $request): Response
    {
        return $this->postRepository->createPost($request->only('text'));
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Post $post): \Symfony\Component\HttpFoundation\Response
    {
        $this->authorize('view', $post);
        return $this->postRepository->getPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AuthorizationException
     */
    public function update(UpdatePostRequest $request, Post $post): \Symfony\Component\HttpFoundation\Response
    {
        $this->authorize('update', $post);
        return $this->postRepository->updatePost($request->only('text'), $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AuthorizationException
     */
    public function destroy(Post $post): \Symfony\Component\HttpFoundation\Response
    {
        $this->authorize('delete', $post);
        return $this->postRepository->deletePost($post);
    }

    public function getComments(Post $post)
    {
        $this->authorize('getComments', $post);
        return $this->postRepository->getComments($post);
    }

    public function getPostLikes(Post $post)
    {
        $this->authorize('getLikes', $post);
        return $this->postRepository->getPostLikes($post);
    }
}
