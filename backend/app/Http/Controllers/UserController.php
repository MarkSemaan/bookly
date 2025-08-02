<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function getUsers(Request $request, $id = null)
    {
        try {
            $search = $request->query('search');
            $users = UserService::getUsers($id, $search);

            if ($id && !$users) {
                return $this->fail("User not found", "fail", 404);
            }

            return $this->responseJSON($users, $id ? "User found" : "Users loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) return $this->fail("User not found", "fail", 404);

            $updated = UserService::updateUserInfo($user, $request->validated());
            return $this->responseJSON($updated, "User updated");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function upgrade($id)
    {
        try {
            $user = User::find($id);
            if (!$user) return $this->fail("User not found", "fail", 404);

            $upgraded = UserService::upgradeToAdmin($user);
            return $this->responseJSON($upgraded, "User upgraded to admin");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }

    public function getUserReviews($id)
    {
        try {
            $user = User::find($id);
            if (!$user) return $this->fail("User not found", "fail", 404);

            $reviews = UserService::getUserReviews($user);
            return $this->responseJSON($reviews, "User reviews loaded");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), "error", 500);
        }
    }
}
