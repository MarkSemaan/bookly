<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    use ResponseTrait;

    public function getOrders(Request $request, ?int $id = null)
    {
        try {
            $search = $request->query('search');
            $orders = OrderService::getOrders($id, $search);

            if ($id && !$orders) {
                return $this->fail("Order not found", "fail", 404);
            }

            return $this->responseJSON($orders, $id ? "Order found" : "Orders loaded");
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getUserOrders(int $userId)
    {
        try {
            $orders = OrderService::getUserOrders($userId);
            return $this->responseJSON($orders, "User's orders loaded");
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function storeOrUpdate(StoreOrderRequest $request)
    {
        try {
            $validated = $request->validated();
            $id = $validated['id'] ?? null;
            $order = $id ? Order::find($id) : null;

            if ($id && !$order) {
                return $this->fail("Order not found", "fail", 404);
            }

            $result = OrderService::createOrUpdateOrder($validated, $order);

            return $this->responseJSON($result, $id ? "Order updated" : "Order created", $id ? 200 : 201);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

public function createFromCart(Request $request)
        {
            try {
                $userId =  Auth::id();
                $order = OrderService::createOrderFromCart($userId);
                return $this->responseJSON($order, "Order created from cart");
            } catch (Exception $e) {
                return $this->fail($e->getMessage(),"error",500);
            }
        }

    public function cancel(Order $order)
    {
        try {
            $order = OrderService::cancelOrder($order);
            return $this->responseJSON($order, "Order cancelled");
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            OrderService::deleteOrder($order);
            return $this->responseJSON(null, "Order deleted");
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
