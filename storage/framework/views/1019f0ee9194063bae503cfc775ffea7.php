
<?php
    $chatWidgetWithFilesI18n = [
        'greeting' => __('chat.greeting'),
        'supportLabel' => __('chat.support_label'),
        'supportShort' => __('chat.support_short'),
        'youLabel' => __('chat.you_label'),
        'fileTooLarge' => __('chat.file_too_large'),
        'sendError' => __('chat.send_error'),
        'sendErrorConnection' => __('chat.send_error_connection'),
        'download' => __('chat.download'),
        'resetImage' => __('chat.reset_image'),
        'imagePreviewAlt' => __('chat.image_preview_alt'),
    ];
?>
<div id="chat-widget" class="fixed bottom-4 right-4 z-50">
    
    <span id="unread-badge" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">0</span>
    
    
    <button 
        id="chat-toggle" 
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center relative"
        onclick="toggleChat()"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
    </button>

    
    <div
        id="chat-window"
        class="hidden absolute bottom-16 right-0 w-[min(24rem,calc(100vw-1.5rem))] sm:w-80 bg-white rounded-lg shadow-2xl overflow-hidden flex flex-col"
        style="max-height: min(70vh, 500px);"
    >
        
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold"><?php echo e(__('chat.support_title')); ?></h3>
                <p class="text-xs opacity-90"><?php echo e(__('chat.support_subtitle')); ?></p>
            </div>
            <button onclick="toggleChat()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        
        <div id="chat-messages" class="p-4 flex-1 min-h-[180px] overflow-y-auto bg-gray-50">
            <div class="text-center text-gray-500 text-sm py-4">
                <i class="fas fa-spinner fa-spin"></i> <?php echo e(__('chat.loading_messages')); ?>

            </div>
        </div>

        
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

        
        <div class="p-4 bg-white border-t shrink-0">
            <form id="chat-form" enctype="multipart/form-data">
                <div class="flex gap-2 items-end">
                    
                    <input type="file" id="file-input" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip" onchange="handleFileSelect(event)">
                    
                    
                    <button 
                        type="button"
                        onclick="document.getElementById('file-input').click()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg px-3 py-2 transition-colors"
                        title="<?php echo e(__('chat.attach_file')); ?>"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </button>
                    
                    
                    <input 
                        type="text" 
                        id="chat-input"
                        placeholder="<?php echo e(__('chat.message_placeholder')); ?>" 
                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="handleChatTypingInput()"
                        onblur="stopChatTyping()"
                        onkeypress="if(event.key === 'Enter') { event.preventDefault(); sendChatMessage(); }"
                    >
                    
                    
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
const chatLocale = document.documentElement.lang || '<?php echo e(app()->getLocale()); ?>';
const chatI18n = <?php echo json_encode($chatWidgetWithFilesI18n, 15, 512) ?>;
let chatInterval = null;
let lastMessageId = 0;
let selectedFile = null;
let chatTypingStopTimer = null;
let chatLastTypingPingAt = 0;

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
        stopChatTyping();
        // Chat closed - stop polling
        if (chatInterval) {
            clearInterval(chatInterval);
            chatInterval = null;
        }
    }
}

function notifyChatTyping(isTyping) {
    const now = Date.now();
    if (isTyping && now - chatLastTypingPingAt < 2000) {
        return;
    }

    if (isTyping) {
        chatLastTypingPingAt = now;
    } else {
        chatLastTypingPingAt = 0;
    }

    fetch('/chat/typing', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            is_typing: Boolean(isTyping),
        })
    }).catch(error => {
        console.error('Error sending typing status:', error);
    });
}

function handleChatTypingInput() {
    notifyChatTyping(true);

    if (chatTypingStopTimer) {
        clearTimeout(chatTypingStopTimer);
    }

    chatTypingStopTimer = setTimeout(() => {
        notifyChatTyping(false);
    }, 1800);
}

