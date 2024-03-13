<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\QualtricsSurvey;
use Illuminate\Console\Command;

class SendQualtricsSurvey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "connection:send-qualtrics-survey";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send a Qualtrics survey to all users who have consented to participate in research.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $survey_url = $this->choice("Which survey would you like to send?", [
            env("APP_QUALTRICS_SCALES_LINK"),
            env("APP_QUALTRICS_CT_CAST_LINK"),
        ]);
        User::query()
            ->where("consented", true)
            ->each(
                fn(User $user) => $user->notify(
                    new QualtricsSurvey($survey_url . "?user_id=" . $user->id),
                ),
            );
        $this->info(
            "The survey has been sent to all users who have consented to participate in research.",
        );
        return 0;
    }
}
