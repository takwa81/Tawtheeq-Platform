<?php

namespace App\Console\Commands;

use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeactivateExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:deactivate-expired';
    protected $description = 'Deactivate subscriptions that have expired';

    public function handle()
    {
        $expired = UserSubscription::where('is_active', true)
            ->whereDate('valid_until', '<', Carbon::now())
            ->update(['is_active' => false]);

        $this->info("Deactivated {$expired} expired subscriptions.");
    }
}
