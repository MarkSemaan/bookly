<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Exception;

class OrderController extends Controller
{
    use ResponseTrait;

    public function getOrders(Request $request, ?int $id = null)
    {
        try {
            $search = $request->query('search');
            $order = null;
            if ($id) {
                $order = OrderService::getOrders($id, $search);
                if (!$order) {
                    return $this->fail("Order not found", "fail", 404);
                }
                if ($order->user_id !== auth()->id()) {
                    return $this->fail("Order not found", "fail", 404);
                }
                return $this->responseJSON($order, "Order found");
            }
            $orders = OrderService::getOrders(null, $search);
            return $this->responseJSON($orders, "Orders loaded");
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

   public function getUserOrders()
   {
     try {
         $userId = auth()->id();  
         $orders = OrderService::getUserOrders($userId);
         return $this->responseJSON($orders, "User's orders loaded");
        } catch (Exception $e) {
         return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getAllOrders()
    {
    try {
        $orders = OrderService::getAllOrders(); 
        return $this->responseJSON($orders, "All orders loaded successfully");
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
         $userId = auth()->id(); 
         $order = OrderService::createOrderFromCart($userId);
         return $this->responseJSON($order, "Order created from cart");
        } catch (Exception $e) {
          return $this->fail($e->getMessage(), "error", 500);
        }
   }

   public function moveStatus($id)
   {
     try {
         $order = OrderService::moveStatus($id);
         return response()->json([
             'message' => 'Order status updated successfully',
             'payload' => $order
           ]);
        } catch (\Exception $e) {
         return response()->json([
             'message' => 'Failed to update status',
             'error' => $e->getMessage()
           ], 500);
        }
    }

    public function cancel($id)
    {
      try {
         $order = OrderService::cancelOrder($id);
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
