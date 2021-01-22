<?php


namespace App\Repositories;


use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\ICommentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use phpDocumentor\Reflection\Utils;

class CommentRepository implements ICommentRepository
{

    public function createComment(array $data, Post $post)
    {
        try {
            $user = auth()->user();
            $comment = $post->comments()->create([
                'author_id' => $user->id,
                'text' => $data['text']
            ]);
            return ResponseBuilder::success($comment)->setStatusCode(201);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode(404);
        }

    }

    public function createReply(array $data, Comment $comment)
    {
        try {
            $user = auth()->user();
            $reply = $comment->replies()->create([
                'post_id' => $comment->post_id,
                'author_id' => $user->id,
                'text' => $data['text']
            ]);
            return ResponseBuilder::success($reply)->setStatusCode(201);
        } catch (ModelNotFoundException) {
            ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode(404);
        }

    }

    public function updateComment(array $data, Comment $comment)
    {
        try {
            $newComment = $comment->update([
                'text' => $data['text']
            ]);
            return ResponseBuilder::success($newComment)->setStatusCode('202');
        } catch (ModelNotFoundException $exception) {
            ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode('404');
        }
    }

    public function deleteComment(Comment $comment)
    {
        try {
            $comment->delete();
            return ResponseBuilder::success()->setStatusCode('202');
        } catch (\Exception $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode($exception->getCode());
        }
    }

    public function getReplies(Comment $comment)
    {
        try {
            $user = auth()->user();
            $comments = $comment->replies()->with(['author' => function ($query) {
                $query->withCount('followers', 'following');
            }])->withCount( 'likes')
                ->whereHas('author', function ($query) use ($user) {
                    $query->withoutBlockingsOf($user);
                })
                ->orWhere('author_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(7);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode(404);
        }
        // TODO: Implement getReplies() method.
    }

    public function getCommentById(Comment $comment)
    {
        try {
            return ResponseBuilder::asSuccess(BaseApiCodes::OK())->withData($comment);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode(404);
        }
    }

    public function getCommentLikes(Comment $comment)
    {
        try {
            $likes = $comment->likers(User::class)->get();
            return ResponseBuilder::success($likes)->setStatusCode(200);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode(404);
        }
    }
}
