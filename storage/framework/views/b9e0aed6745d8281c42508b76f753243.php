
<?php
    $adminChatI18n = [
        'loadingError' => __('admin_chat.loading_error'),
        'noConversations' => __('admin_chat.no_conversations'),
        'noMessages' => __('admin_chat.no_messages'),
        'loadingMessagesError' => __('admin_chat.loading_messages_error'),
        'errorPrefix' => __('admin_chat.error_prefix'),
        'startConversation' => __('admin_chat.start_conversation'),
        'userFallback' => __('admin_chat.user_fallback'),
        'online' => __('admin_chat.online'),
        'connected' => __('admin_chat.connected'),
        'disconnected' => __('admin_chat.disconnected'),
    ];
?>
<div id="admin-chat-widget" class="fixed bottom-4 right-4 z-50">
    
    <span id="admin-unread-badge" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">0</span>
    
    
    <button 
        id="admin-chat-toggle" 
        class="bg-purple-600 hover:bg-purple-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center relative"
        onclick="toggleAdminChat()"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
        </svg>
    </button>


    
    <div 
        id="admin-chat-window" 
        class="hidden absolute bottom-16 right-0 w-96 bg-white rounded-lg shadow-2xl overflow-hidden"
        style="max-height: 600px;"
    >
        
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold"><?php echo e(__('admin_chat.title')); ?></h3>
                <p class="text-xs opacity-90"><?php echo e(__('admin_chat.subtitle')); ?></p>
            </div>
            <button onclick="toggleAdminChat()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        
        <div id="admin-chat-view">
            
            <div id="conversations-list" class="h-96 overflow-y-auto bg-gray-50">
                <div class="text-center text-gray-500 text-sm py-4">
                    <i class="fas fa-spinner fa-spin"></i> <?php echo e(__('admin_chat.loading_conversations')); ?>

                </div>
            </div>

            
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
                        <div id="current-user-status" class="text-[11px] font-medium"></div>
                    </div>
                </div>
                
                <div id="chat-messages-container" class="p-4 h-80 overflow-y-auto bg-white">
                    <!-- Messages will be loaded here -->
                </div>
                
                <div class="p-4 bg-white border-t">
                    <div class="flex gap-2 items-center">
                        <input
                            type="text"
                            id="admin-chat-input"
                            placeholder="<?php echo e(__('admin_chat.reply_placeholder')); ?>"
                            class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                            onkeypress="if(event.key === 'Enter') sendAdminMessage()"
                        />
                        <input
                            type="file"
                            id="admin-chat-file"
                            accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip"
                            class="hidden"
                            onchange="updateFileLabel()"
                        />
                        <label for="admin-chat-file" class="cursor-pointer bg-gray-300 hover:bg-gray-400 rounded-lg p-2 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v-8a2 2 0 012-2h6l4 4v6a2 2 0 01-2 2H6a2 2 0 01-2-2z"></path>
                            </svg>
                        </label>
                        <span id="file-name" class="text-sm text-gray-500 max-w-32 truncate"></span>
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
const adminChatLocale = document.documentElement.lang || '<?php echo e(app()->getLocale()); ?>';
const adminChatI18n = <?php echo json_encode($adminChatI18n, 15, 512) ?>;
const adminPresenceLabels = {
    online: adminChatI18n.online,
    connected: adminChatI18n.connected,
    disconnected: adminChatI18n.disconnected,
};

function normalizePresenceStatus(status) {
    return ['online', 'connected', 'disconnected'].includes(status) ? status : 'disconnected';
}

function resolvePresenceStatus(user) {
    if (user && user.presence_status) {
        return normalizePresenceStatus(user.presence_status);
    }
    if (user && user.is_online) {
        return 'online';
    }
    if (user && user.is_connected) {
        return 'connected';
    }
    return 'disconnected';
}

function presenceDotClass(status) {
    switch (status) {
        case 'online':
            return 'bg-green-500';
        case 'connected':
            return 'bg-amber-500';
        default:
            return 'bg-gray-400';
    }
}

