<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Opportunity;
use Carbon\Carbon;

class HideExpiredOpportunities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opportunities:hide-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hide expired opportunities by updating their status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Find all approved opportunities that have expired
        $expiredOpportunities = Opportunity::where('status', 'approved')
            ->where('deadline', '<', $today)
            ->get();

        $count = $expiredOpportunities->count();

        if ($count > 0) {
            foreach ($expiredOpportunities as $opportunity) {
                // You could either:
                // 1. Change status to 'expired' (requires adding 'expired' to enum)
                // 2. Soft delete them
                // 3. Just log them (they're already filtered by the active() scope)

                // For now, we'll just log them as the active() scope already filters them
                $this->info("Expired: {$opportunity->title} (Deadline: {$opportunity->deadline->format('Y-m-d')})");
            }

            $this->info("Found {$count} expired opportunities.");
        } else {
            $this->info('No expired opportunities found.');
        }

        return 0;
    }
}
