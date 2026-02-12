{{-- Admin Chat Widget Component - Version Corrigée --}}
@php
    $adminChatFixedI18n = [
        'loadingConversations' => __('admin_chat.loading_conversations'),
        'loadingError' => __('admin_chat.loading_error'),
        'noConversations' => __('admin_chat.no_conversations'),
        'messagesWillAppear' => __('admin_chat.messages_will_appear'),
        'noMessages' => __('admin_chat.no_messages'),
        'loadingMessagesError' => __('admin_chat.loading_messages_error'),
        'errorPrefix' => __('admin_chat.error_prefix'),
        'unknownError' => __('admin_chat.unknown_error'),
        'formatError' => __('admin_chat.format_error'),
        'connectionError' => __('admin_chat.connection_error'),
        'retry' => __('admin_chat.retry'),
        'sendError' => __('admin_chat.send_error'),
    ];
@endphp
<div id="admin-chat-widget" class="fixed bottom-4 right-4 z-50">
    {{-- Unread badge --}}
    <span id="admin-unread-badge" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">0</span>
    
    {{-- Chat button --}}
    <button 
        id="admin-chat-toggle" 
        class="bg-purple-600 hover:bg-purple-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center relative"
        onclick="toggleAdminChat()"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
        </svg>
    </button>

    {{-- Chat window (hidden by default) --}}
    <div 
        id="admin-chat-window" 
        class="hidden absolute bottom-16 right-0 w-96 bg-white rounded-lg shadow-2xl overflow-hidden"
        style="max-height: 600px;"
    >
        {{-- Chat header --}}
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold">{{ __('admin_chat.title') }}</h3>
                <p class="text-xs opacity-90">{{ __('admin_chat.subtitle') }}</p>
            </div>
            <button onclick="toggleAdminChat()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Conversations list or chat view --}}
        <div id="admin-chat-view">
            {{-- Conversations list --}}
            <div id="conversations-list" class="h-96 overflow-y-auto bg-gray-50">
                <div class="text-center text-gray-500 text-sm py-4">
                    <i class="fas fa-spinner fa-spin"></i> {{ __('admin_chat.loading_conversations') }}
                </div>
            </div>

            {{-- Individual chat view (hidden by default) --}}
            <div id="individual-chat" class="hidden">
                <div class="bg-gray-100 p-3 flex items-center border-b">
                    <button onclick="backToConversations()" class="mr-3 text-gray-600 hover:text-gray-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <div>
                        <div id="current-user-name" class="font-semibold text-gray-800"></div>
                        <div id="current-user-email" class="text-xs text-gray-500"></div>
                    </div>
                </div>
                
                <div id="chat-messages-container" class="p-4 h-80 overflow-y-auto bg-white">
                    <!-- Messages will be loaded here -->
                </div>
                
                <div class="p-4 bg-white border-t">
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            id="admin-chat-input"
                            placeholder="{{ __('admin_chat.reply_placeholder') }}" 
                            class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                            onkeypress="if(event.key === 'Enter') sendAdminMessage()"
                        >
                        <button 
                            onclick="sendAdminMessage()"
                            class="bg-purple-600 hover:bg-purple-700 text-white rounded-lg px-4 py-2 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let adminChatInterval = null;
let currentChatUserId = null;
let adminLastMessageId = 0;
const adminChatLocale = document.documentElement.lang || '{{ app()->getLocale() }}';
const adminChatI18n = @json($adminChatFixedI18n);

function toggleAdminChat() {
    const chatWindow = document.getElementById('admin-chat-window');
    const isHidden = chatWindow.classList.contains('hidden');
    
    chatWindow.classList.toggle('hidden');
    
    if (isHidden) {
        console.log('[Admin Chat] Opening chat widget');
        // Chat opened - load conversations
        loadConversations();
        // Start polling for new messages
        adminChatInterval = setInterval(loadConversations, 5000);
    } else {
        console.log('[Admin Chat] Closing chat widget');
        // Chat closed - stop polling
        if (adminChatInterval) {
            clearInterval(adminChatInterval);
            adminChatInterval = null;
        }
        // Reset to conversations list
        backToConversations();
    }
}

