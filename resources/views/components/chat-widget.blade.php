{{-- Chat Widget Component --}}
@php
    $chatWidgetI18n = [
        'greeting' => __('chat.greeting'),
        'supportLabel' => __('chat.support_label'),
        'supportShort' => __('chat.support_short'),
        'youLabel' => __('chat.you_label'),
    ];
@endphp
<div id="chat-widget" class="fixed bottom-4 right-4 z-50">
    {{-- Unread badge --}}
    <span id="unread-badge" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">0</span>
    
    {{-- Chat button --}}
    <button 
        id="chat-toggle" 
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center relative"
        onclick="toggleChat()"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
    </button>

    {{-- Chat window (hidden by default) --}}
    <div 
        id="chat-window" 
        class="hidden absolute bottom-16 right-0 w-80 bg-white rounded-lg shadow-2xl overflow-hidden"
        style="max-height: 500px;"
    >
        {{-- Chat header --}}
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold">{{ __('chat.support_title') }}</h3>
                <p class="text-xs opacity-90">{{ __('chat.support_subtitle') }}</p>
            </div>
            <button onclick="toggleChat()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Chat messages --}}
        <div id="chat-messages" class="p-4 h-80 overflow-y-auto bg-gray-50">
            <div class="text-center text-gray-500 text-sm py-4">
                <i class="fas fa-spinner fa-spin"></i> {{ __('chat.loading_messages') }}
            </div>
        </div>

        {{-- Chat input --}}
        <div class="p-4 bg-white border-t">
            <div class="flex gap-2">
                <input 
                    type="text" 
                    id="chat-input"
                    placeholder="{{ __('chat.message_placeholder') }}" 
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onkeypress="if(event.key === 'Enter') sendChatMessage()"
                >
                <button 
                    onclick="sendChatMessage()"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const chatLocale = document.documentElement.lang || '{{ app()->getLocale() }}';
const chatI18n = @json($chatWidgetI18n);

let chatInterval = null;
let lastMessageId = 0;

function toggleChat() {
    const chatWindow = document.getElementById('chat-window');
    const isHidden = chatWindow.classList.contains('hidden');
    
    chatWindow.classList.toggle('hidden');
    
    if (isHidden) {
        // Chat opened - load messages
        loadChatMessages();
        // Start polling for new messages
        chatInterval = setInterval(loadChatMessages, 3000);
    } else {
        // Chat closed - stop polling
        if (chatInterval) {
            clearInterval(chatInterval);
            chatInterval = null;
        }
    }
}

function loadChatMessages() {
    fetch('/chat/messages', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayMessages(data.messages);
            updateUnreadCount();
        }
    })
    .catch(error => console.error('Error loading messages:', error));
}

function displayMessages(messages) {
    const container = document.getElementById('chat-messages');
    const currentUserId = {{ auth()->id() }};
    
    if (messages.length === 0) {
        container.innerHTML = `
            <div class="flex items-start mb-4">
                <div class="bg-blue-100 rounded-lg p-3 max-w-xs">
                    <p class="text-sm text-gray-800">${chatI18n.greeting}</p>
                    <span class="text-xs text-gray-500 mt-1 block">${chatI18n.supportLabel}</span>
                </div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = '';
    
    messages.forEach(msg => {
        const isCurrentUser = msg.sender_id === currentUserId;
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-start mb-4 ${isCurrentUser ? 'justify-end' : ''}`;
        
        const time = new Date(msg.created_at).toLocaleTimeString(chatLocale, { hour: '2-digit', minute: '2-digit' });
        
        messageDiv.innerHTML = `
            <div class="${isCurrentUser ? 'bg-blue-600 text-white' : 'bg-blue-100 text-gray-800'} rounded-lg p-3 max-w-xs">
                <p class="text-sm">${escapeHtml(msg.message)}</p>
                <span class="text-xs ${isCurrentUser ? 'opacity-75' : 'text-gray-500'} mt-1 block">
                    ${isCurrentUser ? chatI18n.youLabel : (msg.sender ? msg.sender.first_name : chatI18n.supportShort)} • ${time}
                </span>
            </div>
        `;
        container.appendChild(messageDiv);
        
        if (msg.id > lastMessageId) {
            lastMessageId = msg.id;
        }
    });
    
    container.scrollTop = container.scrollHeight;
}

function sendChatMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    
    if (message === '') return;
    
    // Disable input while sending
    input.disabled = true;
    
    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            loadChatMessages();
        }
    })
    .catch(error => console.error('Error sending message:', error))
    .finally(() => {
        input.disabled = false;
        input.focus();
    });
}

function updateUnreadCount() {
    fetch('/chat/unread-count', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('unread-badge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    })
    .catch(error => console.error('Error updating unread count:', error));
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Update unread count every 10 seconds
setInterval(updateUnreadCount, 10000);
updateUnreadCount();
</script>



