<?php

namespace App\Actions;
use App\Models\Book;

class GetUserViews
{
    public function execute(int $user_id): array
    {
        $books = Book::whereIn('id', function ($query) use ($user_id) {
            $query->select('book_id')
                ->from('user_book_views')
                ->where('user_id', $user_id)
                ->where('viewed_at', '>', now()->subDays(15));
        })->get()->toArray();

        return $books;
    }
}
