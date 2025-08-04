<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use \App\Traits\ResponseTrait;


    public function getCartItems(Request $request, $id = null)
    {
        try {
            $search = $request->query('search');
            $service = app()->make(CartService::class);
            $items = $service->getCartItems($id, $search);

            if ($id && !$items) {
                return $this->fail("Cart item not found", "fail", 404);
            }

            return $this->responseJSON($items, $id ? "Cart item found" : "Cart items loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    //mnzo3a kenet
    public function storeOrUpdate(StoreCartItemRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['user_id'] = Auth::id();

            $service = app()->make(CartService::class);
            $item = $service->createOrUpdateCartItem($validatedData);

            return $this->responseJSON($item, "Cart item added/updated", 200);
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
