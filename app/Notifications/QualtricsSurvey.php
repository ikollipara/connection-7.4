<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QualtricsSurvey extends Notification
{
    use Queueable;

    public string $url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
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
            ->subject("[conneCTION] New Survey")
            ->greeting("Hello, " . $notifiable->first_name)
            ->line("We would like to invite you to take a survey.")
            ->line(
                "This survey is for the research that you have consented to participate in.",
            )
            ->line("This survey should take 1-1.5 hours to complete.")
            ->line("Please click the button below to take the survey.")
            ->action("Take the Survey", $this->url)
            ->salutation("Thank you for your participation!");
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
