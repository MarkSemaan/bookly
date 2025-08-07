<?php

namespace App\Actions;

use App\Models\Review;


class GetUserReviews
{
    public function execute(int $user_id): array
    {
        $reviews = Review::where('user_id', $user_id)->get()->toArray();
        return $reviews;
    }
}