{{-- Admin Chat Widget V2 - Clean Version --}}
<div id="admin-chat-widget-v2" class="fixed bottom-4 right-4 z-50">
    {{-- Unread badge --}}
    <span id="admin-unread-badge-v2" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">0</span>
    
    {{-- Chat button --}}
    <button 
        id="admin-chat-toggle-v2" 
        class="bg-purple-600 hover:bg-purple-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center relative"
        onclick="toggleAdminChatV2()"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
        </svg>
    </button>

    {{-- Chat window --}}
    <div 
        id="admin-chat-window-v2" 
        class="hidden absolute bottom-16 right-0 w-96 bg-white rounded-lg shadow-2xl overflow-hidden"
        style="max-height: 600px;"
    >
        {{-- Chat header --}}
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold">Messages Clients</h3>
                <p class="text-xs opacity-90">Gérer les conversations</p>
            </div>
            <button onclick="toggleAdminChatV2()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Conversations list or chat view --}}
        <div id="admin-chat-view-v2">
            {{-- Conversations list --}}
            <div id="conversations-list-v2" class="h-96 overflow-y-auto bg-gray-50">
                <div class="text-center text-gray-500 text-sm py-4">
                    <i class="fas fa-spinner fa-spin"></i> Chargement des conversations...
                </div>
            </div>

            {{-- Individual chat view --}}
            <div id="individual-chat-v2" class="hidden">
                <div class="bg-gray-100 p-3 flex items-center border-b">
                    <button onclick="backToConversationsV2()" class="mr-3 text-gray-600 hover:text-gray-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <div>
                        <div id="current-user-name-v2" class="font-semibold text-gray-800"></div>
                        <div id="current-user-email-v2" class="text-xs text-gray-500"></div>
                    </div>
                </div>
                
                <div id="chat-messages-container-v2" class="p-4 h-80 overflow-y-auto bg-white">
                    <!-- Messages will be loaded here -->
                </div>
                
                <div class="p-4 bg-white border-t">
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            id="admin-chat-input-v2"
                            placeholder="Répondre au client..." 
                            class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                            onkeypress="if(event.key === 'Enter') sendAdminMessageV2()"
                        >
                        <button 
                            onclick="sendAdminMessageV2()"
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
// Admin Chat Widget V2 - Isolated namespace
(function() {
    let adminChatIntervalV2 = null;
    let currentChatUserIdV2 = null;
    const currentAdminId = {{ auth()->id() }};

    window.toggleAdminChatV2 = function() {
        const chatWindow = document.getElementById('admin-chat-window-v2');
        const isHidden = chatWindow.classList.contains('hidden');
        
        chatWindow.classList.toggle('hidden');
        
        if (isHidden) {
            loadConversationsV2();
            adminChatIntervalV2 = setInterval(loadConversationsV2, 5000);
        } else {
            if (adminChatIntervalV2) {
                clearInterval(adminChatIntervalV2);
                adminChatIntervalV2 = null;
            }
            backToConversationsV2();
        }
    };

    function loadConversationsV2() {
        fetch('/chat/messages', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.conversations) {
                displayConversationsV2(data.conversations);
                updateAdminUnreadCountV2();
            }
        })
        .catch(error => {
            console.error('[ChatV2] Error loading conversations:', error);
            const container = document.getElementById('conversations-list-v2');
            container.innerHTML = `
                <div class="text-center text-red-500 py-8">
                    <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                    <p>Erreur de chargement</p>
                </div>
            `;
        });
    }

    function displayConversationsV2(conversations) {
        const container = document.getElementById('conversations-list-v2');
        
        if (!conversations || conversations.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p>Aucune conversation</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = '';
        
        conversations.forEach(conv => {
            if (!conv || !conv.user) return;
            
            const user = conv.user;
            const lastMsg = conv.last_message;
            const unreadCount = conv.unread_count || 0;
            
            const firstName = user.first_name || '';
            const lastName = user.last_name || '';
            const email = user.email || '';
            const userId = user.id;
            
            if (!userId) return;
            
            const convDiv = document.createElement('div');
            convDiv.className = 'p-4 border-b hover:bg-gray-100 cursor-pointer transition-colors';
            convDiv.onclick = () => openChatV2(userId, firstName + ' ' + lastName, email);
            
            const time = lastMsg && lastMsg.created_at ? new Date(lastMsg.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }) : '';
            const messageText = lastMsg && lastMsg.message ? lastMsg.message : 'Aucun message';
            const preview = messageText.length > 50 ? messageText.substring(0, 50) + '...' : messageText;
            
            convDiv.innerHTML = `
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <div class="font-semibold text-gray-800">${escapeHtmlV2(firstName + ' ' + lastName)}</div>
                            ${unreadCount > 0 ? `<span class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">${unreadCount}</span>` : ''}
                        </div>
                        <div class="text-xs text-gray-500 mb-1">${escapeHtmlV2(email)}</div>
                        <div class="text-sm text-gray-600 truncate">${escapeHtmlV2(preview)}</div>
                    </div>
                    ${time ? `<div class="text-xs text-gray-400 ml-2">${time}</div>` : ''}
                </div>
            `;
            
            container.appendChild(convDiv);
        });
    }

    function openChatV2(userId, userName, userEmail) {
        if (!userId) return;
        
        currentChatUserIdV2 = userId;
        
        const nameElement = document.getElementById('current-user-name-v2');
        const emailElement = document.getElementById('current-user-email-v2');
        
        if (nameElement) nameElement.textContent = userName || 'Utilisateur';
        if (emailElement) emailElement.textContent = userEmail || '';
        
        const conversationsList = document.getElementById('conversations-list-v2');
        const individualChat = document.getElementById('individual-chat-v2');
        
        if (conversationsList) conversationsList.classList.add('hidden');
        if (individualChat) individualChat.classList.remove('hidden');
        
        loadChatWithUserV2(userId);
        
        if (adminChatIntervalV2) {
            clearInterval(adminChatIntervalV2);
        }
        adminChatIntervalV2 = setInterval(() => loadChatWithUserV2(userId), 3000);
    }

    window.backToConversationsV2 = function() {
        currentChatUserIdV2 = null;
        document.getElementById('conversations-list-v2').classList.remove('hidden');
        document.getElementById('individual-chat-v2').classList.add('hidden');
        
        if (adminChatIntervalV2) {
            clearInterval(adminChatIntervalV2);
        }
        loadConversationsV2();
        adminChatIntervalV2 = setInterval(loadConversationsV2, 5000);
    };

    function loadChatWithUserV2(userId) {
        if (!userId) return;
        
        fetch(`/chat/messages/${userId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.messages) {
                displayChatMessagesV2(data.messages);
            }
        })
        .catch(error => {
            console.error('[ChatV2] Error loading chat:', error);
        });
    }

    function displayChatMessagesV2(messages) {
        const container = document.getElementById('chat-messages-container-v2');
        
        if (!container) return;
        
        if (!messages || messages.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-comments text-4xl mb-3"></i>
                    <p>Aucun message</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = '';
        
        messages.forEach(msg => {
            if (!msg) return;
            
            const isAdmin = msg.sender_id === currentAdminId;
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex items-start mb-4 ${isAdmin ? 'justify-end' : ''}`;
            
            const time = msg.created_at ? new Date(msg.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }) : '';
            const messageText = msg.message || '';
            
            messageDiv.innerHTML = `
                <div class="${isAdmin ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800'} rounded-lg p-3 max-w-xs">
                    ${messageText ? `<p class="text-sm">${escapeHtmlV2(messageText)}</p>` : ''}
                    <span class="text-xs ${isAdmin ? 'opacity-75' : 'text-gray-500'} mt-1 block">
                        ${time}
                    </span>
                </div>
            `;
            container.appendChild(messageDiv);
        });
        
        container.scrollTop = container.scrollHeight;
    }

    window.sendAdminMessageV2 = function() {
        if (!currentChatUserIdV2) return;
        
        const input = document.getElementById('admin-chat-input-v2');
        const message = input.value.trim();
        
        if (message === '') return;
        
        input.disabled = true;
        
        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ 
                message: message,
                receiver_id: currentChatUserIdV2
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                loadChatWithUserV2(currentChatUserIdV2);
            }
        })
        .catch(error => console.error('[ChatV2] Error sending message:', error))
        .finally(() => {
            input.disabled = false;
            input.focus();
        });
    };

    function updateAdminUnreadCountV2() {
        fetch('/chat/unread-count', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const badge = document.getElementById('admin-unread-badge-v2');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        })
        .catch(error => console.error('[ChatV2] Error updating unread count:', error));
    }

    function escapeHtmlV2(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Update unread count every 10 seconds
    setInterval(updateAdminUnreadCountV2, 10000);
    updateAdminUnreadCountV2();
})();
</script>


