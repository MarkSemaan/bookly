<?php

namespace App\Http\Controllers;
use App\Services\AnalyticService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function getAnalytics()
    {
        $sales = AnalyticService::getSales();
        $stock = AnalyticService::getStockCount();
        $revenue = AnalyticService::getTodaysRevenue();
        $customers = AnalyticService::getCustomersCount();
        $graph = AnalyticService::getGraph();
        $orders = AnalyticService::getOrdersDetails();
        $low = AnalyticService::getLowStock();
        $top = AnalyticService::getTopStock();
        $notifications = AnalyticService::getNotifications();

        $analytics = [
            'sales' => $sales,
            'stock' => $stock,
            'revenue' => $revenue,
            'customers' => $customers,
            'graph' => $graph,
            'orders' => $orders,
            'low_stock' => $low,
            'top_stock' => $top,
            'notifications' => $notifications,
        ];
        return ResponseTrait::responseJSON($analytics);
    }
}