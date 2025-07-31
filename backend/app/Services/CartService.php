<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Book;

class CartService

{
    public function getCartItems($id = null, $search = null)
    {
        $query = CartItem::with(['user', 'book']);

        if ($id) {
            return $query->findOrFail($id);
        }

        if ($search) {
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        return $query->get();
    }

    public function createOrUpdateCartItem(array $data): CartItem
    {
        return tap($cartItem ?? new CartItem())->fill($data)->save() ? $cartItem ?? new CartItem($data) : throw new \Exception("Failed to save cart item");
    }
    public function getUserCartItems($userId)
    {
        return CartItem::with('book')->where('user_id', $userId)->get();
    }

    public function deleteCartItem(CartItem $cartItem): void
    {
        $cartItem->delete();
    }
}
