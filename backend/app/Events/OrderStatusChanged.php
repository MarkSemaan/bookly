<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged
{
    use Dispatchable, SerializesModels;

    public Order $order;
    public string $status;

    public function __construct(Order $order, string $status)
    {
        $this->order  = $order;
        $this->status = $status;
    }
}
