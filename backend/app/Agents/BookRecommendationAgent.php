<?php

namespace App\Agents;

use Illuminate\Support\Facades\Http;
use App\Services\ToolExecutorService;
use App\Services\BookService;
use App\Services\CartService;
use App\Actions\GetUserHistories;
use App\Actions\GetUserReviews;
use App\Actions\GetUserViews;


class BookRecommendationAgent
{
    private $system_message = "You are an intelligent book recommendation agent in a book platform. Your task is to recommend 7 personalized books to the user, using only the available book dataset and tools.

                    You have access to the user's full history:
                    - Searches
                    - Views
                    - Purchases
                    - Cart
                    - Reviews
                    - Previously recommended books

                    You must analyze this history carefully and use the provided tools to extract insights. Your recommendation should:
                    - Be highly relevant to the user's **interests and behavior**
                    - Avoid using popularity or ratings as a default
                    - Use **multiple tools if necessary** to enrich your reasoning
                    - Avoid recommending already purchased books

                    Return your final result in this format:

                    ```json
                    {
                    \"action\": \"final_answer\",
                    \"result\": [book_id_1, book_id_2, ..., book_id_7],
                    \"reason\": \"Explain briefly in a short sentence of 10 words why these books were selected.\"
                    }";
    private $user_message = "Recommend 7 books tailored to the user's interests. Study their full history and use any necessary tools to understand what they like. Make sure the recommendations are personalized and include an explanation of your reasoning.";

    public function run(int $user_id): array
    {
        $availableBooks = BookService::getAvailable();
        $tools = json_decode(file_get_contents(storage_path('app/private/tools.json')), true);

        $messages = [
            ["role" => "system", "content" => "User ID: {$user_id}"],
            ["role" => "system", "content" => "User search history: " . json_encode(app(GetUserHistories::class)->execute($user_id))],
            ["role" => "system", "content" => "User views: " . json_encode(app(GetUserViews::class)->execute($user_id))],
            ["role" => "system", "content" => "User cart: " . json_encode(CartService::getCartItems($user_id))],
            ["role" => "system", "content" => "User reviews: " . json_encode(app(GetUserReviews::class)->execute($user_id))],
            ["role" => "system", "content" => "Available books: " . json_encode($availableBooks)],
            ["role" => "system", "content" => "Available tools: " . json_encode($tools)],
            ["role" => "system", "content" => $this->system_message],
            ["role" => "user", "content" => $this->user_message],
        ];

        $recommendations = $this->processConversation($messages, $user_id);
        $result = [
            'user_id' => $user_id,
            'book_ids' => $recommendations['result'],
            'reason' => $recommendations['reason']
        ];
        return $result;
    }

    private function processConversation(array &$messages, int $userId): array
    {
        $url = 'https://api.openai.com/v1/chat/completions';
        $headers = [
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ];

        for ($i = 0; $i < 12; $i++) {
            $response = Http::withHeaders($headers)->post($url, [
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);
            $content = $response->json()['choices'][0]['message']['content'] ?? null;
            if (!$content)
                break;

            $json = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($json['action'])) {
                $messages[] = ["role" => "assistant", "content" => "Please follow the JSON format with an 'action'."];
                continue;
            }

            if ($json['action'] === 'final_answer') {
                return $json ?? [];
            }

            $toolExecutor = new ToolExecutorService();
            $result = $toolExecutor->run($json['action'], $userId);

            $messages[] = [
                "role" => "assistant",
                "content" => "Tool response for {$json['action']}: " .
                    json_encode($result)
            ];
            $messages[] = ["role" => "user", "content" => "Got result for {$json['action']}, You can use another tool to know more if needed?"];
        }

        return [];
    }
}