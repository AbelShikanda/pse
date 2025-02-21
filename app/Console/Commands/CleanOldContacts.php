<?php

namespace App\Console\Commands;

use App\Models\Contacts;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanOldContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete contacts older than three months';

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
        try {
            $deletedContacts = Contacts::where('created_at', '<', Carbon::now()->subMonths(3))->delete();
            $this->info("Deleted $deletedContacts old contacts.");
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }

        return 0;
    }
}
