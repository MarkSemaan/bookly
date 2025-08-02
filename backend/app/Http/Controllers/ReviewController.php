<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Models\Review;
use App\Models\Book;

use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{



    public function getReviews(Request $request, $id = null)
    {
        try {
            $search = $request->query('search');
            $reviews = ReviewService::getReviews($id, $search);

            if ($id && !$reviews) {
                return $this->fail("Review not found", "fail", 404);
            }

            return $this->responseJSON($reviews, $id ? "Review found" : "Reviews loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getBookReviews($bookId)
    {
        try {
            $book = Book::find($bookId);
            if (!$book) return $this->fail("Book not found", "fail", 404);

            $reviews = ReviewService::getBookReviews($book, 5);

            return $this->responseJSON($reviews, "Last 5 reviews loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function storeOrUpdate(StoreReviewRequest $request)
    {
        try {
            $validated = $request->validated();
            $id = $validated['id'] ?? null;
            $review = $id ? Review::find($id) : null;

            if ($id && !$review) {
                return $this->fail("Review not found", "fail", 404);
            }

            $result = ReviewService::createOrUpdateReview($validated, $review);

            return $this->responseJSON($result, $id ? "Review updated" : "Review added", $id ? 200 : 201);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
    public function destroy(int $id)
    {
        try {
            $review = Review::find($id);
            if (!$review) {
                return $this->fail("Review not found", "fail", 404);
            }

            ReviewService::deleteReview($review);

            return $this->responseJSON(null, "Review deleted");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
