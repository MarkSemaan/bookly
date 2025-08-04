<?php

namespace App\Services;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
    // private static $system_message = <<<EOT
    //         You are an agent that can use ONLY the defined tools below to recommend 5 books ONLY from the available books for the user.
    //         Make sure to make sure the recommended books are available in the database!
    //         Always respond with JSON in this format:

    //         {
    //         "action": "tool_name" | "final_answer",
    //         "parameters": { ... },     // for tool calls
    //         "result": [...]            // for final answer with book IDs
    //         }

    //         If you choose a tool, use the tool_name exactly as defined.
    //         If you want to finish, reply with action = "final_answer" and the recommended book names in result, make sure these books exist in the database.
    //         EOT;

    // public static function saveSearch($request)
    // {
    //     $search = new UserSearchHistory();
    //     $search->user_id = $request->user()->id;
    //     $search->search_query = $request->search_query;
    //     $search->save();
    //     return $search;
    // }
    // public static function saveBookView($request)
    // {
    //     $view = new UserBookView();
    //     $view->user_id = $request->user()->id;
    //     $view->book_id = $request->book_id;
    //     $view->save();
    //     return $view;
    // }
    // public static function saveRecommendationLog($recommendation)
    // {
    //     $log = new RecommendationLog();
    //     $log->user_id = $recommendation->user_id;
    //     $log->book_ids = $recommendation->book_ids;
    //     $log->reason = $recommendation->reason;
    //     $log->save();
    //     return $log;
    // }
    // private static function getUserHistories($user_id)
    // {
    //     $histories = UserSearchHistory::where('user_id', $user_id)
    //         ->where('searched_at', '>', now()->subDays(15))->pluck('search_query')->toArray();
    //     return $histories;
    // }

    // private static function getUserViews($user_id)
    // {
    //     $books = Book::whereIn('id', function ($query) use ($user_id) {
    //         $query->select('book_id')
    //             ->from('user_book_views')
    //             ->where('user_id', $user_id)
    //             ->where('viewed_at', '>', now()->subDays(15));
    //     })->get();

    //     return $books;

    // }
    // private static function getUserBooks($user_id)
    // {
    //     $books = Book::whereHas(
    //         'orderItems.order.payment',
    //         function ($query) use ($user_id) {
    //             $query->where('user_id', $user_id);
    //         }
    //     )->get();
    //     return $books;
    // }
    // private static function getUserReviews($user_id)
    // {
    //     $reviews = Review::where('user_id', $user_id)->get();
    //     return $reviews;
    // }
    // private static function handleAction($user_id, $action)
    // {
    //     if ($action === 'final_answer') {
    //         return [];
    //     }
    //     // if ($action === 'getBooksByCategory') {
    //     //     return BookService::getBooksByCategory($category_id);

    //     // }

    //     return match ($action) {
    //         'getUserHistories' => self::getUserHistories($user_id),
    //         'getUserViews' => self::getUserViews($user_id),
    //         'getUserBooks' => self::getUserBooks($user_id),
    //         'getUserReviews' => self::getUserReviews($user_id),
    //         'getCartItems' => CartService::getCartItems($user_id),
    //         'available' => BookService::available(),
    //         'getTopRatedBooks' => BookService::getTopRatedBooks(),
    //         default => ["role" => "assistant", "content" => "Unknown tool requested: " . $action],
    //     };
    // }

    // private static function process($max, $headers, $url, $user_id, &$messages)
    // {
    //     for ($i = 0; $i < $max; $i++) {
    //         $data = [
    //             'model' => 'gpt-3.5-turbo',
    //             'messages' => $messages,
    //             'temperature' => 0.7,
    //             'max_tokens' => 1000,
    //         ];

    //         $response = Http::withHeaders($headers)->post($url, $data);

    //         $content = $response->json()['choices'][0]['message']['content'] ?? null;

    //         if (!$content)
    //             break;

    //         $json = json_decode($content, true);
    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             $messages[] = ["role" => "assistant", "content" => "Sorry, I could not parse your response as JSON. Please follow the format."];
    //             continue;
    //         }
    //         echo json_encode($messages);
    //         //✅ Check for final_answer
    //         if ($json['action'] === 'final_answer') {
    //             return $json['result'] ?? []; // ✅ Final return
    //         }

    //         if (!isset($json['action'])) {
    //             $messages[] = ["role" => "assistant", "content" => "Response missing 'action' field, please respond with JSON action."];
    //             continue;
    //         }

    //         $result = self::handleAction($user_id, $json['action']);
    //         $resultArray = is_iterable($result)
    //             ? collect($result)->map(fn($item) => is_object($item) && property_exists($item, 'id') ? $item->id : (is_string($item) ? $item : json_encode($item)))->toArray()
    //             : [$result];

    //         $messages[] = [
    //             "role" => "assistant",
    //             "content" => "Tool response for {$json['action']}: " . json_encode($resultArray),
    //         ];


    //         $messages[] = [
    //             "role" => "user",
    //             "content" => "Got result for {$json['action']}, what's next?",
    //         ];
    //     }


    //     return [];
    // }


    // public static function agentLoop($user_id)
    // {
    //     $system_message = self::$system_message;
    //     $goal_prompt = 'Recommend 5 books for the user based on their search, views, purchases, cart, and reviews.';
    //     $json = file_get_contents(storage_path('app/private/tools.json'));
    //     $tools = json_decode($json, true);
    //     $available_books = BookService::available();
    //     $messages = [
    //         ["role" => "system", "content" => $system_message],
    //         ["role" => "system", "content" => "User Id: " . $user_id],
    //         ["role" => "system", "content" => "Available books: " . json_encode($available_books)],
    //         ["role" => "system", "content" => "Available tools: " . json_encode($tools)],
    //         ["role" => "user", "content" => $goal_prompt],
    //     ];
    //     $url = 'https://api.openai.com/v1/chat/completions';
    //     $headers = [
    //         'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    //         'Content-Type' => 'application/json',
    //     ];

    //     $max_iterations = 15;

    //     $result = self::process($max_iterations, $headers, $url, $user_id, $messages);
    //     return $result;
    // }


}
