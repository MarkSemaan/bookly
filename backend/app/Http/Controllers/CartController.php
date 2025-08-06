<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ResponseTrait;

 
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

    public function storeOrUpdate(StoreCartItemRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $validatedData['user_id'] = auth()->id();


            $service = app()->make(CartService::class);
            $item = $service->createOrUpdateCartItem($validatedData);

            return $this->responseJSON($item, "Cart item added/updated", 200);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
  
    public function getCartTotal()
    {
        try {
            $userId =  Auth::id();

            $service = app()->make(CartService::class);
            $total = $service->getCartTotal($userId);

            return $this->responseJSON($total, "Cart total calculated");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
    public function getCartTotal()
    {
        try {
            $userId =  Auth::id();


            $service = app()->make(CartService::class);
            $total = $service->getCartTotal($userId);

            return $this->responseJSON($total, "Cart total calculated");
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

   
    public function decreaseCartItem(Request $request)
    {
        try {
            $userId =  Auth::id();
            $bookId = $request->input('book_id');

            $item = CartService::decreaseCartItemQuantity($userId, $bookId);

            if (!$item) {
                return $this->responseJSON(['message' => 'Item not found'], 404);
            }

            return $this->responseJSON([
                'message' => 'Quantity decreased',
                'item' => $item
            ]);
        } catch (\Exception $e) {
            return $this->responseJSON([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
