<?php

namespace App\Events;

use App\Models\PostCollection;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCollectionViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PostCollection $postCollection;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PostCollection $postCollection)
    {
        $this->postCollection = $postCollection;
    }
}
