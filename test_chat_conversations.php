<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get admin
$admin = App\Models\User::where('role', 'admin')->first();

if (!$admin) {
    echo "No admin found!\n";
    exit;
}

echo "Admin ID: {$admin->id}\n";
echo "Admin Name: {$admin->first_name} {$admin->last_name}\n\n";

// Get all chat messages
$messages = App\Models\ChatMessage::all();
echo "Total messages in database: " . $messages->count() . "\n\n";

// Get conversations
$userIds = App\Models\ChatMessage::where('sender_id', $admin->id)
    ->orWhere('receiver_id', $admin->id)
    ->get()
    ->map(function($message) use ($admin) {
        return $message->sender_id == $admin->id ? $message->receiver_id : $message->sender_id;
    })
    ->unique()
    ->filter()
    ->values();

echo "Users with conversations: " . $userIds->count() . "\n";
print_r($userIds->toArray());

// For each user, get their info
foreach ($userIds as $userId) {
    $user = App\Models\User::find($userId);
    if ($user) {
        echo "\n--- User: {$user->first_name} {$user->last_name} (ID: {$user->id}) ---\n";
        
        // Get messages with this user
        $userMessages = App\Models\ChatMessage::where(function($query) use ($admin, $userId) {
                $query->where(function($q) use ($admin, $userId) {
                    $q->where('sender_id', $admin->id)
                      ->where('receiver_id', $userId);
                })->orWhere(function($q) use ($admin, $userId) {
                    $q->where('sender_id', $userId)
                      ->where('receiver_id', $admin->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        echo "Messages count: " . $userMessages->count() . "\n";
        foreach ($userMessages as $msg) {
            $from = $msg->sender_id == $admin->id ? "Admin" : "Client";
            echo "  [{$from}] {$msg->message}\n";
        }
    }
}

