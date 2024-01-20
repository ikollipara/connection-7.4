<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CommentAdded extends Notification
{
    // use Queueable;

    public Comment $comment;
    public User $commenter;
    public bool $is_post = false;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        Comment $comment,
        User $commenter,
        bool $is_post = false
    ) {
        $this->comment = $comment;
        $this->commenter = $commenter;
        $this->is_post = $is_post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<string>
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
        $item = $this->is_post ? "post" : "collection";
        $see_now_route = $this->is_post
            ? "posts.comments.index"
            : "collections.comments.index";
        return (new MailMessage())
            ->greeting("Someone commented on your {$item}!")
            ->lines(["Comment:", $this->comment->body])
            ->action(
                "See the new comment now!",
                route(
                    $see_now_route,
                    $this->is_post
                        ? ["post" => $this->comment->commentable]
                        : ["collection" => $this->comment->commentable],
                ),
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<mixed>
     */
    public function toArray($notifiable)
    {
        return [
                //
            ];
    }
}
