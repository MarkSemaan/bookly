<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use \App\Traits\ResponseTrait;

    public function getCartItems(Request $request)
    {
        try {
            $id = $request->query('id');
            $search = $request->query('search');

            $service = app()->make(CartService::class);

            if ($id) {
                $items = $service->getCartItems($id);
            } else {
                $items = $service->getCartItems($search);
            }

            return $this->responseJSON($items, $id ? "Cart item found" : "Cart items loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $id = $request->input('id');
            $validated = app(StoreCartItemRequest::class)->validate($request);

            $service = app()->make(CartService::class);

            $item = $id ? CartItem::findOrFail($id) : null;

            $item = $service->createOrUpdateCartItem($validated, $item);

            return $this->responseJSON($item, $id ? "Cart item updated" : "Cart item added", $id ? 200 : 201);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getUserCartItems(int $userId)
    {
        try {
            $service = app()->make(CartService::class);
            $cartItems = $service->getUserCartItems($userId);

            return $this->responseJSON($cartItems, "User cart items loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function destroy(CartItem $cartItem)
    {
        try {
            $service = app()->make(CartService::class);
            $service->deleteCartItem($cartItem);

            return $this->responseJSON(null, "Cart item deleted");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
