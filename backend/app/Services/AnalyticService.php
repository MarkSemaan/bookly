<?php

namespace App\Services;

use App\Models\Analytic;
use DateTime;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;

class AnalyticService
{
    public static function saveOrUpdateAnalytic($revenue, $createdAt)
    {
        $hour = Carbon::parse($createdAt)->format('Y-m-d H:00:00');

        $analytic = Analytic::where('hour', $hour)->first();

        if ($analytic) {
            $analytic->increment('orders_count');
            $analytic->increment('revenue', $revenue);
        } else {
            Analytic::create([
                'hour' => $hour,
                'orders_count' => 1,
                'revenue' => $revenue,
            ]);
        }
    }
    public static function getSales()
    {
        return Order::whereNotIn('status', ['pending', 'cancelled'])->sum('total');
    }

    public static function getStockCount()
    {
        return Book::where('is_available', true)
            ->where('stock', '>', 0)
            ->sum('stock');
    }


    public static function getTodaysRevenue()
    {
        return Order::whereDate('created_at', now()->toDateString())
            ->whereNotIn('status', ['pending', 'cancelled'])
            ->sum('total');
    }

    public static function getCustomersCount()
    {
        return User::where('role', 'customer')->count();
    }

    public static function getGraph()
    {
        return Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->whereNotIn('status', ['pending', 'cancelled'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public static function getOrdersDetails()
    {
        return [
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'packed' => Order::where('status', 'packed')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'orders_per_hour' => Analytic::where('hour', now()->hour)->value('orders_count') ?? 0,
        ];
    }

    public static function getLowStock()
    {
        return Book::where('stock', '<', 15)->orderBy('stock', 'asc')->limit(5)->get();
    }

    public static function getTopStock()
    {
        return Book::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(3)
            ->get();
    }

    public static function getNotifications()
    {
        return [
            ['type' => 'order', 'message' => 'New order #12345'],
            ['type' => 'payment_failed', 'message' => 'Payment failed for order #12344'],
            ['type' => 'inventory', 'message' => 'Inventory running low'],
            ['type' => 'customer', 'message' => 'New customer registered'],
        ];
    }




}
