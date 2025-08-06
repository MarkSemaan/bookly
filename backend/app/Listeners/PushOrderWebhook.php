<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Queue\ShouldQueue;

class PushOrderWebhook implements ShouldQueue
{
    public function handle(OrderCreated $event): void
    {
        if (App::environment('testing')) {
            return;
        }

        Http::post('http://localhost:8000/api/mock-webhook', [
            'order_id' => $event->order->id,
            'user_id' => $event->order->user_id,
            'status' => $event->order->status,
            'total' => $event->order->total,
        ]);
    }
}