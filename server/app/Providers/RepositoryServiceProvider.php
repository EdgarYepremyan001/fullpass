<?php

namespace App\Providers;

use App\Interfaces\PostsRepositoryInterface;
use App\Interfaces\UsersRepositoryInterface;
use App\Repositories\PostsRepository;
use App\Repositories\UsersRepository;
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
        $this->app->bind(PostsRepositoryInterface::class, PostsRepository::class);
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
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