function presenceTextClass(status) {
    switch (status) {
        case 'online':
            return 'text-green-600';
        case 'connected':
            return 'text-amber-600';
        default:
            return 'text-gray-500';
    }
}

function setCurrentUserPresence(status) {
    const statusElement = document.getElementById('current-user-status');
    if (!statusElement) return;
    const safeStatus = normalizePresenceStatus(status);
    statusElement.textContent = adminPresenceLabels[safeStatus];
    statusElement.className = `text-[11px] font-medium ${presenceTextClass(safeStatus)}`;
}

function toggleAdminChat() {
    const chatWindow = document.getElementById('admin-chat-window');
    const isHidden = chatWindow.classList.contains('hidden');
    
    chatWindow.classList.toggle('hidden');
    
    if (isHidden) {
        // Chat opened - load conversations
        loadConversations();
        // Start polling for new messages
        adminChatInterval = setInterval(loadConversations, 5000);
    } else {
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
    console.log('Loading conversations...');
    fetch('/chat/messages', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Data received:', data);
        if (data.success && data.conversations) {
            console.log('Conversations found:', data.conversations.length);
            displayConversations(data.conversations);
            updateAdminUnreadCount();
        } else {
            console.error('No conversations in response or success=false');
        }
    })
    .catch(error => {
        console.error('Error loading conversations:', error);
        const container = document.getElementById('conversations-list');
        container.innerHTML = `
            <div class="text-center text-red-500 py-8">
                <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                <p>${adminChatI18n.loadingError}</p>
                <p class="text-sm">${error.message}</p>
            </div>
        `;
    });
}

