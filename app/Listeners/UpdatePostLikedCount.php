<?php

namespace App\Listeners;

use App\Events\PostLiked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdatePostLikedCount
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
     * @param  PostLiked  $event
     * @return void
     */
    public function handle(PostLiked $event)
    {
        $post = $event->post;
        $post->likes_count = $post->likes();
        if ($post->save()) {
            Log::info('Post like count updated successfully');
        } else {
            Log::error('Post like count update failed');
        }
    }
}
