<?php

namespace App\Listeners;

use App\Events\PostCollectionLiked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdatePostCollectionLikesCount
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
     * @param  PostCollectionLiked  $event
     * @return void
     */
    public function handle(PostCollectionLiked $event)
    {
        $postCollection = $event->postCollection;
        $postCollection->likes_count = $postCollection->likes();
        if ($postCollection->save()) {
            Log::info('Post collection like count updated successfully');
        } else {
            Log::error('Post collection like count update failed');
        }
    }
}
