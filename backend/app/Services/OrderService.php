<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class OrderService
{
    public function placeOrder(array $cartItems, int $userId) {}

    public function getUserOrders(int $userId)
    {
        return Order::with('items')->where('user_id', $userId)->get();
    }
}
