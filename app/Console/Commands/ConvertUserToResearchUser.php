<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertUserToResearchUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "connection:convert-user-to-research-user {user_id? : The ID of the user to convert} {--force : Force the conversion} {--dry-run : Do not save the changes}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Convert a user to a research user by adjusting the type column.";

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
        $user_id =
            $this->argument("user_id") ??
            $this->choice(
                "Which user would you like to convert?",
                \App\Models\User::all()
                    ->pluck("name", "id")
                    ->toArray(),
            )["id"];
        $user = \App\Models\User::find($user_id);
        if ($user->type === "App\ResearchUser") {
            $this->info("The user is already a research user.");
            return 0;
        }
        if (
            !$this->option("force") &&
            !$this->confirm(
                "Are you sure you want to convert {$user->full_name()} to a research user?",
            )
        ) {
            $this->info("The user was not converted.");
            return 0;
        }
        if (!$this->option("dry-run")) {
            $user->type = "App\ResearchUser";
            if ($user->save()) {
                $this->info("The user has been converted to a research user.");
                return 0;
            } else {
                $this->error(
                    "The user could not be converted to a research user.",
                );
                return 1;
            }
        }
        return 0;
    }
}
