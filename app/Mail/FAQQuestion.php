<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FAQQuestion extends Mailable
{
    use Queueable, SerializesModels;

    public string $question;
    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $question, User $user)
    {
        $this->question = $question;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("[ConneCTION] New FAQ Question")
            ->from($this->user->email, $this->user->full_name())
            // @phpstan-ignore-next-line
            ->to(env("MAIL_FROM_ADDRESS"))
            ->view("mail.faq-question");
    }
}
