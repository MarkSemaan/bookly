<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function registerUser(array $userData)
    {
        return User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'role' => $userData['role'] ?? 'user',
        ]);
    }

    public function loginUser(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }
        return null;
    }
    public function logoutUser()
    {
        Auth::logout();
    }

    public function getUserByID(int $id)
    {
        return User::findOrFail($id);
    }
    public function getUserOrders(int $userId)
    {
        $user = User::findOrFail($userId);
        return $user->orders()->with('orderItems.book')->get();
    }

    public function getUserReviews(int $userId)
    {
        $user = User::findOrFail($userId);
        return $user->reviews()->with('book')->get();
    }
}
