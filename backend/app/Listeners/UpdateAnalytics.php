<?php

namespace App\Listeners;

use App\AnalyticService;
use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAnalytics implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        AnalyticService::saveOrUpdateAnalytic($event->order->total, $event->order->created_at);
    }
}
