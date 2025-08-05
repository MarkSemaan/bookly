<?php

namespace App\Agents;

use Illuminate\Support\Facades\Http;
use App\Services\ToolExecutorService;
use App\Services\BookService;

class BookRecommendationAgent
{
    private $system_message = <<<EOT
            You are an agent that can use ONLY the defined tools below to recommend 5 books ONLY from the available books for the user.
            In case you don't have anything to recommend, you can recommend from the best selling and the top rated books
            Always respond with JSON in this format:

            {
            "action": "tool_name" | "final_answer",
            "parameters": { ... },     // for tool calls
            "result": [...],            // for final answer with book IDs ONLY
            "reason": "..."             // the reason why you chose the tool or the reason why you chose the final answer like that, but in a short sentence
            }

            If you choose a tool, use the tool_name exactly as defined.
            If you want to finish, reply with action = "final_answer" and the recommended book names in result,
            make sure these books exist in the database.
            EOT;

    public function run(int $user_id): array
    {
        $availableBooks = BookService::getAvailable();
        $tools = json_decode(file_get_contents(storage_path('app/private/tools.json')), true);
        $messages = [
            [
                "role" => "system",
                "content" => $this->system_message
            ],
            ["role" => "system", "content" => "User Id: {$user_id}"],
            ["role" => "system", "content" => "Available books: " . json_encode($availableBooks)],
            ["role" => "system", "content" => "Available tools: " . json_encode($tools)],
            [
                "role" => "user",
                "content" => "Recommend 5 books for the user based on their search history, views, purchases, cart, and reviews."
            ],
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

        for ($i = 0; $i < 15; $i++) {
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
            $messages[] = ["role" => "user", "content" => "Got result for {$json['action']}, what's next?"];
        }

        return [];
    }
}