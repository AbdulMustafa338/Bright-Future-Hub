<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('id');
        
        if ($notificationId) {
            $notification = auth()->user()->unreadNotifications->where('id', $notificationId)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
