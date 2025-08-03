<?php
namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBookStock implements ShouldQueue
{
public function handle(OrderCreated $event): void
{
    $order = $event->order->load('items.book'); 

    foreach ($order->items as $item) {
        
        $item->book->decrement('stock', $item->quantity);
       
    }
}

}