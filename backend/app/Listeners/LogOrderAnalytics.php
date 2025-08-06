<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class LogOrderAnalytics implements ShouldQueue
{
    public function handle(OrderCreated $event): void
    {
        $hour = now()->startOfHour();

        DB::table('analytics')->updateOrInsert(
            ['hour' => $hour],
            ['count' => DB::raw('count + 1'), 'updated_at' => now()]
        );
    }
}
