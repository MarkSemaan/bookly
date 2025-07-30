<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Book;

class CartService
{
    public function getCartContents(int $userId)
    {
        return CartItem::with('book')->where('user_id', $userId)->get();
    }

    public function addToCart(int $userId, int $bookId, int $quantity) {}

    public function removeFromCart(int $cartItemId) {}
}
