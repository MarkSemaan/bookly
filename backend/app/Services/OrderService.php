<?php

namespace App\Services;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Book;
use App\Events\OrderCreated;
use App\Events\OrderStatusChanged;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public static function getOrders(?int $id = null, ?string $search = null)
    {
        if ($id) {
            return Order::with(['user', 'items.book'])->find($id);
        }

        $query = Order::with(['user', 'items.book']);

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        return $query->get();
    }

    public static function getUserOrders(int $userId)
    {
        return Order::with('items.book')->where('user_id', $userId)->get();
    }

    public static function createOrderFromCart(int $userId): Order
    {
        return DB::transaction(function () use ($userId) {
            $cartItems = CartItem::with('book')->where('user_id', $userId)->get();
            

            if ($cartItems->isEmpty()) {
                throw new \Exception("No items in cart to create order.");
            }

            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->book->price;
            });

            $order = Order::create([
                'user_id' => $userId,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price,
                ]);
            }
            CartItem::where('user_id', $userId)->delete();
            event(new OrderCreated($order)); 

            return $order->fresh('items.book');
        });
    }

    public static function cancelOrder(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        event(new OrderStatusChanged($order, 'cancelled'));
        return $order->fresh('items.book');
    }

    public static function createOrUpdateOrder(array $data, ?Order $order = null): Order
    {
        return DB::transaction(function () use ($data, $order) {
            $total = collect($data['items'])->sum(fn($item) => $item['price'] * $item['quantity']);
            if ($order) {
                $order->update([
                    'status' => $data['status'] ?? $order->status,
                    'total' => $total,
                ]);
                $order->items()->delete();
            } else {
                $order = Order::create([
                    'user_id' => $data['user_id'],
                    'status' => $data['status'] ?? 'pending',
                    'total' => $total,
                ]);
             
            }

            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'book_id' => $item['book_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            return $order->fresh('items.book');
        });
    }

    public static function deleteOrder(Order $order): void
    {
        $order->items()->delete();
        $order->delete();
    }
}
