<?php

namespace App\Listeners;

use App\Events\CommentLiked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateCommentLikesCount
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
     * @param  CommentLiked  $event
     * @return void
     */
    public function handle(CommentLiked $event)
    {
        $comment = $event->comment;
        $comment->likes_count = $comment->likes();
        if ($comment->save()) {
            Log::info('Comment like count updated successfully');
        } else {
            Log::error('Comment like count update failed');
        }
    }
}
