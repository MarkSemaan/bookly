<?php
namespace App\Services;

use Illuminate\Http\Request;

class NotificationService
{
    public static function getAll(Request $request)
    {
        return $request->user()->notifications()->latest()->get();
    }

    public static function getUnread(Request $request)
    {
        return $request->user()->unreadNotifications()->latest()->get();
    }

    public static function markAsRead(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();

        if (!$notification) {
            throw new \Exception("Notification not found or does not belong to user");
        }

        $notification->markAsRead();
    }

    public static function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
    }
}
