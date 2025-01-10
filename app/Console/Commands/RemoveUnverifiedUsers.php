<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove users who have not verified their account within 30 days';

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
        // Get the current date and subtract 30 days
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // Remove users who are unverified and registered before 30 days
        $users = User::whereNull('email_verified_at')
                     ->where('created_at', '<', $thirtyDaysAgo)
                     ->get();

        // Loop through and delete users
        foreach ($users as $user) {
            $user->delete();
            $this->info("Deleted user: {$user->email}");
        }

        $this->info('Unverified users who were registered over 30 days ago have been deleted.');
    }
}
