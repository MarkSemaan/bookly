<?php
namespace App\Services;

use App\Agents\BookRecommendationAgent;
use App\Models\UserSearchHistory;
use App\Models\UserBookView;
use App\Models\RecommendationLog;

class AgentService
{
    public static function recommendBooks(int $userId): array
    {
        $agent = new BookRecommendationAgent();
        return $agent->run($userId);
    }

    public static function saveSearch($request)
    {
        return UserSearchHistory::create([
            'user_id' => $request->user()->id,
            'search_query' => $request->search_query,
        ]);
    }

    public static function saveBookView($request)
    {
        return UserBookView::create([
            'user_id' => $request->user()->id,
            'book_id' => $request->book_id,
        ]);
    }

    public static function saveRecommendationLog($recommendation)
    {
        return RecommendationLog::create([
            'user_id' => $recommendation['user_id'],
            'book_ids' => json_encode($recommendation['book_ids']),
            'reason' => $recommendation['reason'],
        ]);
    }
}