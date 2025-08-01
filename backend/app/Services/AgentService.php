<?php

namespace App;

use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use App\Models\RecommendationLog;
use App\Models\UserBookView;
use App\Models\UserSearchHistory;
use App\Models\Book;
use App\Models\Review;
use App\Services\BookService;
use function Laravel\Prompts\search;
use App\Services\CartService;
class AgentService
{

    public static function saveSearch($request)
    {
        $search = new UserSearchHistory();
        $search->user_id = $request->user()->id;
        $search->search_query = $request->search_query;
        $search->save();
        return $search;
    }
    public static function saveBookView($request)
    {
        $view = new UserBookView();
        $view->user_id = $request->user()->id;
        $view->book_id = $request->book_id;
        $view->save();
        return $view;
    }
    public static function saveRecommendationLog($recommendation)
    {
        $log = new RecommendationLog();
        $log->user_id = $recommendation->user_id;
        $log->book_ids = $recommendation->book_ids;
        $log->reason = $recommendation->reason;
        $log->save();
        return $log;
    }
    private static function getUserHistories($user_id)
    {
        $histories = UserSearchHistory::where('user_id', $user_id)
            ->where('searched_at', '>', now()->subDays(15))->pluck('search_query')->unique()->toArray();
        return $histories;
    }

    private static function getUserViews($user_id)
    {
        $books = Book::whereIn('id', function ($query) use ($user_id) {
            $query->select('book_id')
                ->from('user_book_views')
                ->where('user_id', $user_id)
                ->where('viewed_at', '>', now()->subDays(15));
        })->unique()->get();

        return $books;

    }
    private static function getUserBooks($user_id)
    {
        $books = Book::whereHas(
            'orderItems.order.payment',
            function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }
        )->get();
        return $books;
    }
    private static function getUserReviews($user_id)
    {
        $reviews = Review::where('user_id', $user_id)->get();
        return $reviews;
    }



    







    private static function getPromptDependencies($user_id)
    {
        $search_histories = AgentService::getUserHistories($user_id);
        $view_histories = AgentService::getUserViews($user_id);
        $bought = AgentService::getUserBooks($user_id);
        $reviews = AgentService::getUserReviews($user_id);
        $cart = CartService::getCartContents($user_id);
        $books = BookService::available();
        $dependencies = [
            'searchs' => $search_histories,
            'views' => $view_histories,
            'bought' => $bought,
            'reviews' => $reviews,
            'cart_books' => $cart,
            'books' => $books,
        ];
        return $dependencies;
    }
    public static function buildPrompt($user_id)
    {
        $data = self::getPromptDependencies($user_id);

        $prompt = <<<EOT
        You are a recommendation AI agent. Based on the following data, recommend 3 to 5 book IDs that the user is most likely interested in. Only return an array of book IDs, nothing else.

        User Data:

        - Recent Searches (last 15 days):
        {$data['searchs']}

        - Recently Viewed Books (last 15 days):
        [ 
            " . implode(", ", $data[views]->pluck('id')->toArray()) . "
        ]

        - Books Bought:
        [
            " . implode(", ", $data[bought]->pluck('id')->toArray()) . "
        ]

        - Books in Cart:
        [
            " . implode(", ", $data[cart_books]->pluck('id')->toArray()) . "
        ]

        - Reviews Written:
        [ 
            Book IDs: " . implode(", ", $data[reviews]->pluck('book_id')->toArray()) . " 
        ]

        - Available Books:
        [
            " . implode(", ", $data[books]->pluck('id')->toArray()) . "
        ]

        Only include recommended book IDs that exist in the 'Available Books' list. Return only the list of IDs like:
        [12, 45, 88]
        EOT;

        return $prompt;
    }
    public static function prompt($prompt)
    {
        $url = 'https://api.openai.com/v1/chat/completions';
        $headers = [
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ];
        $data = [
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a recommendation engine for a book platform. Respond only in raw JSON.',
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature' => 0.7,
            'max_tokens' => 1000,
        ];
        $response = Http::withHeaders($headers)->post($url, $data);
        // Extract content from the assistant's response
        $content = $response['choices'][0]['message']['content'];

        // Try to decode JSON array (e.g., "[1, 2, 3]")
        $bookIds = json_decode($content, true);

        // Make sure it's a valid array of integers
        if (is_array($bookIds)) {
            return array_filter($bookIds, fn($id) => is_int($id));
        }

        // Fallback if not valid
        return [];

    }

}
