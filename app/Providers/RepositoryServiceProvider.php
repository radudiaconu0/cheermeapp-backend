<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\ICommentRepository;
use App\Repositories\Interfaces\ILikeRepository;
use App\Repositories\Interfaces\IPostRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\LikeRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IPostRepository::class, PostRepository::class);
        $this->app->bind(ICommentRepository::class, CommentRepository::class);
        $this->app->bind(ILikeRepository::class, LikeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
