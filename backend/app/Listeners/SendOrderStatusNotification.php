<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class SendOrderStatusNotification implements ShouldQueue
{
    use Queueable;

    public function handle(OrderStatusChanged $event): void
    {
        $order  = $event->order;
        $status = $event->status;
        $user   = $order->user;

        $messages = [
            'packed'   => 'Your order has been packed and is ready to ship!',
            'shipped'  => 'Good news—your order has shipped!',
            'canceled' => 'Your order has been canceled. If you have questions, reply to this email.',
        ];

        $text = $messages[$status] ?? "Your order status has been updated to '{$status}'.";

        $user->notify(new OrderStatusUpdated($order, $text));
    }
}

