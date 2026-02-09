
<div id="client-chat-widget" class="fixed bottom-4 right-4 z-50">
    
    <span id="client-unread-badge" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">0</span>
    
    
    <button 
        id="client-chat-toggle" 
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center relative"
        onclick="toggleClientChat()"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
    </button>

    
    <div 
        id="client-chat-window" 
        class="hidden absolute bottom-16 right-0 w-96 bg-white rounded-lg shadow-2xl overflow-hidden"
        style="max-height: 600px;"
    >
        
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold">Support Client</h3>
                <p class="text-xs opacity-90">Discutez avec notre équipe</p>
            </div>
            <button onclick="toggleClientChat()" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        
        <div id="client-chat-messages" class="p-4 h-96 overflow-y-auto bg-gray-50">
            <div class="text-center text-gray-500 text-sm py-4">
                <i class="fas fa-spinner fa-spin"></i> Chargement des messages...
            </div>
        </div>
        
        
        <div class="p-4 bg-white border-t">
            <div class="flex gap-2 mb-2">
                <input 
                    type="text" 
                    id="client-chat-input"
                    placeholder="Écrivez votre message..." 
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onkeypress="if(event.key === 'Enter') sendClientMessage()"
                >
                <button 
                    onclick="sendClientMessage()"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
            
            
            <div class="flex items-center gap-2">
                <input 
                    type="file" 
                    id="client-chat-file"
                    accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip"
                    class="hidden"
                    onchange="updateClientFileLabel()"
                />
                <label for="client-chat-file" class="cursor-pointer bg-gray-100 hover:bg-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <span id="client-file-label">Joindre un fichier</span>
                </label>
                <button 
                    id="client-remove-file"
                    onclick="removeClientFile()"
                    class="hidden text-red-500 hover:text-red-700 text-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Client Chat Widget - Isolated namespace
