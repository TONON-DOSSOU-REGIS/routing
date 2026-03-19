<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get unread notifications count.
     */
    public function getUnreadCount()
    {
        $count = auth()->user()->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($locale, Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => __('notification_content.api.not_found'),
            ], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => __('notification_content.api.marked_read'),
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => __('notification_content.api.all_marked_read'),
        ]);
    }

    /**
     * Delete all read notifications.
     */
    public function deleteAllRead(Request $request)
    {
        auth()->user()->notifications()->where('is_read', true)->delete();

        return response()->json([
            'success' => true,
            'message' => __('notification_content.api.all_read_deleted'),
        ]);
    }

    /**
     * Display the notifications index page.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $totalNotificationsCount = $user->notifications()->count();
        $unreadNotificationsCount = $user->unreadNotifications()->count();
        $readNotificationsCount = max($totalNotificationsCount - $unreadNotificationsCount, 0);
        $notificationsLast24HoursCount = $user->notifications()
            ->where('created_at', '>=', now()->subDay())
            ->count();

        $profileFields = [
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->phone,
            $user->address,
            $user->country,
            $user->city,
            $user->date_of_birth,
            $user->id_type,
            $user->id_number,
            $user->iban,
            $user->profile_photo_path,
        ];

        $profileCompletion = (int) round(
            (collect($profileFields)->filter(fn ($value) => filled($value))->count() / count($profileFields)) * 100
        );

        return view('notifications.index', compact(
            'user',
            'totalNotificationsCount',
            'unreadNotificationsCount',
            'readNotificationsCount',
            'notificationsLast24HoursCount',
            'profileCompletion'
        ));
    }

    /**
     * Get notifications data for AJAX requests.
     */
    public function getData(Request $request)
    {
        $user = auth()->user();
        $query = $user->notifications()->orderBy('created_at', 'desc');

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
        $overviewTotal = $user->notifications()->count();
        $overviewUnread = $user->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications->items(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ],
            'overview' => [
                'total' => $overviewTotal,
                'unread' => $overviewUnread,
                'read' => max($overviewTotal - $overviewUnread, 0),
                'last_24_hours' => $user->notifications()
                    ->where('created_at', '>=', now()->subDay())
                    ->count(),
            ],
        ]);
    }

    /**
     * Get a single notification details.
     */
    public function show($locale, Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => __('notification_content.api.not_found'),
            ], 404);
        }

        return response()->json([
            'success' => true,
            'notification' => $notification,
        ]);
    }

    /**
     * Get recent notifications for dropdown.
     */
    public function getRecent(Request $request)
    {
        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
        ]);
    }
}
