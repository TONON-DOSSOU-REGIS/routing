<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ChatController extends Controller
{
    private function presenceCacheKey(int $userId): string
    {
        return "chat:user:presence:{$userId}";
    }

    private function typingCacheKey(int $senderId, int $receiverId): string
    {
        return "chat:user:typing:{$senderId}:{$receiverId}";
    }

    private function findPrimaryAdmin(): ?User
    {
        return User::query()
            ->where('role', 'admin')
            ->orderBy('id')
            ->first();
    }

    private function resolveChatPartner(?User $currentUser, $requestedUserId = null): ?User
    {
        if (!$currentUser) {
            return null;
        }

        if ($currentUser->isAdmin()) {
            $targetUserId = (int) $requestedUserId;
            if ($targetUserId <= 0) {
                return null;
            }

            $targetUser = User::find($targetUserId);

            return $targetUser && !$targetUser->isAdmin()
                ? $targetUser
                : null;
        }

        $admin = $this->findPrimaryAdmin();

        return $admin && (int) $admin->id !== (int) $currentUser->id
            ? $admin
            : null;
    }

    private function formatUserDisplayName(?User $user): string
    {
        if (!$user) {
            return __('system_messages.fallback_user');
        }

        $fullName = trim(implode(' ', array_filter([
            (string) ($user->first_name ?? ''),
            (string) ($user->last_name ?? ''),
        ])));

        if ($fullName !== '') {
            return $fullName;
        }

        return (string) ($user->email ?? __('system_messages.fallback_user'));
    }

    private function formatChatMessage(ChatMessage $message): array
    {
        $message->loadMissing(['sender', 'receiver']);

        return [
            'id' => (int) $message->id,
            'sender_id' => (int) $message->sender_id,
            'receiver_id' => (int) $message->receiver_id,
            'message' => (string) ($message->message ?? ''),
            'is_read' => (bool) $message->is_read,
            'attachment_path' => $message->attachment_path,
            'attachment_url' => $message->attachment_url,
            'attachment_name' => $message->attachment_name,
            'attachment_type' => $message->attachment_type,
            'attachment_size' => $message->attachment_size,
            'formatted_attachment_size' => $message->formatted_size,
            'is_image_attachment' => $message->isImage(),
            'created_at' => $message->created_at ? $message->created_at->toISOString() : null,
            'updated_at' => $message->updated_at ? $message->updated_at->toISOString() : null,
            'sender_display_name' => $this->formatUserDisplayName($message->sender),
            'receiver_display_name' => $this->formatUserDisplayName($message->receiver),
            'sender' => $message->sender ? [
                'id' => (int) $message->sender->id,
                'first_name' => (string) ($message->sender->first_name ?? ''),
                'last_name' => (string) ($message->sender->last_name ?? ''),
                'email' => (string) ($message->sender->email ?? ''),
                'display_name' => $this->formatUserDisplayName($message->sender),
            ] : null,
            'receiver' => $message->receiver ? [
                'id' => (int) $message->receiver->id,
                'first_name' => (string) ($message->receiver->first_name ?? ''),
                'last_name' => (string) ($message->receiver->last_name ?? ''),
                'email' => (string) ($message->receiver->email ?? ''),
                'display_name' => $this->formatUserDisplayName($message->receiver),
            ] : null,
        ];
    }

    private function touchUserPresence(?int $userId = null): void
    {
        $resolvedUserId = (int) ($userId ?? Auth::id());
        if ($resolvedUserId <= 0) {
            return;
        }

        $ttlMinutes = max((int) config('session.lifetime', 120), 5);

        try {
            Cache::put(
                $this->presenceCacheKey($resolvedUserId),
                now()->timestamp,
                now()->addMinutes($ttlMinutes)
            );
        } catch (\Throwable $e) {
            Log::warning('Unable to write chat presence heartbeat to cache', [
                'user_id' => $resolvedUserId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function isUserTypingTo(int $senderId, int $receiverId): bool
    {
        if ($senderId <= 0 || $receiverId <= 0) {
            return false;
        }

        $typingThreshold = now()->subSeconds(8)->timestamp;

        try {
            $typingTimestamp = (int) Cache::get($this->typingCacheKey($senderId, $receiverId), 0);
        } catch (\Throwable $e) {
            Log::warning('Unable to read chat typing state from cache', [
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }

        return $typingTimestamp >= $typingThreshold;
    }

    /**
     * Build a presence map for users based on chat heartbeats and active sessions.
     *
     * Presence states:
     * - online: recent activity (last 2 minutes)
     * - connected: authenticated session still active but not recently active
     * - disconnected: no active session
     */
    private function getUsersPresence(array $userIds): array
    {
        $presenceMap = [];
        $lastActivityByUserId = [];
        $normalizedUserIds = collect($userIds)
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values()
            ->all();

        foreach ($normalizedUserIds as $userId) {
            $presenceMap[$userId] = [
                'is_online' => false,
                'is_connected' => false,
                'presence_status' => 'disconnected',
                'last_activity_at' => null,
            ];

            try {
                $heartbeat = (int) Cache::get($this->presenceCacheKey($userId), 0);
            } catch (\Throwable $e) {
                $heartbeat = 0;
                Log::warning('Unable to read chat presence heartbeat from cache', [
                    'user_id' => $userId,
                    'error' => $e->getMessage(),
                ]);
            }
            if ($heartbeat > 0) {
                $lastActivityByUserId[$userId] = $heartbeat;
            }
        }

        if (empty($normalizedUserIds)) {
            return $presenceMap;
        }

        $sessionLifetimeMinutes = (int) config('session.lifetime', 120);
        $onlineThreshold = now()->subMinutes(2)->timestamp;
        $connectedThreshold = now()->subMinutes($sessionLifetimeMinutes)->timestamp;

        $sessionTable = (string) config('session.table', 'sessions');
        $usesDatabaseSessionDriver = config('session.driver') === 'database';

        if ($usesDatabaseSessionDriver && Schema::hasTable($sessionTable)) {
            $sessions = DB::table($sessionTable)
                ->select('user_id', DB::raw('MAX(last_activity) as last_activity'))
                ->whereNotNull('user_id')
                ->whereIn('user_id', $normalizedUserIds)
                ->groupBy('user_id')
                ->get();

            foreach ($sessions as $session) {
                $userId = (int) $session->user_id;
                $lastActivity = (int) $session->last_activity;

                if ($lastActivity > ($lastActivityByUserId[$userId] ?? 0)) {
                    $lastActivityByUserId[$userId] = $lastActivity;
                }
            }
        }

        foreach ($presenceMap as $userId => $defaults) {
            $lastActivity = (int) ($lastActivityByUserId[$userId] ?? 0);
            $presenceStatus = 'disconnected';

            if ($lastActivity >= $onlineThreshold) {
                $presenceStatus = 'online';
            } elseif ($lastActivity >= $connectedThreshold) {
                $presenceStatus = 'connected';
            }

            $presenceMap[$userId] = array_merge($defaults, [
                'is_online' => $presenceStatus === 'online',
                'is_connected' => $presenceStatus !== 'disconnected',
                'presence_status' => $presenceStatus,
                'last_activity_at' => $lastActivity > 0 ? now()->setTimestamp($lastActivity)->toISOString() : null,
            ]);
        }

        return $presenceMap;
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        Log::info('ChatController@sendMessage called with data:', $request->all());
        $currentUser = Auth::user();
        $currentUserId = (int) ($currentUser?->id ?? 0);
        $this->touchUserPresence($currentUserId);

        if (!$currentUser || $currentUserId <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $request->validate([
            'message' => 'nullable|string|max:1000',
            'receiver_id' => 'nullable|integer|exists:users,id',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,txt,zip',
        ]);

        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json([
                'success' => false,
                'message' => __('system_messages.chat_message_required'),
            ], 422);
        }

        $receiver = $this->resolveChatPartner($currentUser, $request->receiver_id);

        if (!$receiver) {
            return response()->json([
                'success' => false,
                'message' => $currentUser->isAdmin()
                    ? 'Invalid receiver selected'
                    : 'No admin found',
            ], 422);
        }

        $receiverId = (int) $receiver->id;

        if ($receiverId === $currentUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid receiver selected',
            ], 422);
        }

        if ($receiverId) {
            try {
                Cache::forget($this->typingCacheKey($currentUserId, $receiverId));
            } catch (\Throwable $e) {
                Log::warning('Unable to clear typing cache on message send', [
                    'sender_id' => $currentUserId,
                    'receiver_id' => $receiverId,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $messageData = [
            'sender_id' => $currentUserId,
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

        if (!$currentUser->isAdmin()) {
            try {
                NotificationService::notifyAdminUserMessage($currentUser, $message);
            } catch (\Exception $e) {
                Log::error('Failed to notify admins of user message', [
                    'message_id' => $message->id,
                    'sender_id' => $currentUser->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $this->formatChatMessage($message),
        ]);
    }

    /**
     * Get messages between current user and another user
     */
    public function getMessages(Request $request, $userId = null)
    {
        $currentUserId = Auth::id();
        $currentUser = Auth::user();
        $this->touchUserPresence($currentUserId);

        // Handle case where locale prefix is passed as userId (e.g., "pl", "fr")
        if ($userId && !is_numeric($userId)) {
            $userId = null;
        }

        Log::info('ChatController@getMessages called', [
            'current_user_id' => $currentUserId,
            'requested_user_id' => $userId,
            'is_admin' => $currentUser ? $currentUser->isAdmin() : false
        ]);

        // If user is admin and no userId specified, get all conversations
        if ($currentUser && $currentUser->isAdmin() && !$userId) {
            Log::info('Admin requesting all conversations');
            return $this->getAdminConversations();
        }

        // If userId not specified, get messages with admin
        $chatPartner = $this->resolveChatPartner($currentUser, $userId);

        if (!$chatPartner) {
            Log::error('Unable to resolve chat partner', [
                'current_user_id' => $currentUserId,
                'requested_user_id' => $userId,
            ]);

            return response()->json([
                'success' => false,
                'message' => $currentUser && $currentUser->isAdmin()
                    ? 'Invalid chat partner'
                    : 'No admin found',
            ], 404);
        }

        $userId = (int) $chatPartner->id;

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

        Log::info('Messages retrieved', [
            'count' => $messages->count(),
            'current_user_id' => $currentUserId,
            'other_user_id' => $userId
        ]);

        // Transform messages to ensure proper format
        $formattedMessages = $messages->map(fn (ChatMessage $message) => $this->formatChatMessage($message));

        Log::info('Formatted messages', ['sample' => $formattedMessages->take(1)]);

        // Mark messages as read
        ChatMessage::where('receiver_id', $currentUserId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $responsePayload = [
            'success' => true,
            'messages' => $formattedMessages,
            'chat_partner' => [
                'id' => (int) $chatPartner->id,
                'first_name' => (string) ($chatPartner->first_name ?? ''),
                'last_name' => (string) ($chatPartner->last_name ?? ''),
                'email' => (string) ($chatPartner->email ?? ''),
                'role' => (string) ($chatPartner->role ?? 'user'),
                'display_name' => $this->formatUserDisplayName($chatPartner),
            ],
        ];

        $presence = $this->getUsersPresence([(int) $userId])[(int) $userId] ?? [
            'is_online' => false,
            'is_connected' => false,
            'presence_status' => 'disconnected',
            'last_activity_at' => null,
        ];

        $responsePayload['user_presence'] = array_merge(
            ['user_id' => (int) $userId],
            $presence
        );
        $responsePayload['user_typing'] = $this->isUserTypingTo((int) $userId, (int) $currentUserId);

        return response()->json($responsePayload);
    }

    /**
     * Return available users for admin chat selection (including users without messages).
     */
    public function getUsersForAdmin(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden',
            ], 403);
        }

        $this->touchUserPresence((int) $currentUser->id);

        $search = trim((string) $request->query('q', ''));
        $adminId = (int) $currentUser->id;

        $query = User::query()
            ->where('role', '!=', 'admin');

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('first_name', 'like', $like)
                    ->orWhere('last_name', 'like', $like)
                    ->orWhere('email', 'like', $like);
            });
        }

        $users = $query
            ->when($search === '', function ($builder) {
                $builder->orderByDesc('created_at');
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->limit(200)
            ->get(['id', 'first_name', 'last_name', 'email', 'role']);

        $userIds = $users->pluck('id')->map(fn ($id) => (int) $id)->all();
        $presenceByUserId = $this->getUsersPresence($userIds);

        $unreadByUserId = empty($userIds)
            ? collect()
            : ChatMessage::query()
                ->where('receiver_id', $adminId)
                ->where('is_read', false)
                ->whereIn('sender_id', $userIds)
                ->selectRaw('sender_id, COUNT(*) as unread_count')
                ->groupBy('sender_id')
                ->pluck('unread_count', 'sender_id');

        $result = $users->map(function (User $user) use ($presenceByUserId, $unreadByUserId) {
            $presence = $presenceByUserId[(int) $user->id] ?? [
                'is_online' => false,
                'is_connected' => false,
                'presence_status' => 'disconnected',
                'last_activity_at' => null,
            ];

            return [
                'id' => (int) $user->id,
                'first_name' => (string) ($user->first_name ?? ''),
                'last_name' => (string) ($user->last_name ?? ''),
                'email' => (string) ($user->email ?? ''),
                'role' => (string) ($user->role ?? 'user'),
                'is_online' => (bool) $presence['is_online'],
                'is_connected' => (bool) $presence['is_connected'],
                'presence_status' => (string) $presence['presence_status'],
                'last_activity_at' => $presence['last_activity_at'],
                'unread_count' => (int) ($unreadByUserId[$user->id] ?? 0),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'users' => $result,
        ]);
    }

    /**
     * Get all conversations for admin
     */
    private function getAdminConversations()
    {
        $adminId = Auth::id();

        $users = User::query()
            ->where('role', '!=', 'admin')
            ->orderByDesc('created_at')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name', 'email', 'role', 'created_at']);

        $userIds = $users->pluck('id')->map(fn ($id) => (int) $id)->values();
        $presenceByUserId = $this->getUsersPresence($userIds->all());

        $messages = $userIds->isEmpty()
            ? collect()
            : ChatMessage::query()
                ->where(function ($query) use ($adminId, $userIds) {
                    $query->where(function ($q) use ($adminId, $userIds) {
                        $q->where('sender_id', $adminId)
                            ->whereIn('receiver_id', $userIds);
                    })->orWhere(function ($q) use ($adminId, $userIds) {
                        $q->whereIn('sender_id', $userIds)
                            ->where('receiver_id', $adminId);
                    });
                })
                ->with(['sender', 'receiver'])
                ->latest()
                ->get();

        $lastMessageByUserId = [];
        foreach ($messages as $message) {
            $counterpartId = (int) ($message->sender_id === $adminId ? $message->receiver_id : $message->sender_id);
            if ($counterpartId > 0 && !isset($lastMessageByUserId[$counterpartId])) {
                $lastMessageByUserId[$counterpartId] = $message;
            }
        }

        $unreadByUserId = $userIds->isEmpty()
            ? collect()
            : ChatMessage::query()
                ->where('receiver_id', $adminId)
                ->where('is_read', false)
                ->whereIn('sender_id', $userIds)
                ->selectRaw('sender_id, COUNT(*) as unread_count')
                ->groupBy('sender_id')
                ->pluck('unread_count', 'sender_id');

        $conversations = $users->map(function (User $user) use ($presenceByUserId, $lastMessageByUserId, $unreadByUserId) {
            $presence = $presenceByUserId[(int) $user->id] ?? [
                'is_online' => false,
                'is_connected' => false,
                'presence_status' => 'disconnected',
                'last_activity_at' => null,
            ];

            $lastMessage = $lastMessageByUserId[(int) $user->id] ?? null;

            return [
                'user' => [
                    'id' => (int) $user->id,
                    'first_name' => (string) ($user->first_name ?? ''),
                    'last_name' => (string) ($user->last_name ?? ''),
                    'email' => (string) ($user->email ?? ''),
                    'role' => (string) ($user->role ?? 'user'),
                    'is_online' => (bool) $presence['is_online'],
                    'is_connected' => (bool) $presence['is_connected'],
                    'presence_status' => (string) $presence['presence_status'],
                    'last_activity_at' => $presence['last_activity_at'],
                ],
                'last_message' => $lastMessage ? [
                    'id' => (int) $lastMessage->id,
                    'message' => (string) ($lastMessage->message ?? ''),
                    'attachment_name' => $lastMessage->attachment_name,
                    'attachment_type' => $lastMessage->attachment_type,
                    'created_at' => $lastMessage->created_at?->toISOString(),
                    'sender_id' => (int) $lastMessage->sender_id,
                    'receiver_id' => (int) $lastMessage->receiver_id,
                ] : null,
                'unread_count' => (int) ($unreadByUserId[$user->id] ?? 0),
                'sort_created_at' => $user->created_at?->toISOString(),
            ];
        })->sort(function (array $a, array $b) {
            $timeA = $a['last_message']['created_at'] ?? null;
            $timeB = $b['last_message']['created_at'] ?? null;

            if ($timeA && $timeB) {
                return strcmp($timeB, $timeA);
            }

            if ($timeA) {
                return -1;
            }

            if ($timeB) {
                return 1;
            }

            return strcmp((string) ($b['sort_created_at'] ?? ''), (string) ($a['sort_created_at'] ?? ''));
        })->values()->map(function (array $conversation) {
            unset($conversation['sort_created_at']);

            return $conversation;
        })->all();

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
        $this->touchUserPresence(Auth::id());

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
        $currentUser = Auth::user();
        $currentUserId = (int) ($currentUser?->id ?? 0);
        $this->touchUserPresence($currentUserId);

        if (!$currentUser || $currentUserId <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $chatPartner = $this->resolveChatPartner($currentUser, $userId);
        if (!$chatPartner) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid chat partner',
            ], 404);
        }

        ChatMessage::where('receiver_id', $currentUserId)
            ->where('sender_id', (int) $chatPartner->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Set current typing status for the authenticated user.
     */
    public function setTyping(Request $request)
    {
        $currentUser = Auth::user();
        $senderId = (int) ($currentUser?->id ?? 0);
        $this->touchUserPresence($senderId);

        $validated = $request->validate([
            'receiver_id' => 'nullable|integer|exists:users,id',
            'is_typing' => 'required|boolean',
        ]);

        if ($senderId <= 0 || !$currentUser) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $receiver = $this->resolveChatPartner($currentUser, $validated['receiver_id'] ?? null);
        $receiverId = (int) ($receiver?->id ?? 0);

        if ($receiverId <= 0 || $receiverId === $senderId) {
            return response()->json([
                'success' => true,
            ]);
        }

        $isTyping = (bool) ($validated['is_typing'] ?? false);
        $cacheKey = $this->typingCacheKey($senderId, $receiverId);

        try {
            if ($isTyping) {
                Cache::put($cacheKey, now()->timestamp, now()->addSeconds(12));
            } else {
                Cache::forget($cacheKey);
            }
        } catch (\Throwable $e) {
            Log::warning('Unable to update chat typing state in cache', [
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'is_typing' => $isTyping,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
