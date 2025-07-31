<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function placeOrder(array $cartItems, int $userId)
    {
        return DB::transaction(function () use ($cartItems, $userId) {
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->book->price * $item->quantity;
            }
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'total' => $total
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price
                ]);
                $book = $item->book;
                $book->stock -= $item->quantity;
                $book->sold += $item->quantity;
                $book->is_available = $book->stock > 0;
                $book->save();
                $item->delete();
            }
            return $order;
        });
    }

    public function getUserOrders(int $userId)
    {
        return Order::with('items')->where('user_id', $userId)->get();
    }
}
