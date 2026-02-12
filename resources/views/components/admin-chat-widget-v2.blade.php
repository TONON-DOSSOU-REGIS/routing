{{-- Admin Chat Widget V2 - Clean Version --}}
@php
    $adminChatV2I18n = [
        'loadingError' => __('admin_chat.loading_error'),
        'noConversations' => __('admin_chat.no_conversations'),
        'noMessages' => __('admin_chat.no_messages'),
        'loadingMessagesError' => __('admin_chat.loading_messages_error'),
        'connectionError' => __('admin_chat.connection_error'),
        'startConversation' => __('admin_chat.start_conversation'),
        'userFallback' => __('admin_chat.user_fallback'),
        'online' => __('admin_chat.online'),
    ];
@endphp
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
                <h3 class="font-bold">{{ __('admin_chat.title') }}</h3>
                <p class="text-xs opacity-90">{{ __('admin_chat.subtitle') }}</p>
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
                    <i class="fas fa-spinner fa-spin"></i> {{ __('admin_chat.loading_conversations') }}
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
                
                {{-- File preview area --}}
                <div id="admin-file-preview-v2" class="hidden px-4 py-2 bg-gray-100 border-t">
                    <div class="flex items-center justify-between bg-white p-2 rounded">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file text-blue-600"></i>
                            <span id="admin-file-name-v2" class="text-sm text-gray-700"></span>
                            <span id="admin-file-size-v2" class="text-xs text-gray-500"></span>
                        </div>
                        <button onclick="removeAdminFileV2()" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4 bg-white border-t">
                    <form id="admin-chat-form-v2" enctype="multipart/form-data">
                        <div class="flex gap-2 items-end">
                            {{-- File input (hidden) --}}
                            <input type="file" id="admin-file-input-v2" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip" onchange="handleAdminFileSelectV2(event)">

                            {{-- Attach button --}}
                            <button
                                type="button"
                                onclick="document.getElementById('admin-file-input-v2').click()"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg px-3 py-2 transition-colors"
                                title="Joindre un fichier"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                            </button>

                            {{-- Text input --}}
                            <input
                                type="text"
                                id="admin-chat-input-v2"
                                placeholder="{{ __('admin_chat.reply_placeholder') }}"
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                                onkeypress="if(event.key === 'Enter') { event.preventDefault(); sendAdminMessageV2(); }"
                            >

                            {{-- Send button --}}
                            <button
                                type="button"
                                onclick="sendAdminMessageV2()"
                                class="bg-purple-600 hover:bg-purple-700 text-white rounded-lg px-4 py-2 transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
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
    let selectedAdminFileV2 = null;
    const currentAdminId = {{ auth()->id() }};
    const adminChatLocale = document.documentElement.lang || '{{ app()->getLocale() }}';
    const adminChatI18n = @json($adminChatV2I18n);

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
        fetch('{{ route("chat.messages") }}', {
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
                    <p>${adminChatI18n.loadingError}</p>
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
                    <p>${adminChatI18n.noConversations}</p>
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
            
            const time = lastMsg && lastMsg.created_at ? new Date(lastMsg.created_at).toLocaleTimeString(adminChatLocale, { hour: '2-digit', minute: '2-digit' }) : '';
            const messageText = lastMsg && lastMsg.message ? lastMsg.message : adminChatI18n.noMessages;
            const preview = messageText.length > 50 ? messageText.substring(0, 50) + '...' : messageText;
            
            const onlineIndicator = user.is_online
                ? `<div class="w-2 h-2 bg-green-500 rounded-full ml-2" title="${adminChatI18n.online}"></div>`
                : '';

            convDiv.innerHTML = `
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center">
                                <div class="font-semibold text-gray-800">${escapeHtmlV2(firstName + ' ' + lastName)}</div>
                                ${onlineIndicator}
                            </div>
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
        
        if (nameElement) nameElement.textContent = userName || adminChatI18n.userFallback;
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
        if (!userId) {
            console.error('[ChatV2] No userId provided to loadChatWithUserV2');
            return;
        }
        
        console.log('[ChatV2] Loading chat with user:', userId);
        
        fetch('{{ route("chat.messages") }}/' + userId, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            console.log('[ChatV2] Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('[ChatV2] Response data:', data);
            
            if (data.success) {
                if (data.messages && Array.isArray(data.messages)) {
                    console.log('[ChatV2] Messages count:', data.messages.length);
                    displayChatMessagesV2(data.messages);
                } else {
                    console.warn('[ChatV2] No messages array in response');
                    displayChatMessagesV2([]);
                }
            } else {
                console.error('[ChatV2] API returned success=false');
                const container = document.getElementById('chat-messages-container-v2');
                if (container) {
                    container.innerHTML = `
                        <div class="text-center text-red-500 py-8">
                            <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                            <p>${adminChatI18n.loadingMessagesError}</p>
                        </div>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('[ChatV2] Error loading chat:', error);
            const container = document.getElementById('chat-messages-container-v2');
            if (container) {
                container.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                        <p>${adminChatI18n.connectionError}</p>
                        <p class="text-xs mt-2">${error.message}</p>
                    </div>
                `;
            }
        });
    }

    function displayChatMessagesV2(messages) {
        console.log('[ChatV2] displayChatMessagesV2 called with:', messages);
        
        const container = document.getElementById('chat-messages-container-v2');
        
        if (!container) {
            console.error('[ChatV2] Container not found: chat-messages-container-v2');
            return;
        }
        
        if (!messages || !Array.isArray(messages) || messages.length === 0) {
            console.log('[ChatV2] No messages to display');
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-comments text-4xl mb-3"></i>
                    <p>${adminChatI18n.noMessages}</p>
                    <p class="text-xs mt-2">${adminChatI18n.startConversation}</p>
                </div>
            `;
            return;
        }
        
        console.log('[ChatV2] Displaying', messages.length, 'messages');
        container.innerHTML = '';
        
        messages.forEach((msg, index) => {
            if (!msg) {
                console.warn('[ChatV2] Skipping null message at index', index);
                return;
            }
            
            console.log('[ChatV2] Processing message:', msg);
            
            const isAdmin = msg.sender_id === currentAdminId;
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex items-start mb-4 ${isAdmin ? 'justify-end' : ''}`;
            
            const time = msg.created_at ? new Date(msg.created_at).toLocaleTimeString(adminChatLocale, { hour: '2-digit', minute: '2-digit' }) : '';
            const messageText = msg.message || '';
            
            // Handle attachments if present
            let attachmentHtml = '';
            if (msg.attachment_path) {
                const attachmentUrl = msg.attachment_url || `{{ url('/storage') }}/${msg.attachment_path}`;
                const attachmentName = msg.attachment_name || 'Fichier';
                
                if (msg.attachment_type && msg.attachment_type.startsWith('image/')) {
                    attachmentHtml = `
                        <div class="mt-2">
                            <button type="button" class="block focus:outline-none" data-chat-image="${attachmentUrl}">
                                <img src="${attachmentUrl}" alt="${escapeHtmlV2(attachmentName)}" class="max-w-full rounded-lg cursor-zoom-in" style="max-height: 200px;">
                            </button>
                        </div>
                    `;
                } else {
                    attachmentHtml = `
                        <div class="mt-2">
                            <a href="${attachmentUrl}" target="_blank" class="flex items-center text-sm ${isAdmin ? 'text-white/90 hover:text-white' : 'text-blue-600 hover:text-blue-800'}">
                                <i class="fas fa-paperclip mr-2"></i>
                                ${escapeHtmlV2(attachmentName)}
                            </a>
                        </div>
                    `;
                }
            }
            
            messageDiv.innerHTML = `
                <div class="${isAdmin ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800'} rounded-lg p-3 max-w-xs">
                    ${messageText ? `<p class="text-sm whitespace-pre-wrap">${escapeHtmlV2(messageText)}</p>` : ''}
                    ${attachmentHtml}
                    <span class="text-xs ${isAdmin ? 'opacity-75' : 'text-gray-500'} mt-1 block">
                        ${time}
                    </span>
                </div>
            `;
            container.appendChild(messageDiv);
        });
        
        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
        console.log('[ChatV2] Messages displayed successfully');
    }

    let adminChatImageStateV2 = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };

    function clampAdminChatImageV2(value, min, max) {
        return Math.min(max, Math.max(min, value));
    }

    function applyAdminChatImageTransformV2() {
        const image = document.getElementById('admin-chat-image-full-v2');
        const modal = document.getElementById('admin-chat-image-modal-v2');
        if (!image || !modal) return;
        const modalRect = modal.getBoundingClientRect();
        const displayWidth = image.naturalWidth * adminChatImageStateV2.scale;
        const displayHeight = image.naturalHeight * adminChatImageStateV2.scale;
        const maxX = Math.max(0, (displayWidth - modalRect.width) / 2);
        const maxY = Math.max(0, (displayHeight - modalRect.height) / 2);
        adminChatImageStateV2.x = clampAdminChatImageV2(adminChatImageStateV2.x, -maxX, maxX);
        adminChatImageStateV2.y = clampAdminChatImageV2(adminChatImageStateV2.y, -maxY, maxY);
        image.style.transform = `translate(${adminChatImageStateV2.x}px, ${adminChatImageStateV2.y}px) scale(${adminChatImageStateV2.scale})`;
    }

    function openAdminChatImageV2(src) {
        const modal = document.getElementById('admin-chat-image-modal-v2');
        const image = document.getElementById('admin-chat-image-full-v2');
        const download = document.getElementById('admin-chat-image-download-v2');
        if (!modal || !image) return;
        image.src = src;
        if (download) download.href = src;
        adminChatImageStateV2 = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
        applyAdminChatImageTransformV2();
        modal.classList.remove('hidden');
    }

    function closeAdminChatImageV2() {
        const modal = document.getElementById('admin-chat-image-modal-v2');
        const image = document.getElementById('admin-chat-image-full-v2');
        const download = document.getElementById('admin-chat-image-download-v2');
        if (!modal || !image) return;
        image.src = '';
        if (download) download.removeAttribute('href');
        modal.classList.add('hidden');
    }

    function resetAdminChatImageV2() {
        adminChatImageStateV2 = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
        applyAdminChatImageTransformV2();
    }

    document.getElementById('chat-messages-container-v2')?.addEventListener('click', function (event) {
        const target = event.target.closest('[data-chat-image]');
        if (!target) return;
        openAdminChatImageV2(target.getAttribute('data-chat-image'));
    });

    const adminChatImageV2 = document.getElementById('admin-chat-image-full-v2');
    const adminChatModalV2 = document.getElementById('admin-chat-image-modal-v2');
    if (adminChatImageV2 && adminChatModalV2) {
        adminChatImageV2.addEventListener('wheel', function (event) {
            event.preventDefault();
            const delta = event.deltaY < 0 ? 1.1 : 0.9;
            adminChatImageStateV2.scale = Math.min(4, Math.max(1, adminChatImageStateV2.scale * delta));
            applyAdminChatImageTransformV2();
        });
        adminChatImageV2.addEventListener('mousedown', function (event) {
            adminChatImageStateV2.dragging = true;
            adminChatImageStateV2.startX = event.clientX - adminChatImageStateV2.x;
            adminChatImageStateV2.startY = event.clientY - adminChatImageStateV2.y;
            adminChatImageV2.style.cursor = 'grabbing';
        });
        adminChatModalV2.addEventListener('mousemove', function (event) {
            if (!adminChatImageStateV2.dragging) return;
            adminChatImageStateV2.x = event.clientX - adminChatImageStateV2.startX;
            adminChatImageStateV2.y = event.clientY - adminChatImageStateV2.startY;
            applyAdminChatImageTransformV2();
        });
        adminChatModalV2.addEventListener('mouseup', function () {
            adminChatImageStateV2.dragging = false;
            adminChatImageV2.style.cursor = 'grab';
        });
        adminChatModalV2.addEventListener('mouseleave', function () {
            adminChatImageStateV2.dragging = false;
            adminChatImageV2.style.cursor = 'grab';
        });
        adminChatImageV2.addEventListener('load', function () {
            applyAdminChatImageTransformV2();
        });
    }

    window.sendAdminMessageV2 = function() {
        if (!currentChatUserIdV2) return;

        const input = document.getElementById('admin-chat-input-v2');
        const message = input.value.trim();

        // Allow sending if there's either a message or a file
        if (message === '' && !selectedAdminFileV2) return;

        input.disabled = true;

        // Prepare request data
        let requestData;
        let headers = {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        };

        if (selectedAdminFileV2) {
            // Use FormData for file uploads
            requestData = new FormData();
            requestData.append('receiver_id', currentChatUserIdV2);
            if (message) {
                requestData.append('message', message);
            }
            requestData.append('attachment', selectedAdminFileV2);
        } else {
            // Use JSON for text-only messages
            headers['Content-Type'] = 'application/json';
            requestData = JSON.stringify({
                message: message,
                receiver_id: currentChatUserIdV2
            });
        }

        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: headers,
            body: requestData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                removeAdminFileV2(); // Clear file selection
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
        fetch('{{ route("chat.unread-count") }}', {
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

    window.handleAdminFileSelectV2 = function(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Check file size (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('Le fichier est trop volumineux. Taille maximale: 10MB');
            event.target.value = '';
            return;
        }

        selectedAdminFileV2 = file;

        // Show file preview
        const preview = document.getElementById('admin-file-preview-v2');
        const fileName = document.getElementById('admin-file-name-v2');
        const fileSize = document.getElementById('admin-file-size-v2');

        fileName.textContent = file.name;
        fileSize.textContent = formatFileSizeV2(file.size);
        preview.classList.remove('hidden');
    };

    window.removeAdminFileV2 = function() {
        selectedAdminFileV2 = null;
        document.getElementById('admin-file-input-v2').value = '';
        document.getElementById('admin-file-preview-v2').classList.add('hidden');
    };

    function formatFileSizeV2(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    function escapeHtmlV2(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Update unread count every 10 seconds
    setInterval(updateAdminUnreadCountV2, 10000);
    updateAdminUnreadCountV2();

    window.openAdminChatImageV2 = openAdminChatImageV2;
    window.closeAdminChatImageV2 = closeAdminChatImageV2;
    window.resetAdminChatImageV2 = resetAdminChatImageV2;
})();
</script>

<div id="admin-chat-image-modal-v2" class="hidden fixed inset-0 z-[9999] bg-black/80 flex items-center justify-center p-4">
    <button type="button" class="absolute top-4 right-4 text-white text-2xl" onclick="closeAdminChatImageV2()">×</button>
    <a id="admin-chat-image-download-v2" class="absolute top-4 left-4 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" download>Tlcharger</a>
    <button type="button" class="absolute top-4 left-32 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" onclick="resetAdminChatImageV2()">Rinitialiser</button>
    <img id="admin-chat-image-full-v2" src="" alt="{{ __('chat.image_preview_alt') }}" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl cursor-grab" style="transform: translate(0,0) scale(1);">
</div>



