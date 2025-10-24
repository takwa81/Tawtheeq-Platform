<?php

namespace App\Console\Commands;

use App\Enums\TrendStatusEnum;
use App\Models\Trend;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateTrendStatus extends Command
{
    protected $signature = 'trends:update-status';
    protected $description = 'Update trend statuses based on start and end dates';

    public function handle()
    {
        $now = Carbon::now();

        // PREPARING -> STARTED
        $startedCount = Trend::where('status', TrendStatusEnum::PREPARING->value)
            ->where('start_date', '<=', $now)
            ->update(['status' => TrendStatusEnum::STARTED->value]);

        Log::info('Trends started: ' . $startedCount);

        // STARTED -> FINISHED
        $finishedCount = Trend::where('status', TrendStatusEnum::STARTED->value)
            ->where('end_date', '<=', $now)
            ->update(['status' => TrendStatusEnum::FINISHED->value]);

        Log::info('Trends finished: ' . $finishedCount);

        $this->info("Trend statuses updated. Started: $startedCount, Finished: $finishedCount");
    }
}
