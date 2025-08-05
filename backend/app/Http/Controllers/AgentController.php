<?php

namespace App\Http\Controllers;

use App\Services\AgentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Agents\BookRecommendationAgent;

class AgentController extends Controller
{
    use ResponseTrait;

    protected AgentService $agentService;

    public function saveSearch(Request $request)
    {
        try {
            $search = $this->agentService->saveSearch($request);
            return $this->responseJSON($search);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function saveBookView(Request $request)
    {
        try {
            $view = $this->agentService->saveBookView($request);
            return $this->responseJSON($view);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getRecommended()
    {
        try {
            $user_id = Auth::id();
            $recommended = app(BookRecommendationAgent::class)->run($user_id);
            return $this->responseJSON($recommended);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
