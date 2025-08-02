<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Book;

class ReviewService
{
    public static function getReviews( ?string $search = null ,?int $id = null)
    {
        if ($id) {
            return Review::find($id);
        }

        return Review::when($search, function ($query) use ($search) {
            $query->where('comment', 'like', "%$search%");
        })->latest('id')->get();
    }

    public static function getBookReviews(Book $book, int $limit = 5)
    {
        return $book->reviews()->latest()->take($limit)->with('user:id,first_name,last_name')->get();
    }

    public static function createOrUpdateReview(array $data, ?Review $review = null): Review
    {
        if ($review) {
            $review->update($data);
            return $review->fresh();
        }

        return Review::create($data);
    }
    public static function deleteReview(Review $review): void
    {
        $review->delete();
    }
}
