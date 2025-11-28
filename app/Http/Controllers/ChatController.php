<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        Log::info('ChatController@sendMessage called with data:', $request->all());

        $request->validate([
            'message' => 'nullable|string|max:1000',
            'receiver_id' => 'nullable|exists:users,id',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,txt,zip',
        ]);

        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez fournir un message ou une pièce jointe',
            ], 422);
        }

        $receiverId = $request->receiver_id;

        if (!$receiverId) {
            $admin = User::where('role', 'admin')->first();
            $receiverId = $admin ? $admin->id : null;
        }

        $messageData = [
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message ?? '',
            'is_read' => false,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store file in public disk to have public-accessible path
            $path = $file->storeAs('chat_attachments', $filename, 'public');

            Log::info('File uploaded:', ['filename' => $filename, 'path' => $path]);

            $messageData['attachment_path'] = $path;
            $messageData['attachment_name'] = $file->getClientOriginalName();
            $messageData['attachment_type'] = $file->getMimeType();
            $messageData['attachment_size'] = $file->getSize();
        }

        $message = ChatMessage::create($messageData);

        Log::info('Chat message created:', $message->toArray());

        return response()->json([
            'success' => true,
            'message' => $message->load(['sender', 'receiver']),
        ]);
    }

    /**
     * Get messages between current user and another user
     */
    public function getMessages(Request $request, $userId = null)
    {
        $currentUserId = Auth::id();
        $currentUser = Auth::user();
        
        // If user is admin and no userId specified, get all conversations
        if ($currentUser && $currentUser->isAdmin() && !$userId) {
            return $this->getAdminConversations();
        }
        
        // If userId not specified, get messages with admin
        if (!$userId) {
            $admin = User::where('role', 'admin')->first();
            $userId = $admin ? $admin->id : null;
        }

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'No admin found',
            ], 404);
        }

        $messages = ChatMessage::where(function($query) use ($currentUserId, $userId) {
                $query->where(function($q) use ($currentUserId, $userId) {
                    $q->where('sender_id', $currentUserId)
                      ->where('receiver_id', $userId);
                })->orWhere(function($q) use ($currentUserId, $userId) {
                    $q->where('sender_id', $userId)
                      ->where('receiver_id', $currentUserId);
                });
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        ChatMessage::where('receiver_id', $currentUserId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Get all conversations for admin
     */
    private function getAdminConversations()
    {
        $adminId = Auth::id();
        
        // Get all users who have sent messages to admin or received messages from admin
        $userIds = ChatMessage::where('sender_id', $adminId)
            ->orWhere('receiver_id', $adminId)
            ->get()
            ->map(function($message) use ($adminId) {
                return $message->sender_id == $adminId ? $message->receiver_id : $message->sender_id;
            })
            ->unique()
            ->filter()
            ->values();

        $conversations = [];
        
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            
            // Skip if user not found or is admin
            if (!$user || $user->isAdmin()) {
                continue;
            }
            
            // Get last message between admin and this user
            $lastMessage = ChatMessage::where(function($query) use ($adminId, $userId) {
                    $query->where(function($q) use ($adminId, $userId) {
                        $q->where('sender_id', $adminId)
                          ->where('receiver_id', $userId);
                    })->orWhere(function($q) use ($adminId, $userId) {
                        $q->where('sender_id', $userId)
                          ->where('receiver_id', $adminId);
                    });
                })
                ->with(['sender', 'receiver'])
                ->latest()
                ->first();
            
            $unreadCount = ChatMessage::where('sender_id', $userId)
                ->where('receiver_id', $adminId)
                ->where('is_read', false)
                ->count();
            
            // Ensure user data is properly formatted
            $conversations[] = [
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name ?? '',
                    'last_name' => $user->last_name ?? '',
                    'email' => $user->email ?? '',
                    'role' => $user->role ?? 'user',
                ],
                'last_message' => $lastMessage ? [
                    'id' => $lastMessage->id,
                    'message' => $lastMessage->message ?? '',
                    'created_at' => $lastMessage->created_at->toISOString(),
                    'sender_id' => $lastMessage->sender_id,
                    'receiver_id' => $lastMessage->receiver_id,
                ] : null,
                'unread_count' => $unreadCount,
            ];
        }
        
        // Sort by last message time
        usort($conversations, function($a, $b) {
            $timeA = $a['last_message'] ? $a['last_message']['created_at'] : null;
            $timeB = $b['last_message'] ? $b['last_message']['created_at'] : null;
            
            if (!$timeA) return 1;
            if (!$timeB) return -1;
            
            return strcmp($timeB, $timeA);
        });

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount()
    {
        $count = ChatMessage::where('receiver_id', Auth::id())
            ->unread()
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request, $userId)
    {
        ChatMessage::where('receiver_id', Auth::id())
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
        ]);
    }
}

