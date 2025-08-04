<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResponseTrait;
use App\Services\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = AuthService::login($request->validated());
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

    public function register(RegisterRequest $request)
    {
        $user = AuthService::register($request->validated());
        return ResponseTrait::responseJSON($user);
    }
}
