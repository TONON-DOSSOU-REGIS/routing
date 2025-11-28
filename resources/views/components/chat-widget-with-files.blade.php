{{-- Chat Widget Component with File Upload Support --}}
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
                <h3 class="font-bold">Support SG BANK</h3>
                <p class="text-xs opacity-90">Nous sommes là pour vous aider</p>
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
                <i class="fas fa-spinner fa-spin"></i> Chargement des messages...
            </div>
        </div>

        {{-- File preview area --}}
        <div id="file-preview" class="hidden px-4 py-2 bg-gray-100 border-t">
            <div class="flex items-center justify-between bg-white p-2 rounded">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-file text-blue-600"></i>
                    <span id="file-name" class="text-sm text-gray-700"></span>
                    <span id="file-size" class="text-xs text-gray-500"></span>
                </div>
                <button onclick="removeFile()" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        {{-- Chat input --}}
        <div class="p-4 bg-white border-t">
            <form id="chat-form" enctype="multipart/form-data">
                <div class="flex gap-2 items-end">
                    {{-- File input (hidden) --}}
                    <input type="file" id="file-input" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip" onchange="handleFileSelect(event)">
                    
                    {{-- Attach button --}}
                    <button 
                        type="button"
                        onclick="document.getElementById('file-input').click()"
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
                        id="chat-input"
                        placeholder="Tapez votre message..." 
                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onkeypress="if(event.key === 'Enter') { event.preventDefault(); sendChatMessage(); }"
                    >
                    
                    {{-- Send button --}}
                    <button 
                        type="button"
                        onclick="sendChatMessage()"
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 transition-colors"
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

<script>
let chatInterval = null;
let lastMessageId = 0;
let selectedFile = null;

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

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Check file size (max 10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert('Le fichier est trop volumineux. Taille maximale: 10MB');
        event.target.value = '';
        return;
    }
    
    selectedFile = file;
    
    // Show file preview
    const preview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    preview.classList.remove('hidden');
}

function removeFile() {
    selectedFile = null;
    document.getElementById('file-input').value = '';
    document.getElementById('file-preview').classList.add('hidden');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
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
                    <p class="text-sm text-gray-800">Bonjour! Comment puis-je vous aider aujourd'hui?</p>
                    <span class="text-xs text-gray-500 mt-1 block">Support SG BANK</span>
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
        
        const time = new Date(msg.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        
        let attachmentHtml = '';
        if (msg.attachment_path) {
            const isImage = msg.attachment_type && msg.attachment_type.startsWith('image/');
            if (isImage) {
                attachmentHtml = `
                    <a href="/storage/${msg.attachment_path}" target="_blank" class="block mt-2">
                        <img src="/storage/${msg.attachment_path}" alt="${msg.attachment_name}" class="max-w-full rounded" style="max-height: 200px;">
                    </a>
                `;
            } else {
                attachmentHtml = `
                    <a href="/storage/${msg.attachment_path}" target="_blank" download class="flex items-center gap-2 mt-2 p-2 bg-white bg-opacity-20 rounded hover:bg-opacity-30 transition">
                        <i class="fas fa-file"></i>
                        <span class="text-sm">${msg.attachment_name}</span>
                    </a>
                `;
            }
        }
        
        messageDiv.innerHTML = `
            <div class="${isCurrentUser ? 'bg-blue-600 text-white' : 'bg-blue-100 text-gray-800'} rounded-lg p-3 max-w-xs">
                ${msg.message ? `<p class="text-sm">${escapeHtml(msg.message)}</p>` : ''}
                ${attachmentHtml}
                <span class="text-xs ${isCurrentUser ? 'opacity-75' : 'text-gray-500'} mt-1 block">
                    ${isCurrentUser ? 'Vous' : (msg.sender ? msg.sender.first_name : 'Support')} • ${time}
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
    
    // Check if we have either a message or a file
    if (message === '' && !selectedFile) return;
    
    // Disable input while sending
    input.disabled = true;
    
    const formData = new FormData();
    if (message) {
        formData.append('message', message);
    }
    if (selectedFile) {
        formData.append('attachment', selectedFile);
    }
    
    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            removeFile();
            loadChatMessages();
        } else {
            alert(data.message || 'Erreur lors de l\'envoi du message');
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Erreur lors de l\'envoi du message');
    })
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


