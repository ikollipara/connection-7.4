<?php

namespace App\Notifications;

use App\Models\Study;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyResearchParticipants extends Notification
{
    use Queueable;

    public Study $study;
    public string $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Study $study, string $message)
    {
        $this->study = $study;
        $this->message = $message;
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
            ->subject("{$this->study->title} - New Message")
            ->from($this->study->user->email)
            ->markdown("mail.notify-research-participants", [
                "study" => $this->study,
                "message" => $this->message,
            ]);
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
