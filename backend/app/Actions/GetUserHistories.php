<?php

namespace App\Actions;

use App\Models\UserSearchHistory;


class GetUserHistories
{
    public function execute(int $userId): array
    {
        return UserSearchHistory::where('user_id', $userId)
            ->where('searched_at', '>', now()->subDays(15))
            ->pluck('search_query')
            ->toArray();
    }
}