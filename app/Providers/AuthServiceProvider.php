<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use App\Policies\CommentsPolicy;
use App\Policies\PostCollectionsPolicy;
use App\Policies\PostsPolicy;
use App\Policies\UsersPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostsPolicy::class,
        Comment::class => CommentsPolicy::class,
        PostCollection::class => PostCollectionsPolicy::class,
        User::class => UsersPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
