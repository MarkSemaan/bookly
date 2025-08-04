<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Exception;

class CartService
{

    public static function getUserCartItems($userId)
    {
        return CartItem::with('book')->where('user_id', $userId)->get();
    }

    public static function getCartItems($id = null, $search = null)
    {
        return CartItem::with('book')->where('user_id', $id)->get();
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
            'quantity' => $quantity,
        ]);
    }


    public function deleteCartItem(CartItem $cartItem): void
    {
        $cartItem->delete();
    }


    public function getCartTotal($userId)
    {
        $cartItems = CartItem::with('book')->where('user_id', $userId)->get();
        $total = 0;

        foreach ($cartItems as $item) {
            if ($item->book) {
                $total += $item->book->price * $item->quantity;
            }
        }

        return $total;
    }


    public static function decreaseCartItemQuantity($userId, $bookId)
    {
        $cartItem = CartItem::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if (!$cartItem) {
            return null;
        }

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return $cartItem;
    }
}