function displayConversations(conversations) {
    const container = document.getElementById('conversations-list');
    
    if (!conversations || conversations.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p>${adminChatI18n.noConversations}</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = '';
    
    conversations.forEach(conv => {
        // Validate conversation data
        if (!conv || !conv.user) {
            console.warn('Invalid conversation data:', conv);
            return;
        }
        
        const user = conv.user;
        const lastMsg = conv.last_message;
        const unreadCount = conv.unread_count || 0;
        
        // Ensure user has required fields
        const firstName = user.first_name || '';
        const lastName = user.last_name || '';
        const email = user.email || '';
        const userId = user.id;
        const presenceStatus = resolvePresenceStatus(user);
        
        if (!userId) {
            console.warn('User ID missing in conversation:', conv);
            return;
        }
        
        const convDiv = document.createElement('div');
        convDiv.className = 'p-4 border-b hover:bg-gray-100 cursor-pointer transition-colors';
        convDiv.onclick = () => openChat(userId, firstName + ' ' + lastName, email, presenceStatus);
        
        const time = lastMsg && lastMsg.created_at ? new Date(lastMsg.created_at).toLocaleTimeString(adminChatLocale, { hour: '2-digit', minute: '2-digit' }) : '';
        const messageText = lastMsg && lastMsg.message ? lastMsg.message : adminChatI18n.noMessages;
        const preview = messageText.length > 50 ? messageText.substring(0, 50) + '...' : messageText;
        
        convDiv.innerHTML = `
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center">
                            <div class="font-semibold text-gray-800">${escapeHtml(firstName + ' ' + lastName)}</div>
                            <div class="w-2 h-2 rounded-full ml-2 ${presenceDotClass(presenceStatus)}" title="${escapeHtml(adminPresenceLabels[presenceStatus])}"></div>
                        </div>
                        ${unreadCount > 0 ? `<span class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">${unreadCount}</span>` : ''}
                    </div>
                    <div class="text-xs text-gray-500 mb-1">${escapeHtml(email)}</div>
                    <div class="text-[11px] font-medium ${presenceTextClass(presenceStatus)} mb-1">${escapeHtml(adminPresenceLabels[presenceStatus])}</div>
                    <div class="text-sm text-gray-600 truncate">${escapeHtml(preview)}</div>
                </div>
                ${time ? `<div class="text-xs text-gray-400 ml-2">${time}</div>` : ''}
            </div>
        `;
        
        container.appendChild(convDiv);
    });
}

function openChat(userId, userName, userEmail, presenceStatus = 'disconnected') {
    console.log('Opening chat with user:', userId, userName, userEmail);
    
    if (!userId) {
        console.error('Cannot open chat: userId is missing');
        return;
    }
    
    currentChatUserId = userId;
    
    // Update user info in header
    const nameElement = document.getElementById('current-user-name');
    const emailElement = document.getElementById('current-user-email');
    
    if (nameElement) nameElement.textContent = userName || adminChatI18n.userFallback;
    if (emailElement) emailElement.textContent = userEmail || '';
    setCurrentUserPresence(presenceStatus);
    
    // Switch views
    const conversationsList = document.getElementById('conversations-list');
    const individualChat = document.getElementById('individual-chat');
    
    if (conversationsList) conversationsList.classList.add('hidden');
    if (individualChat) individualChat.classList.remove('hidden');
    
    // Load messages for this user
    loadChatWithUser(userId);
    
    // Start polling for this specific chat
    if (adminChatInterval) {
        clearInterval(adminChatInterval);
    }
    adminChatInterval = setInterval(() => loadChatWithUser(userId), 3000);
}

function backToConversations() {
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
    if (!userId) {
        console.error('Cannot load chat: userId is missing');
        return;
    }
    
    console.log('Loading chat with user:', userId);
    
    fetch(`/chat/messages/${userId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        console.log('Chat response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Chat data received:', data);
        if (data.success) {
            if (data.user_presence) {
                setCurrentUserPresence(resolvePresenceStatus(data.user_presence));
            }

            if (data.messages) {
                displayChatMessages(data.messages);
            } else {
                console.error('Invalid chat data structure:', data);
                const container = document.getElementById('chat-messages-container');
                if (container) {
                    container.innerHTML = `
                        <div class="text-center text-red-500 py-8">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>${adminChatI18n.loadingMessagesError}</p>
                        </div>
                    `;
                }
            }
        } else {
            console.error('Invalid chat data structure:', data);
            const container = document.getElementById('chat-messages-container');
            if (container) {
                container.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                        <p>${adminChatI18n.loadingMessagesError}</p>
                    </div>
                `;
            }
        }
    })
    .catch(error => {
        console.error('Error loading chat:', error);
        const container = document.getElementById('chat-messages-container');
        if (container) {
            container.innerHTML = `
                <div class="text-center text-red-500 py-8">
                    <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>${adminChatI18n.errorPrefix.replace(':message', error.message)}</p>
                </div>
            `;
        }
    });
}

function displayChatMessages(messages) {
    const container = document.getElementById('chat-messages-container');
    const currentUserId = <?php echo e(auth()->id()); ?>;

    // Debug: log all messages to see attachment info
    console.log('Messages received for display:', messages);
    
    if (!container) {
        console.error('Chat messages container not found');
        return;
    }
    
    if (!messages || messages.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i class="fas fa-comments text-4xl mb-3"></i>
                <p>${adminChatI18n.noMessages}</p>
                <p class="text-sm mt-2">${adminChatI18n.startConversation}</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = '';
    
    messages.forEach(msg => {
        if (!msg) {
            console.warn('Invalid message object:', msg);
            return;
        }
        
        const isAdmin = msg.sender_id === currentUserId;
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-start mb-4 ${isAdmin ? 'justify-end' : ''}`;
        
        const time = msg.created_at ? new Date(msg.created_at).toLocaleTimeString(adminChatLocale, { hour: '2-digit', minute: '2-digit' }) : '';
        
        let attachmentHtml = '';
        if (msg.attachment_path) {
            const isImage = msg.attachment_type && msg.attachment_type.startsWith('image/');
            const attachmentName = msg.attachment_name || 'Fichier';

            // Debug: show attachment info
            console.log(`Attachment found: ${attachmentName}, path: ${msg.attachment_path}`);

            if (isImage) {
                attachmentHtml = `
                    <button type="button" class="block mt-2 focus:outline-none" data-chat-image="/storage/${msg.attachment_path}">
                        <img src="/storage/${msg.attachment_path}" alt="${escapeHtml(attachmentName)}" class="max-w-full rounded cursor-zoom-in" style="max-height: 200px;">
                    </button>
                `;
            } else {
                attachmentHtml = `
                    <a href="/storage/${msg.attachment_path}" target="_blank" download class="flex items-center gap-2 mt-2 p-2 bg-white bg-opacity-20 rounded hover:bg-opacity-30 transition">
                        <i class="fas fa-file"></i>
                        <span class="text-sm">${escapeHtml(attachmentName)}</span>
                    </a>
                `;
            }
        }
        
        const messageText = msg.message || '';
        
        messageDiv.innerHTML = `
            <div class="${isAdmin ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800'} rounded-lg p-3 max-w-xs">
                ${messageText ? `<p class="text-sm">${escapeHtml(messageText)}</p>` : ''}
                ${attachmentHtml}
                <span class="text-xs ${isAdmin ? 'opacity-75' : 'text-gray-500'} mt-1 block">
                    ${time}
                </span>
            </div>
        `;
        container.appendChild(messageDiv);
        
        if (msg.id && msg.id > adminLastMessageId) {
            adminLastMessageId = msg.id;
        }
    });
    
    // Scroll to bottom
    container.scrollTop = container.scrollHeight;
}

let adminChatImageStateLegacy = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };

function clampAdminChatImageLegacy(value, min, max) {
    return Math.min(max, Math.max(min, value));
}

function applyAdminChatImageTransformLegacy() {
    const image = document.getElementById('admin-chat-image-full-legacy');
    const modal = document.getElementById('admin-chat-image-modal-legacy');
    if (!image || !modal) return;
    const modalRect = modal.getBoundingClientRect();
    const displayWidth = image.naturalWidth * adminChatImageStateLegacy.scale;
    const displayHeight = image.naturalHeight * adminChatImageStateLegacy.scale;
    const maxX = Math.max(0, (displayWidth - modalRect.width) / 2);
    const maxY = Math.max(0, (displayHeight - modalRect.height) / 2);
    adminChatImageStateLegacy.x = clampAdminChatImageLegacy(adminChatImageStateLegacy.x, -maxX, maxX);
    adminChatImageStateLegacy.y = clampAdminChatImageLegacy(adminChatImageStateLegacy.y, -maxY, maxY);
    image.style.transform = `translate(${adminChatImageStateLegacy.x}px, ${adminChatImageStateLegacy.y}px) scale(${adminChatImageStateLegacy.scale})`;
}

function openAdminChatImageLegacy(src) {
    const modal = document.getElementById('admin-chat-image-modal-legacy');
    const image = document.getElementById('admin-chat-image-full-legacy');
    const download = document.getElementById('admin-chat-image-download-legacy');
    if (!modal || !image) return;
    image.src = src;
    if (download) download.href = src;
    adminChatImageStateLegacy = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
    applyAdminChatImageTransformLegacy();
    modal.classList.remove('hidden');
}

function closeAdminChatImageLegacy() {
    const modal = document.getElementById('admin-chat-image-modal-legacy');
    const image = document.getElementById('admin-chat-image-full-legacy');
    const download = document.getElementById('admin-chat-image-download-legacy');
    if (!modal || !image) return;
    image.src = '';
    if (download) download.removeAttribute('href');
    modal.classList.add('hidden');
}

function resetAdminChatImageLegacy() {
    adminChatImageStateLegacy = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
    applyAdminChatImageTransformLegacy();
}

document.getElementById('chat-messages-container')?.addEventListener('click', function (event) {
    const target = event.target.closest('[data-chat-image]');
    if (!target) return;
    openAdminChatImageLegacy(target.getAttribute('data-chat-image'));
});

const adminChatImageLegacy = document.getElementById('admin-chat-image-full-legacy');
const adminChatModalLegacy = document.getElementById('admin-chat-image-modal-legacy');
if (adminChatImageLegacy && adminChatModalLegacy) {
    adminChatImageLegacy.addEventListener('wheel', function (event) {
        event.preventDefault();
        const delta = event.deltaY < 0 ? 1.1 : 0.9;
        adminChatImageStateLegacy.scale = Math.min(4, Math.max(1, adminChatImageStateLegacy.scale * delta));
        applyAdminChatImageTransformLegacy();
    });
    adminChatImageLegacy.addEventListener('mousedown', function (event) {
        adminChatImageStateLegacy.dragging = true;
        adminChatImageStateLegacy.startX = event.clientX - adminChatImageStateLegacy.x;
        adminChatImageStateLegacy.startY = event.clientY - adminChatImageStateLegacy.y;
        adminChatImageLegacy.style.cursor = 'grabbing';
    });
    adminChatModalLegacy.addEventListener('mousemove', function (event) {
        if (!adminChatImageStateLegacy.dragging) return;
        adminChatImageStateLegacy.x = event.clientX - adminChatImageStateLegacy.startX;
        adminChatImageStateLegacy.y = event.clientY - adminChatImageStateLegacy.startY;
        applyAdminChatImageTransformLegacy();
    });
    adminChatModalLegacy.addEventListener('mouseup', function () {
        adminChatImageStateLegacy.dragging = false;
        adminChatImageLegacy.style.cursor = 'grab';
    });
    adminChatModalLegacy.addEventListener('mouseleave', function () {
        adminChatImageStateLegacy.dragging = false;
        adminChatImageLegacy.style.cursor = 'grab';
    });
    adminChatImageLegacy.addEventListener('load', function () {
        applyAdminChatImageTransformLegacy();
    });
}

function updateFileLabel() {
    const fileInput = document.getElementById('admin-chat-file');
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        // Optionally show selected file name in UI
        console.log('File selected:', fileName);
    }
}

async function sendAdminMessage() {
    if (!currentChatUserId) return;

    const input = document.getElementById('admin-chat-input');
    const fileInput = document.getElementById('admin-chat-file');
    const message = input.value.trim();
    const file = fileInput.files[0];

    if (message === '' && !file) return;

    input.disabled = true;

    const formData = new FormData();
    formData.append('receiver_id', currentChatUserId);
    if (message !== '') {
        formData.append('message', message);
    }
    if (file) {
        formData.append('attachment', file);
    }

    try {
        const response = await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json',
            },
            body: formData,
        });
        const data = await response.json();
        if (data.success) {
            input.value = '';
            fileInput.value = '';
            loadChatWithUser(currentChatUserId);
        } else {
            console.error('Failed to send message:', data.message);
        }
    } catch (error) {
        console.error('Error sending message:', error);
    } finally {
        input.disabled = false;
        input.focus();
    }
}

function updateAdminUnreadCount() {
    fetch('/chat/unread-count', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
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
    .catch(error => console.error('Error updating unread count:', error));
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Update unread count every 10 seconds
setInterval(updateAdminUnreadCount, 10000);
updateAdminUnreadCount();
</script>

<div id="admin-chat-image-modal-legacy" class="hidden fixed inset-0 z-[9999] bg-black/80 flex items-center justify-center p-4">
    <button type="button" class="absolute top-4 right-4 text-white text-2xl" onclick="closeAdminChatImageLegacy()">×</button>
    <a id="admin-chat-image-download-legacy" class="absolute top-4 left-4 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" download>Tlcharger</a>
    <button type="button" class="absolute top-4 left-32 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" onclick="resetAdminChatImageLegacy()">Rinitialiser</button>
    <img id="admin-chat-image-full-legacy" src="" alt="<?php echo e(__('chat.image_preview_alt')); ?>" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl cursor-grab" style="transform: translate(0,0) scale(1);">
</div>



<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/admin-chat-widget.blade.php ENDPATH**/ ?>