function loadConversations() {
    console.log('[Admin Chat] Loading conversations from /chat/messages');
    
    const container = document.getElementById('conversations-list');
    
    fetch('/chat/messages', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('[Admin Chat] Response status:', response.status);
        console.log('[Admin Chat] Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.text();
    })
    .then(text => {
        console.log('[Admin Chat] Raw response:', text);
        
        try {
            const data = JSON.parse(text);
            console.log('[Admin Chat] Parsed data:', data);
            
            if (data.success) {
                if (data.conversations && Array.isArray(data.conversations)) {
                    console.log('[Admin Chat] Found', data.conversations.length, 'conversations');
                    displayConversations(data.conversations);
                    updateAdminUnreadCount();
                } else {
                    console.error('[Admin Chat] No conversations array in response');
                    container.innerHTML = `
                        <div class="text-center text-yellow-600 py-8">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>${adminChatI18n.noConversations}</p>
                            <p class="text-xs mt-2">${adminChatI18n.messagesWillAppear}</p>
                        </div>
                    `;
                }
            } else {
                console.error('[Admin Chat] API returned success=false');
                container.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                        <p>${adminChatI18n.loadingError}</p>
                        <p class="text-sm">${data.message || adminChatI18n.unknownError}</p>
                    </div>
                `;
            }
        } catch (e) {
            console.error('[Admin Chat] JSON parse error:', e);
            container.innerHTML = `
                <div class="text-center text-red-500 py-8">
                    <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                    <p>${adminChatI18n.formatError}</p>
                    <p class="text-sm">${e.message}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('[Admin Chat] Fetch error:', error);
        container.innerHTML = `
            <div class="text-center text-red-500 py-8">
                <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                <p>${adminChatI18n.connectionError}</p>
                <p class="text-sm">${error.message}</p>
                <button onclick="loadConversations()" class="mt-4 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                    ${adminChatI18n.retry}
                </button>
            </div>
        `;
    });
}

function displayConversations(conversations) {
    console.log('[Admin Chat] Displaying', conversations.length, 'conversations');
    const container = document.getElementById('conversations-list');
    
    if (!conversations || conversations.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p>${adminChatI18n.noConversations}</p>
                <p class="text-xs mt-2 text-gray-400">${adminChatI18n.messagesWillAppear}</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = '';
    
    conversations.forEach((conv, index) => {
        console.log('[Admin Chat] Processing conversation', index, ':', conv);
        
        if (!conv.user) {
            console.error('[Admin Chat] Conversation without user:', conv);
            return;
        }
        
        const user = conv.user;
        const lastMsg = conv.last_message;
        const unreadCount = conv.unread_count || 0;
        
        const convDiv = document.createElement('div');
        convDiv.className = 'p-4 border-b hover:bg-gray-100 cursor-pointer transition-colors';
        convDiv.onclick = () => {
            console.log('[Admin Chat] Opening chat with user', user.id);
            openChat(user.id, user.first_name + ' ' + user.last_name, user.email);
        };
        
        const time = lastMsg && lastMsg.created_at ? new Date(lastMsg.created_at).toLocaleTimeString(adminChatLocale, { hour: '2-digit', minute: '2-digit' }) : '';
        const preview = lastMsg && lastMsg.message ? (lastMsg.message.length > 50 ? lastMsg.message.substring(0, 50) + '...' : lastMsg.message) : adminChatI18n.noMessages;
        
        convDiv.innerHTML = `
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <div class="font-semibold text-gray-800">${escapeHtml(user.first_name + ' ' + user.last_name)}</div>
                        ${unreadCount > 0 ? `<span class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">${unreadCount}</span>` : ''}
                    </div>
                    <div class="text-xs text-gray-500 mb-1">${escapeHtml(user.email)}</div>
                    <div class="text-sm text-gray-600 truncate">${escapeHtml(preview)}</div>
                </div>
                ${time ? `<div class="text-xs text-gray-400 ml-2">${time}</div>` : ''}
            </div>
        `;
        
        container.appendChild(convDiv);
    });
    
    console.log('[Admin Chat] Conversations displayed successfully');
}

function openChat(userId, userName, userEmail) {
    console.log('[Admin Chat] Opening chat with user ID:', userId);
    currentChatUserId = userId;
    document.getElementById('current-user-name').textContent = userName;
    document.getElementById('current-user-email').textContent = userEmail;
    
    document.getElementById('conversations-list').classList.add('hidden');
    document.getElementById('individual-chat').classList.remove('hidden');
    
    loadChatWithUser(userId);
    
    // Start polling for this specific chat
    if (adminChatInterval) {
        clearInterval(adminChatInterval);
    }
    adminChatInterval = setInterval(() => loadChatWithUser(userId), 3000);
}

function backToConversations() {
    console.log('[Admin Chat] Back to conversations list');
    currentChatUserId = null;
    document.getElementById('conversations-list').classList.remove('hidden');
    document.getElementById('individual-chat').classList.add('hidden');
    
    // Resume polling conversations
    if (adminChatInterval) {
        clearInterval(adminChatInterval);
    }
    loadConversations();
    adminChatInterval = setInterval(loadConversations, 5000);
}

function loadChatWithUser(userId) {
    console.log('[Admin Chat] Loading messages with user ID:', userId);
    
    fetch(`/chat/messages/${userId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('[Admin Chat] Messages response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('[Admin Chat] Messages data:', data);
        if (data.success && data.messages) {
            console.log('[Admin Chat] Found', data.messages.length, 'messages');
            displayChatMessages(data.messages);
        } else {
            console.error('[Admin Chat] No messages in response');
        }
    })
    .catch(error => {
        console.error('[Admin Chat] Error loading messages:', error);
    });
}

function displayChatMessages(messages) {
    console.log('[Admin Chat] Displaying', messages.length, 'messages');
    const container = document.getElementById('chat-messages-container');
    const currentUserId = {{ auth()->id() }};
    
    if (!messages || messages.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-400 py-8">
                <i class="fas fa-comments text-4xl mb-3"></i>
                <p>${adminChatI18n.noMessages}</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = '';
    
    messages.forEach((msg, index) => {
        console.log('[Admin Chat] Rendering message', index, ':', msg);
        
        const isAdmin = msg.sender_id === currentUserId;
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-start mb-4 ${isAdmin ? 'justify-end' : ''}`;
        
        const time = new Date(msg.created_at).toLocaleTimeString(adminChatLocale, { hour: '2-digit', minute: '2-digit' });
        
        let attachmentHtml = '';
        if (msg.attachment_path) {
            const isImage = msg.attachment_type && msg.attachment_type.startsWith('image/');
            if (isImage) {
                attachmentHtml = `
                    <button type="button" class="block mt-2 focus:outline-none" data-chat-image="/storage/${msg.attachment_path}">
                        <img src="/storage/${msg.attachment_path}" alt="${escapeHtml(msg.attachment_name)}" class="max-w-full rounded cursor-zoom-in" style="max-height: 200px;">
                    </button>
                `;
            } else {
                attachmentHtml = `
                    <a href="/storage/${msg.attachment_path}" target="_blank" download class="flex items-center gap-2 mt-2 p-2 bg-white bg-opacity-20 rounded hover:bg-opacity-30 transition">
                        <i class="fas fa-file"></i>
                        <span class="text-sm">${escapeHtml(msg.attachment_name)}</span>
                    </a>
                `;
            }
        }
        
        const messageText = msg.message ? escapeHtml(msg.message) : '';
        
        messageDiv.innerHTML = `
            <div class="${isAdmin ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800'} rounded-lg p-3 max-w-xs">
                ${messageText ? `<p class="text-sm">${messageText}</p>` : ''}
                ${attachmentHtml}
                <span class="text-xs ${isAdmin ? 'opacity-75' : 'text-gray-500'} mt-1 block">
                    ${time}
                </span>
            </div>
        `;
        container.appendChild(messageDiv);
        
        if (msg.id > adminLastMessageId) {
            adminLastMessageId = msg.id;
        }
    });
    
    container.scrollTop = container.scrollHeight;
    console.log('[Admin Chat] Messages displayed successfully');
}

let adminChatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };

function clampAdminChatImage(value, min, max) {
    return Math.min(max, Math.max(min, value));
}

function applyAdminChatImageTransform() {
    const image = document.getElementById('admin-chat-image-full');
    const modal = document.getElementById('admin-chat-image-modal');
    if (!image || !modal) return;
    const modalRect = modal.getBoundingClientRect();
    const displayWidth = image.naturalWidth * adminChatImageState.scale;
    const displayHeight = image.naturalHeight * adminChatImageState.scale;
    const maxX = Math.max(0, (displayWidth - modalRect.width) / 2);
    const maxY = Math.max(0, (displayHeight - modalRect.height) / 2);
    adminChatImageState.x = clampAdminChatImage(adminChatImageState.x, -maxX, maxX);
    adminChatImageState.y = clampAdminChatImage(adminChatImageState.y, -maxY, maxY);
    image.style.transform = `translate(${adminChatImageState.x}px, ${adminChatImageState.y}px) scale(${adminChatImageState.scale})`;
}

function openAdminChatImage(src) {
    const modal = document.getElementById('admin-chat-image-modal');
    const image = document.getElementById('admin-chat-image-full');
    const download = document.getElementById('admin-chat-image-download');
    if (!modal || !image) return;
    image.src = src;
    if (download) download.href = src;
    adminChatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
    applyAdminChatImageTransform();
    modal.classList.remove('hidden');
}

function resetAdminChatImage() {
    adminChatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
    applyAdminChatImageTransform();
}

function closeAdminChatImage() {
    const modal = document.getElementById('admin-chat-image-modal');
    const image = document.getElementById('admin-chat-image-full');
    const download = document.getElementById('admin-chat-image-download');
    if (!modal || !image) return;
    image.src = '';
    if (download) download.removeAttribute('href');
    modal.classList.add('hidden');
}

document.getElementById('chat-messages-container')?.addEventListener('click', function (event) {
    const target = event.target.closest('[data-chat-image]');
    if (!target) return;
    openAdminChatImage(target.getAttribute('data-chat-image'));
});

const adminChatImage = document.getElementById('admin-chat-image-full');
const adminChatModal = document.getElementById('admin-chat-image-modal');
if (adminChatImage && adminChatModal) {
    adminChatImage.addEventListener('wheel', function (event) {
        event.preventDefault();
        const delta = event.deltaY < 0 ? 1.1 : 0.9;
        adminChatImageState.scale = Math.min(4, Math.max(1, adminChatImageState.scale * delta));
        applyAdminChatImageTransform();
    });
    adminChatImage.addEventListener('mousedown', function (event) {
        adminChatImageState.dragging = true;
        adminChatImageState.startX = event.clientX - adminChatImageState.x;
        adminChatImageState.startY = event.clientY - adminChatImageState.y;
        adminChatImage.style.cursor = 'grabbing';
    });
    adminChatModal.addEventListener('mousemove', function (event) {
        if (!adminChatImageState.dragging) return;
        adminChatImageState.x = event.clientX - adminChatImageState.startX;
        adminChatImageState.y = event.clientY - adminChatImageState.startY;
        applyAdminChatImageTransform();
    });
    adminChatModal.addEventListener('mouseup', function () {
        adminChatImageState.dragging = false;
        adminChatImage.style.cursor = 'grab';
    });
    adminChatModal.addEventListener('mouseleave', function () {
        adminChatImageState.dragging = false;
        adminChatImage.style.cursor = 'grab';
    });
    adminChatImage.addEventListener('load', function () {
        applyAdminChatImageTransform();
    });
}

function sendAdminMessage() {
    if (!currentChatUserId) {
        console.error('[Admin Chat] No user selected');
        return;
    }
    
    const input = document.getElementById('admin-chat-input');
    const message = input.value.trim();
    
    if (message === '') {
        console.log('[Admin Chat] Empty message, not sending');
        return;
    }
    
    console.log('[Admin Chat] Sending message to user', currentChatUserId, ':', message);
    input.disabled = true;
    
    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify({ 
            message: message,
            receiver_id: currentChatUserId
        })
    })
    .then(response => {
        console.log('[Admin Chat] Send response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('[Admin Chat] Send response data:', data);
        if (data.success) {
            input.value = '';
            loadChatWithUser(currentChatUserId);
        } else {
            console.error('[Admin Chat] Failed to send message:', data);
            alert(adminChatI18n.sendError);
        }
    })
    .catch(error => {
        console.error('[Admin Chat] Error sending message:', error);
        alert(adminChatI18n.connectionError);
    })
    .finally(() => {
        input.disabled = false;
        input.focus();
    });
}

function updateAdminUnreadCount() {
    fetch('/chat/unread-count', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('admin-unread-badge');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    })
    .catch(error => console.error('[Admin Chat] Error updating unread count:', error));
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Update unread count every 10 seconds
setInterval(updateAdminUnreadCount, 10000);
updateAdminUnreadCount();

console.log('[Admin Chat] Widget initialized');
</script>

<div id="admin-chat-image-modal" class="hidden fixed inset-0 z-[9999] bg-black/80 flex items-center justify-center p-4">
    <button type="button" class="absolute top-4 right-4 text-white text-2xl" onclick="closeAdminChatImage()">×</button>
    <a id="admin-chat-image-download" class="absolute top-4 left-4 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" download>Tlcharger</a>
    <button type="button" class="absolute top-4 left-32 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" onclick="resetAdminChatImage()">Rinitialiser</button>
    <img id="admin-chat-image-full" src="" alt="{{ __('chat.image_preview_alt') }}" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl cursor-grab" style="transform: translate(0,0) scale(1);">
</div>

