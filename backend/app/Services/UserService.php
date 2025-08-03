<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public static function getUsers(?int $id = null, ?string $search = null)
    {
        if ($id) {
            return User::find($id);
        }

        return User::when($search, function ($query) use ($search) {
            $query->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%");
        })->latest('id')->get();
    }

    public static function updateUserInfo(User $user, array $data): User
    {
        $user->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
        ]);

        return $user->fresh();
    }

    public static function upgradeToAdmin(User $user): User
    {
        $user->role = 'admin';
        $user->save();

        return $user->fresh();
    }

    public static function getUserReviews(User $user)
    {
        return $user->reviews()->with('book')->get();
    }
}
