<?php

namespace App\Http\Controllers;

use App\AgentService;
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
}
