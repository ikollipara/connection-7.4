<?php

namespace App\Notifications;

use App\Models\PostCollection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollowedCollection extends Notification
{
    use Queueable;

    public PostCollection $post_collection;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PostCollection $post_collection)
    {
        $this->post_collection = $post_collection->load("user");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ["mail"];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(
                "New Collection from {$this->post_collection->user->full_name()}",
            )
            ->line(
                "{$this->post_collection->user->full_name()} has created a new collection!",
            )
            ->action(
                "View Collection",
                route("collections.show", $this->post_collection),
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
            ];
    }
}
