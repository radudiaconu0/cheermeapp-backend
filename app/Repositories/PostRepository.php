<?php


namespace App\Repositories;


use App\Http\Resources\CommentResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\IPostRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MarcinOrlowski\ResponseBuilder\BaseApiCodes;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class PostRepository implements IPostRepository
{

    public function getFollowersPosts()
    {
        $user = auth()->user();
        $followersPost = Post::with(['author' => function ($query) {
            $query->withCount('followers', 'following');
        }])->withCount('comments', 'likes')
            ->whereHas('author', function ($query) use ($user) {
                $query->followedBy($user);
            })
            ->orWhere('author_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(7);
        return PostResource::collection($followersPost);
    }

    public function createPost(array $data)
    {
        $user = auth()->user();
        $post = $user->posts()->create($data);
        return ResponseBuilder::success($post)->setStatusCode(201);
    }

    public function getPost(Post $post)
    {
        try {
            return ResponseBuilder::success($post)->setStatusCode(200);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode(404);
        }
    }

    public function updatePost(array $data, Post $post)
    {
        try {
            $post->update($data);
            return ResponseBuilder::success($post);
        } catch (ModelNotFoundException $exception) {
            return ResponseBuilder::error(BaseApiCodes::EX_HTTP_NOT_FOUND())->setStatusCode(404);
        }
    }

    public function deletePost(Post $post)
    {
        $post->delete();
        return ResponseBuilder::success()->setStatusCode(202);
    }

    public function getPostsByUserId(User $user)
    {
        $posts = PostCollection::collection($user->posts());
        return ResponseBuilder::success($posts);
    }

    public function getComments(Post $post)
    {
        $authUser = auth()->user();
        $comments = $post->comments()->with(['author' => function ($query) {
            $query->withCount('followers', 'following');
        }])->withCount('likes', 'replies')
            ->whereHas('author', function ($query) use ($authUser) {
                $query->withoutBlockingsOf($authUser);
            })
            ->orWhere('author_id', $authUser->id)
            ->orderBy('created_at', 'desc')
            ->where('parent_id', '=')
            ->paginate(7);
        return CommentResource::collection($comments);
    }

    public function getPostLikes(Post $post)
    {
        return ResponseBuilder::success($post->likers(User::class)->get())->setStatusCode(200);
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function blockComments(Post $post)
    {
        $post->update(['blocked_comments' => true]);
        return ResponseBuilder::success([
            'blocked_comments' => true
        ])->setStatusCode(201);
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function unBlockComments(Post $post)
    {
        $post->update(['blocked_comments' => true]);
        return ResponseBuilder::success([
            'blocked_comments' => false
        ])->setStatusCode(201);
    }
}
