<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        $count = auth()->user()->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($locale, Notification $notification)
    {
        // Ensure user owns the notification
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Notification non trouvée.'], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Notification marquée comme lue.']);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Toutes les notifications ont été marquées comme lues.']);
    }

    /**
     * Delete all read notifications
     */
    public function deleteAllRead(Request $request)
    {
        auth()->user()->notifications()->where('is_read', true)->delete();

        return response()->json(['success' => true, 'message' => 'Toutes les notifications lues ont été supprimées.']);
    }

    /**
     * Display the notifications index page
     */
    public function index(Request $request)
    {
        return view('notifications.index');
    }

    /**
     * Get notifications data for AJAX requests
     */
    public function getData(Request $request)
    {
        $query = auth()->user()->notifications()->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->where('is_read', true);
            } elseif ($request->status === 'unread') {
                $query->where('is_read', false);
            }
        }

        $notifications = $query->paginate(20);

        return response()->json([
            'success' => true,
            'notifications' => $notifications->items(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total()
            ]
        ]);
    }

    /**
     * Get a single notification details
     */
    public function show($locale, Notification $notification)
    {
        // Ensure user owns the notification
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Notification non trouvée.'], 404);
        }

        return response()->json([
            'success' => true,
            'notification' => $notification
        ]);
    }

    /**
     * Get recent notifications for dropdown
     */
    public function getRecent(Request $request)
    {
        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }
}
