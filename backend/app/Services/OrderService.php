<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Exception;
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
            }
            return $order;
        });
    }

    public function getUserOrders(int $userId)
    {
        return Order::with('items')->where('user_id', $userId)->get();
    }
    public function getOrderDetails(int $orderId)
    {
        return Order::with(['orderItems.book', 'payment', 'user'])
            ->findOrFail($orderId);
    }
    public function updateOrderStatus(int $orderId, string $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();

        return $order;
    }

    public function cancelOrder(int $orderId)
    {
        return DB::transaction(function () use ($orderId) {
            $order = Order::with('orderItems.book')->findOrFail($orderId);

            if ($order->status !== 'pending' && $order->status !== 'processing') {
                throw new Exception('Cannot cancel an order that has been shipped or delivered');
            }
            foreach ($order->orderItems as $item) {
                $book = $item->book;
                $book->stock += $item->quantity;
                $book->sold -= $item->quantity;
                $book->is_available = $book->stock > 0;
                $book->save();
            }

            $order->status = 'cancelled';
            $order->save();

            return $order;
        });
    }


    public function getOrderStatistics(?array $dateRange = null)
    {
        $query = Order::query();

        if ($dateRange) {
            $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        }

        return [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total'),
            'average_order_value' => $query->avg('total'),
            'status_counts' => $query->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
        ];
    }
}
