<?php
namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $notifications = NotificationService::getAll($request);
            return $this->responseJSON($notifications, 'All notifications loaded');
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function unread(Request $request)
    {
        try {
            $notifications = NotificationService::getUnread($request);
            return $this->responseJSON($notifications, 'Unread notifications loaded');
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function markAsRead(Request $request, string $id)
    {
        try {
            NotificationService::markAsRead($request, $id);
            return $this->responseJSON(null, 'Notification marked as read');
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function markAllAsRead(Request $request)
    {
        try {
            NotificationService::markAllAsRead($request);
            return $this->responseJSON(null, 'All notifications marked as read');
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }
    }
}