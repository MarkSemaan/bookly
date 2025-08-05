<?php
namespace App\Services;

use App\Agents\BookRecommendationAgent;
use App\Models\UserSearchHistory;
use App\Models\UserBookView;
use App\Models\RecommendationLog;

class AgentService
{
    public function recommendBooks(int $userId): array
    {
        $agent = new BookRecommendationAgent();
        return $agent->run($userId);
    }

    public function saveSearch($request)
    {
        return UserSearchHistory::create([
            'user_id' => $request->user()->id,
            'search_query' => $request->search_query,
        ]);
    }

    public function saveBookView($request)
    {
        return UserBookView::create([
            'user_id' => $request->user()->id,
            'book_id' => $request->book_id,
        ]);
    }

    public function saveRecommendationLog(object $recommendation)
    {
        return RecommendationLog::create([
            'user_id' => $recommendation->user_id,
            'book_ids' => $recommendation->book_ids,
            'reason' => $recommendation->reason,
        ]);
    }
}
