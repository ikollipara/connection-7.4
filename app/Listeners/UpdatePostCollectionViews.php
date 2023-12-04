<?php

namespace App\Listeners;

use App\Events\PostCollectionViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdatePostCollectionViews
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
     * @param  PostCollectionViewed  $event
     * @return void
     */
    public function handle(PostCollectionViewed $event)
    {
        $collection = $event->postCollection;
        $collection->views = $collection->views();
        if ($collection->save()) {
            Log::info("Post collection view count updated successfully");
        } else {
            Log::error("Post collection view count update failed");
        }
    }
}
