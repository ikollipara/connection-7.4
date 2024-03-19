<?php

namespace App\Console;

use App\Models\User;
use App\Notifications\QualtricsSurvey;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule
            ->call(function () {
                User::query()
                    ->where("consented", true)
                    ->each(function (User $user) {
                        if (!$user->sent_week_one_survey) {
                            $user->notify(
                                new QualtricsSurvey(
                                    env(
                                        "APP_QUALTRICS_CT_CAST_LINK" .
                                            "?userId=" .
                                            $user->id,
                                    ),
                                ),
                            );
                            $user->sent_week_one_survey = true;
                            $user->save();
                        }
                        if (
                            !$user->yearly_survey_sent_at or
                            $user->yearly_survey_sent_at->diffInDays(now()) >=
                                365
                        ) {
                            $user->notify(
                                new QualtricsSurvey(
                                    env(
                                        "APP_QUALTRICS_CT_CAST_LINK" .
                                            "?userId=" .
                                            $user->id,
                                    ),
                                ),
                            );
                            $user->notify(
                                new QualtricsSurvey(
                                    env(
                                        "APP_QUALTRICS_SCALES_LINK" .
                                            "?userId=" .
                                            $user->id,
                                    ),
                                ),
                            );
                            $user->yearly_survey_sent_at = now();
                            $user->save();
                        }
                    });
            })
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . "/Commands");

        require base_path("routes/console.php");
    }
}
