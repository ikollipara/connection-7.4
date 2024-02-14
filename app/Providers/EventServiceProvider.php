<?php

namespace App\Providers;

use App\Events\PostLiked;
use App\Events\PostCollectionLiked;
use App\Events\CommentLiked;
use App\Events\PostViewed;
use App\Events\PostCollectionViewed;
use App\Events\UserFollowed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\UpdatePostLikedCount;
use App\Listeners\UpdatePostCollectionLikesCount;
use App\Listeners\UpdateCommentLikesCount;
use App\Listeners\UpdatePostViews;
use App\Listeners\UpdatePostCollectionViews;
use App\Listeners\UpdateUserFollowers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
        PostLiked::class => [UpdatePostLikedCount::class],
        PostCollectionLiked::class => [UpdatePostCollectionLikesCount::class],
        CommentLiked::class => [UpdateCommentLikesCount::class],
        PostViewed::class => [UpdatePostViews::class],
        PostCollectionViewed::class => [UpdatePostCollectionViews::class],
        UserFollowed::class => [UpdateUserFollowers::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