function stopChatTyping() {
    if (chatTypingStopTimer) {
        clearTimeout(chatTypingStopTimer);
        chatTypingStopTimer = null;
    }
    notifyChatTyping(false);
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Check file size (max 10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert(chatI18n.fileTooLarge.replace(':size', '10MB'));
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
    const currentUserId = <?php echo e(auth()->id()); ?>;
    
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
        
        let attachmentHtml = '';
        if (msg.attachment_path) {
            const isImage = msg.attachment_type && msg.attachment_type.startsWith('image/');
            if (isImage) {
                attachmentHtml = `
                    <button type="button" class="block mt-2 focus:outline-none" data-chat-image="/storage/${msg.attachment_path}">
                        <img src="/storage/${msg.attachment_path}" alt="${msg.attachment_name}" class="max-w-full rounded cursor-zoom-in" style="max-height: 200px;">
                    </button>
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

let chatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };

function clampChatImage(value, min, max) {
    return Math.min(max, Math.max(min, value));
}

function applyChatImageTransform() {
    const image = document.getElementById('chat-image-full');
    const modal = document.getElementById('chat-image-modal');
    if (!image || !modal) return;
    const modalRect = modal.getBoundingClientRect();
    const displayWidth = image.naturalWidth * chatImageState.scale;
    const displayHeight = image.naturalHeight * chatImageState.scale;
    const maxX = Math.max(0, (displayWidth - modalRect.width) / 2);
    const maxY = Math.max(0, (displayHeight - modalRect.height) / 2);
    chatImageState.x = clampChatImage(chatImageState.x, -maxX, maxX);
    chatImageState.y = clampChatImage(chatImageState.y, -maxY, maxY);
    image.style.transform = `translate(${chatImageState.x}px, ${chatImageState.y}px) scale(${chatImageState.scale})`;
}

function openChatImage(src) {
    const modal = document.getElementById('chat-image-modal');
    const image = document.getElementById('chat-image-full');
    const download = document.getElementById('chat-image-download');
    if (!modal || !image) return;
    image.src = src;
    if (download) download.href = src;
    chatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
    applyChatImageTransform();
    modal.classList.remove('hidden');
}

function closeChatImage() {
    const modal = document.getElementById('chat-image-modal');
    const image = document.getElementById('chat-image-full');
    const download = document.getElementById('chat-image-download');
    if (!modal || !image) return;
    image.src = '';
    if (download) download.removeAttribute('href');
    modal.classList.add('hidden');
}

function resetChatImage() {
    chatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
    applyChatImageTransform();
}

document.getElementById('chat-messages')?.addEventListener('click', function (event) {
    const target = event.target.closest('[data-chat-image]');
    if (!target) return;
    openChatImage(target.getAttribute('data-chat-image'));
});

const chatImage = document.getElementById('chat-image-full');
const chatModal = document.getElementById('chat-image-modal');
if (chatImage && chatModal) {
    chatImage.addEventListener('wheel', function (event) {
        event.preventDefault();
        const delta = event.deltaY < 0 ? 1.1 : 0.9;
        chatImageState.scale = Math.min(4, Math.max(1, chatImageState.scale * delta));
        applyChatImageTransform();
    });
    chatImage.addEventListener('mousedown', function (event) {
        chatImageState.dragging = true;
        chatImageState.startX = event.clientX - chatImageState.x;
        chatImageState.startY = event.clientY - chatImageState.y;
        chatImage.style.cursor = 'grabbing';
    });
    chatModal.addEventListener('mousemove', function (event) {
        if (!chatImageState.dragging) return;
        chatImageState.x = event.clientX - chatImageState.startX;
        chatImageState.y = event.clientY - chatImageState.startY;
        applyChatImageTransform();
    });
    chatModal.addEventListener('mouseup', function () {
        chatImageState.dragging = false;
        chatImage.style.cursor = 'grab';
    });
    chatModal.addEventListener('mouseleave', function () {
        chatImageState.dragging = false;
        chatImage.style.cursor = 'grab';
    });
    chatImage.addEventListener('load', function () {
        applyChatImageTransform();
    });
}

function sendChatMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    
    // Check if we have either a message or a file
    if (message === '' && !selectedFile) return;

    stopChatTyping();
    
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
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
            alert(data.message || chatI18n.sendError);
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert(chatI18n.sendError);
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

<div id="chat-image-modal" class="hidden fixed inset-0 z-[9999] bg-black/80 flex items-center justify-center p-4">
    <button type="button" class="absolute top-4 right-4 text-white text-2xl" onclick="closeChatImage()">×</button>
    <a id="chat-image-download" class="absolute top-4 left-4 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" download><?php echo e(__('chat.download')); ?></a>
    <button type="button" class="absolute top-4 left-32 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" onclick="resetChatImage()"><?php echo e(__('chat.reset_image')); ?></button>
    <img id="chat-image-full" src="" alt="<?php echo e(__('chat.image_preview_alt')); ?>" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl cursor-grab" style="transform: translate(0,0) scale(1);">
</div>


<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\components\chat-widget-with-files.blade.php ENDPATH**/ ?>