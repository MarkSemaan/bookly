<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService{
   
    public static function login(array $data)
{
    $token = Auth::attempt($data);
    if (!$token) return null;
    $user = Auth::user();
    $user->token = $token;
    return $user;
}

public static function register(array $data)
{
    $user = new User;
    $user->first_name = $data['first_name'];
    $user->last_name = $data['last_name'] ?? null;
    $user->email = $data['email'];
    $user->role = 'customer';
    $user->password = bcrypt($data['password']);
    $user->save();

    $token = Auth::login($user);
    $user->token = $token;
    return $user;
}

}