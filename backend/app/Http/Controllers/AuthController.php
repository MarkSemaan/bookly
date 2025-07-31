<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Traits\ResponseTrait;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = AuthService::login($request);
        if ($user)
            return ResponseTrait::responseJSON($user);
        return ResponseTrait::responseJSON(null, "error", 401);
    }
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function register(Request $request)
    {
        $user = AuthService::register($request);
        return ResponseTrait::responseJSON($user);
    }
}