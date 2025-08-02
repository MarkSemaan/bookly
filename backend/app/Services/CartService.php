<?php

namespace App\Services;

use App\Models\CartItem;

use Illuminate\Support\Facades\DB;
use App\Models\Book;
use Exception;

class CartService


{
    public static function getCartItems($userId, $search = null)
    {
        $query = CartItem::with('book')->where('user_id', $userId);

        if ($search) {
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    public function deleteCartItem(CartItem $cartItem): void
    {
        $cartItem->delete();
    }

    public function addToCart(int $userId, int $bookId, int $quantity)
    {
        $book = Book::findOrFail($bookId);

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