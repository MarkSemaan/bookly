<?php
namespace App\Listeners;

use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderSms implements ShouldQueue
{
    public function handle(OrderStatusChanged $event): void
    {
        $user = $event->order->user;
        Log::info("SMS to {$user->phone}: Your order #{$event->order->id} status is now '{$event->status}'");
    }
}