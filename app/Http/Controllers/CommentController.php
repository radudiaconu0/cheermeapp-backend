<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\ICommentRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function __construct(private ICommentRepository $commentRepository)
    {
    }

    public function store(CreateCommentRequest $request, $id): Response
    {

        return $this->commentRepository->createComment($request->only('text'), $id);

    }

    public function storeReply(CreateCommentRequest $request, $id): Response
    {
        return $this->commentRepository->createReply($request->only('text'), $id);
    }


    public function show(Comment $comment)
    {
        return $this->commentRepository->getCommentById($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(UpdateCommentRequest $request, Comment $comment): Response
    {
        $this->authorize('update', $comment);
        return $this->commentRepository->updateComment($request->get('text'), $comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Comment $comment): Response
    {
        $this->authorize('delete', $comment);
        return $this->commentRepository->deleteComment($comment);
    }

    public function getReplies($comment): Response
    {
        return $this->commentRepository->getReplies($comment);
    }

    public function getCommentLikes(Comment $comment): Response
    {
        return $this->commentRepository->getCommentLikes($comment);
    }
}
