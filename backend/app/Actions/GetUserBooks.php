<?php

namespace App\Actions;

use App\Models\Book;

class GetUserBooks
{
    public function execute(int $user_id): array
    {
        $books = Book::whereHas(
            'orderItems.order.payment',
            function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }
        )->get()->toArray();
        return $books;
    }
}