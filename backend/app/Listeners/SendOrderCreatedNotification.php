<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class SendOrderCreatedNotification implements ShouldQueue
{
    use Queueable;

    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $user  = $order->user;

        $user->notify(new OrderStatusUpdated(
            $order,
            'Your order has been created! Here’s your invoice.'
        ));
    }
}