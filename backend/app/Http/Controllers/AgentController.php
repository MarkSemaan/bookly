<?php

namespace App\Http\Controllers;

use App\AgentService;
use App\Services\BookService;
use App\Services\CartService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public static function saveSearch($request)
    {
        try {
            $search = AgentService::saveSearch($request);
            return ResponseTrait::responseJSON($search);
        } catch (\Exception $e) {
            return ResponseTrait::fail($e->getMessage(), "error", 500);
        }
    }
    public static function saveBookView($request)
    {
        try {
            $view = AgentService::saveBookView($request);
            return ResponseTrait::responseJSON($view);
        } catch (\Exception $e) {
            return ResponseTrait::fail($e->getMessage(), "error", 500);
        }
    }
    public static function getRecommended($request)
    {
        $user_id = $request->input('user_id');

        $prompt = AgentService::buildPrompt($user_id);
        $book_ids = AgentService::prompt($prompt);
        $recommended = BookService::getBooksByIds($book_ids);
        return ResponseTrait::responseJSON($recommended);
    }
}