(function() {
    let clientChatInterval = null;
    const currentUserId = <?php echo e(auth()->id()); ?>;

    window.toggleClientChat = function() {
        const chatWindow = document.getElementById('client-chat-window');
        const isHidden = chatWindow.classList.contains('hidden');
        
        chatWindow.classList.toggle('hidden');
        
        if (isHidden) {
            loadClientMessages();
            clientChatInterval = setInterval(loadClientMessages, 3000);
        } else {
            if (clientChatInterval) {
                clearInterval(clientChatInterval);
                clientChatInterval = null;
            }
        }
    };

    function loadClientMessages() {
        console.log('[ClientChat] Loading messages...');

        // Build the URL without locale prefix (routes are now outside locale group)
        const messagesUrl = '/chat/messages';
        console.log('[ClientChat] Messages URL:', messagesUrl);

        fetch(messagesUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            console.log('[ClientChat] Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('[ClientChat] Response data:', data);

            if (data.success) {
                if (data.messages) {
                    console.log('[ClientChat] Messages count:', data.messages.length);
                    displayClientMessages(data.messages);
                    updateClientUnreadCount();
                } else {
                    console.warn('[ClientChat] No messages array in response');
                    displayClientMessages([]);
                }
            } else {
                console.error('[ClientChat] API returned success=false');
                const container = document.getElementById('client-chat-messages');
                if (container) {
                    container.innerHTML = `
                        <div class="text-center text-red-500 py-8">
                            <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                            <p>Erreur: ${data.message || 'Erreur inconnue'}</p>
                        </div>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('[ClientChat] Error loading messages:', error);
            const container = document.getElementById('client-chat-messages');
            if (container) {
                container.innerHTML = `
                    <div class="text-center text-red-500 py-8">
                        <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                        <p>Erreur de chargement</p>
                        <p class="text-xs mt-2">${error.message}</p>
                    </div>
                `;
            }
        });
    }

    function displayClientMessages(messages) {
        console.log('[ClientChat] displayClientMessages called with:', messages);
        
        const container = document.getElementById('client-chat-messages');
        
        if (!container) {
            console.error('[ClientChat] Container not found: client-chat-messages');
            return;
        }
        
        if (!messages || !Array.isArray(messages) || messages.length === 0) {
            console.log('[ClientChat] No messages to display');
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-comments text-4xl mb-3 text-gray-300"></i>
                    <p class="text-sm">Aucun message</p>
                    <p class="text-xs mt-2">Commencez une conversation avec notre équipe</p>
                </div>
            `;
            return;
        }
        
        console.log('[ClientChat] Displaying', messages.length, 'messages');
        container.innerHTML = '';
        
        messages.forEach((msg, index) => {
            if (!msg) {
                console.warn('[ClientChat] Skipping null message at index', index);
                return;
            }
            
            console.log('[ClientChat] Processing message:', msg);
            
            const isCurrentUser = msg.sender_id === currentUserId;
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex items-start mb-4 ${isCurrentUser ? 'justify-end' : ''}`;
            
            const time = msg.created_at ? new Date(msg.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }) : '';
            const messageText = msg.message || '';
            
            let attachmentHtml = '';
            if (msg.attachment_path) {
                const fileName = msg.attachment_name || 'Fichier';
                const fileUrl = `/storage/${msg.attachment_path}`;
                const isImage = msg.attachment_type && msg.attachment_type.startsWith('image/');
                if (isImage) {
                    attachmentHtml = `
                        <button type="button" class="block mt-2 focus:outline-none" data-chat-image="${fileUrl}">
                            <img src="${fileUrl}" alt="${escapeHtmlClient(fileName)}" class="max-w-full rounded cursor-zoom-in" style="max-height: 200px;">
                        </button>
                    `;
                } else {
                    attachmentHtml = `
                        <a href="${fileUrl}" target="_blank" class="flex items-center gap-2 mt-2 text-xs ${isCurrentUser ? 'text-blue-100 hover:text-white' : 'text-blue-600 hover:text-blue-800'} underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            ${escapeHtmlClient(fileName)}
                        </a>
                    `;
                }
            }
            
            messageDiv.innerHTML = `
                <div class="${isCurrentUser ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 border border-gray-200'} rounded-lg p-3 max-w-xs shadow-sm">
                    ${messageText ? `<p class="text-sm whitespace-pre-wrap">${escapeHtmlClient(messageText)}</p>` : ''}
                    ${attachmentHtml}
                    <span class="text-xs ${isCurrentUser ? 'text-blue-100' : 'text-gray-500'} mt-1 block">
                        ${time}
                    </span>
                </div>
            `;
            container.appendChild(messageDiv);
        });
        
        container.scrollTop = container.scrollHeight;
        console.log('[ClientChat] Messages displayed successfully');
    }

    let clientChatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };

    function clampClientChatImage(value, min, max) {
        return Math.min(max, Math.max(min, value));
    }

    function applyClientChatImageTransform() {
        const image = document.getElementById('client-chat-image-full');
        const modal = document.getElementById('client-chat-image-modal');
        if (!image || !modal) return;
        const modalRect = modal.getBoundingClientRect();
        const displayWidth = image.naturalWidth * clientChatImageState.scale;
        const displayHeight = image.naturalHeight * clientChatImageState.scale;
        const maxX = Math.max(0, (displayWidth - modalRect.width) / 2);
        const maxY = Math.max(0, (displayHeight - modalRect.height) / 2);
        clientChatImageState.x = clampClientChatImage(clientChatImageState.x, -maxX, maxX);
        clientChatImageState.y = clampClientChatImage(clientChatImageState.y, -maxY, maxY);
        image.style.transform = `translate(${clientChatImageState.x}px, ${clientChatImageState.y}px) scale(${clientChatImageState.scale})`;
    }

    function openClientChatImage(src) {
        const modal = document.getElementById('client-chat-image-modal');
        const image = document.getElementById('client-chat-image-full');
        const download = document.getElementById('client-chat-image-download');
        if (!modal || !image) return;
        image.src = src;
        if (download) download.href = src;
        clientChatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
        applyClientChatImageTransform();
        modal.classList.remove('hidden');
    }

    function closeClientChatImage() {
        const modal = document.getElementById('client-chat-image-modal');
        const image = document.getElementById('client-chat-image-full');
        const download = document.getElementById('client-chat-image-download');
        if (!modal || !image) return;
        image.src = '';
        if (download) download.removeAttribute('href');
        modal.classList.add('hidden');
    }

    function resetClientChatImage() {
        clientChatImageState = { scale: 1, x: 0, y: 0, dragging: false, startX: 0, startY: 0 };
        applyClientChatImageTransform();
    }

    document.getElementById('client-chat-messages')?.addEventListener('click', function (event) {
        const target = event.target.closest('[data-chat-image]');
        if (!target) return;
        openClientChatImage(target.getAttribute('data-chat-image'));
    });

    const clientChatImage = document.getElementById('client-chat-image-full');
    const clientChatModal = document.getElementById('client-chat-image-modal');
    if (clientChatImage && clientChatModal) {
        clientChatImage.addEventListener('wheel', function (event) {
            event.preventDefault();
            const delta = event.deltaY < 0 ? 1.1 : 0.9;
            clientChatImageState.scale = Math.min(4, Math.max(1, clientChatImageState.scale * delta));
            applyClientChatImageTransform();
        });
        clientChatImage.addEventListener('mousedown', function (event) {
            clientChatImageState.dragging = true;
            clientChatImageState.startX = event.clientX - clientChatImageState.x;
            clientChatImageState.startY = event.clientY - clientChatImageState.y;
            clientChatImage.style.cursor = 'grabbing';
        });
        clientChatModal.addEventListener('mousemove', function (event) {
            if (!clientChatImageState.dragging) return;
            clientChatImageState.x = event.clientX - clientChatImageState.startX;
            clientChatImageState.y = event.clientY - clientChatImageState.startY;
            applyClientChatImageTransform();
        });
        clientChatModal.addEventListener('mouseup', function () {
            clientChatImageState.dragging = false;
            clientChatImage.style.cursor = 'grab';
        });
        clientChatModal.addEventListener('mouseleave', function () {
            clientChatImageState.dragging = false;
            clientChatImage.style.cursor = 'grab';
        });
        clientChatImage.addEventListener('load', function () {
            applyClientChatImageTransform();
        });
    }

    window.sendClientMessage = async function() {
        const input = document.getElementById('client-chat-input');
        const fileInput = document.getElementById('client-chat-file');
        const message = input.value.trim();
        
        if (message === '' && fileInput.files.length === 0) return;
        
        input.disabled = true;
        
        // Get CSRF token dynamically from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            console.error('[ClientChat] CSRF token not found in page');
            alert('Erreur de sécurité: Token CSRF manquant. Veuillez rafraîchir la page.');
            input.disabled = false;
            return;
        }
        
        const formData = new FormData();
        if (message) {
            formData.append('message', message);
        }
        if (fileInput.files.length > 0) {
            formData.append('attachment', fileInput.files[0]);
        }
        
        try {
            const response = await fetch('<?php echo e(route("chat.send", ["locale" => app()->getLocale()])); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                input.value = '';
                removeClientFile();
                loadClientMessages();
            } else {
                // Handle specific error cases
                if (response.status === 419) {
                    alert('Erreur de sécurité: Votre session a expiré. Veuillez rafraîchir la page.');
                } else if (response.status === 422) {
                    alert('Erreur de validation: ' + (data.message || 'Données invalides'));
                } else {
                    alert('Erreur lors de l\'envoi du message: ' + (data.message || 'Erreur inconnue'));
                }
            }
        } catch (error) {
            console.error('[ClientChat] Error sending message:', error);
            alert('Erreur lors de l\'envoi du message. Veuillez vérifier votre connexion.');
        } finally {
            input.disabled = false;
            input.focus();
        }
    };

    window.updateClientFileLabel = function() {
        const fileInput = document.getElementById('client-chat-file');
        const label = document.getElementById('client-file-label');
        const removeBtn = document.getElementById('client-remove-file');
        
        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name;
            label.textContent = fileName.length > 20 ? fileName.substring(0, 20) + '...' : fileName;
            removeBtn.classList.remove('hidden');
        } else {
            label.textContent = 'Joindre un fichier';
            removeBtn.classList.add('hidden');
        }
    };

    window.removeClientFile = function() {
        const fileInput = document.getElementById('client-chat-file');
        const label = document.getElementById('client-file-label');
        const removeBtn = document.getElementById('client-remove-file');
        
        fileInput.value = '';
        label.textContent = 'Joindre un fichier';
        removeBtn.classList.add('hidden');
    };

    function updateClientUnreadCount() {
        // Build the URL without locale prefix (routes are now outside locale group)
        const unreadCountUrl = '/chat/unread-count';
        console.log('[ClientChat] Unread count URL:', unreadCountUrl);

        fetch(unreadCountUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const badge = document.getElementById('client-unread-badge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        })
        .catch(error => console.error('[ClientChat] Error updating unread count:', error));
    }

    function escapeHtmlClient(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Update unread count every 10 seconds
    setInterval(updateClientUnreadCount, 10000);
    updateClientUnreadCount();

    window.openClientChatImage = openClientChatImage;
    window.closeClientChatImage = closeClientChatImage;
    window.resetClientChatImage = resetClientChatImage;
})();
</script>

<div id="client-chat-image-modal" class="hidden fixed inset-0 z-[9999] bg-black/80 flex items-center justify-center p-4">
    <button type="button" class="absolute top-4 right-4 text-white text-2xl" onclick="closeClientChatImage()">×</button>
    <a id="client-chat-image-download" class="absolute top-4 left-4 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" download>Tlcharger</a>
    <button type="button" class="absolute top-4 left-32 text-white text-sm bg-white/10 hover:bg-white/20 px-3 py-1 rounded" onclick="resetClientChatImage()">Rinitialiser</button>
    <img id="client-chat-image-full" src="" alt="Aperçu image" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl cursor-grab" style="transform: translate(0,0) scale(1);">
</div>

<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/client-chat-widget.blade.php ENDPATH**/ ?>