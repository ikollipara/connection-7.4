<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserFollowers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserFollowed  $event
     * @return void
     */
    public function handle($event)
    {
        $event->followed->followers_count = $event->followed
            ->followers()
            ->count();
        $event->follower->following_count = $event->follower
            ->following()
            ->count();
        $event->followed->save();
        $event->follower->save();
    }
}
