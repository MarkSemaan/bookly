<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Book;
use Exception;

class CartService
{
    public function getCartContents(int $userId)
    {
        return CartItem::with('book')->where('user_id', $userId)->get();
    }

    public function addToCart(int $userId, int $bookId, int $quantity)
    {
        $book = Book::findOrFail($bookId);

        if ($book->stock < $quantity) {
            throw new Exception('Not enough stock available');
        }

        $existingItem = CartItem::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
            return $existingItem;
        }

        return CartItem::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'quantity' => $quantity
        ]);
    }

    public function removeFromCart(int $cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        return $cartItem->delete();
    }

    public function updateCartItemQuantity(int $cartItemId, int $quantity)
    {
        $cartItem = CartItem::with('book')->findOrFail($cartItemId);

        if ($cartItem->book->stock < $quantity) {
            throw new Exception('Not enough stock available');
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return $cartItem;
    }

    public function clearCart(int $userId)
    {
        return CartItem::where('user_id', $userId)->delete();
    }

    public function getCartTotal(int $userId)
    {
        $cartItems = CartItem::with('book')->where('user_id', $userId)->get();
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item->book->price * $item->quantity;
        }

        return $total;
    }
}
