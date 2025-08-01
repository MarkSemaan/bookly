<?php

namespace App;

use App\Models\RecommendationLog;
use App\Models\UserBookView;
use App\Models\UserSearchHistory;

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
}
