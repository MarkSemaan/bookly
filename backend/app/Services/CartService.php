<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class CartService
{
    public static function getCartItems($id = null, $search = null)
    {
        $query = CartItem::with(['user', 'book']);

        if ($id) {
            return $query->find($id);
        }

        if ($search) {
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        return $query->get();
    }

    public static function createOrUpdateCartItem(array $data): CartItem
    {
        $cartItem = CartItem::firstOrNew([
            'user_id' => $data['user_id'],
            'book_id' => $data['book_id'],
        ]);

        $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $data['quantity'];
        $cartItem->save();

        return $cartItem;
    }

    public static function getUserCartItems($userId)
    {
        return CartItem::with('book')->where('user_id', $userId)->get();
    }

    public static function deleteCartItem(CartItem $cartItem): void
    {
        $cartItem->delete();
    }
}
