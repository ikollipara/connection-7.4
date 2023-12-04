<?php

namespace App\Listeners;

use App\Events\PostViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdatePostViews
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
     * @param  PostViewed  $event
     * @return void
     */
    public function handle(PostViewed $event)
    {
        $post = $event->post;
        $post->views = $post->views();
        if ($post->save()) {
            Log::info("Post view count updated successfully");
        } else {
            Log::error("Post view count update failed");
        }
    }
}
