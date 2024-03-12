<?php

namespace App\Console\Commands;

use App\Models\ResearchUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CreateResearchAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "connection:create-research-account {name?} {email?}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a new Research Account and Email them to finish the sign up.";

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
        $name = $this->argument("name") ?? $this->ask("Account Name: ");
        $email = $this->argument("email") ?? $this->ask("Account Email: ");
        $temp_password = bin2hex(random_bytes(8));

        $account = new ResearchUser([
            "first_name" => $name,
            "email" => $email,
            "password" => $temp_password,
        ]);

        if ($account->save()) {
            $this->info("Account Created Successfully");
            $this->info("Temporary Password: " . $temp_password);
            Mail::to($account)->send(
                new \App\Mail\ResearchAccountCreated($account, $temp_password),
            );
            return 0;
        } else {
            $this->error("Account Creation Failed. Please try again.");
            return 1;
        }
    }
}
