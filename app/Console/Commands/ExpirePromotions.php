<?php

namespace App\Console\Commands;

use App\Models\Products;
use App\Models\PromoCodes;
use Illuminate\Console\Command;

class ExpirePromotions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:promotions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable promotions for expired or fully used promo codes.';

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
        // Find promo codes that have expired and were never used
        $expiredUnusedPromoIds = PromoCodes::where('expires_at', '<', now())
            ->where('times_used', 0)
            ->pluck('id')
            ->toArray();

        // Delete these promo codes
        PromoCodes::whereIn('id', $expiredUnusedPromoIds)->delete();

        $this->info(count($expiredUnusedPromoIds) . ' unused expired promotions removed.');
    }
}
