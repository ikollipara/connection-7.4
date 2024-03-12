<?php

namespace App\Mail;

use App\Models\ResearchUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResearchAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public ResearchUser $user;
    public string $temp_password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ResearchUser $user, string $temp_password)
    {
        $this->user = $user;
        $this->temp_password = $temp_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your New conneCTION Research Account")
            ->from(env("MAIL_FROM_ADDRESS"), "conneCTION")
            ->view("mail.research-account-created");
    }
}
