<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cartContents = $this->cartService->getCartContents($userId);
        return response()->json($cartContents);
    }

    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $bookId = $request->input('book_id');
        $quantity = $request->input('quantity', 1);

        try {
            $cartItem = $this->cartService->addToCart($userId, $bookId, $quantity);
            return response()->json($cartItem, 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $cartItemId)
    {
        $quantity = $request->input('quantity');

        try {
            $cartItem = $this->cartService->updateCartItemQuantity($cartItemId, $quantity);
            return response()->json($cartItem);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function destroy($cartItemId)
    {
        try {
            $this->cartService->removeFromCart($cartItemId);
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function clear(Request $request)
    {
        $userId = $request->user()->id;
        $this->cartService->clearCart($userId);
        return response()->json(null, 204);
    }

    public function total(Request $request)
    {
        $userId = $request->user()->id;
        $total = $this->cartService->getCartTotal($userId);
        return response()->json(['total' => $total]);
    }
}
