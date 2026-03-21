@php
    $clientChatI18n = [
        'loadingError' => __('chat.loading_error'),
        'startConversation' => __('chat.start_conversation'),
        'noMessages' => __('chat.no_messages'),
        'unknownError' => __('chat.unknown_error'),
        'securityCsrfMissing' => __('chat.security_csrf_missing'),
        'securitySessionExpired' => __('chat.security_session_expired'),
        'validationError' => __('chat.validation_error'),
        'sendErrorDetail' => __('chat.send_error_detail'),
        'sendErrorConnection' => __('chat.send_error_connection'),
        'fileLabel' => __('chat.file_label'),
        'supportShort' => __('chat.support_short'),
        'youLabel' => __('chat.you_label'),
        'loadingMessages' => __('chat.loading_messages'),
        'title' => __('chat.client_support_title'),
        'subtitle' => __('chat.client_support_subtitle'),
        'placeholder' => __('chat.client_message_placeholder'),
        'download' => __('chat.download'),
        'imageAlt' => __('chat.image_preview_alt'),
        'online' => __('admin_chat.online'),
        'connected' => __('admin_chat.connected'),
        'disconnected' => __('admin_chat.disconnected'),
        'typing' => __('admin_chat.typing'),
    ];
@endphp

@include('components.chat-premium-styles')

<div id="client-chat-widget" class="chat-premium-shell fixed bottom-[calc(env(safe-area-inset-bottom,0px)+1rem)] right-4 z-[72]" style="--chat-accent:#155eef; --chat-accent-strong:#1d4ed8;">
    <div id="client-chat-backdrop" class="chat-premium-backdrop hidden"></div>
    <span id="client-unread-badge" class="pointer-events-none absolute -right-1 -top-1 z-[1] hidden min-w-[1.5rem] rounded-full bg-rose-500 px-1.5 py-1 text-center text-[11px] font-bold leading-none text-white shadow-lg shadow-rose-900/20">0</span>

    <button type="button" id="client-chat-toggle" class="chat-premium-launcher" aria-controls="client-chat-window" aria-expanded="false">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
    </button>

    <section id="client-chat-window" class="chat-premium-window fixed inset-x-0 bottom-0 top-0 hidden sm:absolute sm:inset-auto sm:bottom-20 sm:right-0" aria-hidden="true">
        <header class="chat-premium-header shrink-0">
            <div class="flex items-start justify-between gap-3">
                <div class="flex min-w-0 items-start gap-3">
                    <span id="client-chat-avatar" class="chat-premium-avatar">CS</span>
                    <div class="min-w-0">
                        <div class="chat-premium-badge">
                            <span id="client-chat-status-dot" class="chat-premium-status-dot is-connected"></span>
                            <span id="client-chat-status-label">{{ __('admin_chat.connected') }}</span>
                        </div>
                        <h3 class="mt-3 truncate text-lg font-semibold">{{ __('chat.client_support_title') }}</h3>
                        <p id="client-chat-subtitle" class="mt-1 text-sm leading-5 text-white/80 sm:truncate">{{ __('chat.client_support_subtitle') }}</p>
                    </div>
                </div>
                <button type="button" id="client-chat-close" class="chat-premium-close" aria-label="Close">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </header>

        <div class="chat-premium-body flex min-h-0 flex-1 flex-col">
            <div id="client-chat-messages" class="chat-premium-scroll min-h-0 flex-1 px-4 py-4 sm:px-5">
                <div class="chat-premium-empty">
                    <span class="chat-premium-empty-icon">
                        <svg class="h-8 w-8 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </span>
                    <p class="text-sm font-semibold text-slate-800">{{ __('chat.loading_messages') }}</p>
                </div>
            </div>

            <div id="client-chat-typing-wrap" class="hidden px-4 pb-3 sm:px-5">
                <div class="chat-premium-typing">
                    <span class="chat-premium-typing-dots" aria-hidden="true"><span></span><span></span><span></span></span>
                    <span id="client-chat-typing-text" class="text-xs font-medium">{{ __('admin_chat.typing') }}</span>
                </div>
            </div>

            <div class="chat-premium-composer shrink-0">
                <div id="client-file-chip" class="chat-premium-file-chip hidden">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="chat-premium-file-icon"><i class="fas fa-paperclip text-sm"></i></span>
                        <div class="min-w-0">
                            <p id="client-file-name" class="truncate text-sm font-semibold text-slate-900"></p>
                            <p id="client-file-size" class="text-xs text-slate-500"></p>
                        </div>
                    </div>
                    <button type="button" id="client-remove-file" class="text-sm font-semibold text-rose-600">X</button>
                </div>

                <div class="chat-premium-composer-row">
                    <input type="file" id="client-chat-file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip" class="hidden">
                    <button type="button" id="client-file-trigger" class="chat-premium-icon-button" aria-label="{{ __('chat.attach_file') }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </button>
                    <textarea id="client-chat-input" rows="1" class="chat-premium-input" placeholder="{{ __('chat.client_message_placeholder') }}"></textarea>
                    <button type="button" id="client-send-button" class="chat-premium-send" aria-label="Send">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
                <p id="client-chat-feedback" class="mt-3 hidden text-xs font-medium"></p>
            </div>
        </div>
    </section>
</div>

<div id="client-chat-image-modal" class="chat-premium-image-modal">
    <button type="button" id="client-chat-image-close" class="absolute right-4 top-4 rounded-full border border-white/15 bg-white/10 px-3 py-2 text-sm font-semibold text-white">X</button>
    <a id="client-chat-image-download" class="absolute left-4 top-4 rounded-full border border-white/15 bg-white/10 px-3 py-2 text-sm font-semibold text-white" download>{{ __('chat.download') }}</a>
    <img id="client-chat-image-full" src="" alt="{{ __('chat.image_preview_alt') }}" class="chat-premium-image-view">
</div>

<script>
(() => {
    if (window.ValtrixClientChatMounted) return;
    window.ValtrixClientChatMounted = true;

    const i18n = @json($clientChatI18n);
    const currentUserId = {{ auth()->id() }};
    const locale = document.documentElement.lang || '{{ app()->getLocale() }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const el = {
        toggle: document.getElementById('client-chat-toggle'),
        window: document.getElementById('client-chat-window'),
        close: document.getElementById('client-chat-close'),
        backdrop: document.getElementById('client-chat-backdrop'),
        badge: document.getElementById('client-unread-badge'),
        messages: document.getElementById('client-chat-messages'),
        avatar: document.getElementById('client-chat-avatar'),
        subtitle: document.getElementById('client-chat-subtitle'),
        statusDot: document.getElementById('client-chat-status-dot'),
        statusLabel: document.getElementById('client-chat-status-label'),
        typingWrap: document.getElementById('client-chat-typing-wrap'),
        typingText: document.getElementById('client-chat-typing-text'),
        input: document.getElementById('client-chat-input'),
        send: document.getElementById('client-send-button'),
        fileInput: document.getElementById('client-chat-file'),
        fileTrigger: document.getElementById('client-file-trigger'),
        fileChip: document.getElementById('client-file-chip'),
        fileName: document.getElementById('client-file-name'),
        fileSize: document.getElementById('client-file-size'),
        removeFile: document.getElementById('client-remove-file'),
        feedback: document.getElementById('client-chat-feedback'),
        imageModal: document.getElementById('client-chat-image-modal'),
        imageClose: document.getElementById('client-chat-image-close'),
        imageDownload: document.getElementById('client-chat-image-download'),
        imageFull: document.getElementById('client-chat-image-full'),
    };

    const state = { open: false, init: false, loading: false, sending: false, poll: null, unread: null, typingTimer: null, feedbackTimer: null, lastPing: 0, sig: '', file: null, partnerName: i18n.supportShort };

    const esc = (v) => { const d = document.createElement('div'); d.textContent = v ?? ''; return d.innerHTML; };
    const time = (v) => { try { return v ? new Date(v).toLocaleTimeString(locale, { hour: '2-digit', minute: '2-digit' }) : ''; } catch { return ''; } };
    const size = (v) => { let b = Number(v || 0), u = ['B', 'KB', 'MB', 'GB'], i = 0; while (b >= 1024 && i < u.length - 1) { b /= 1024; i += 1; } return b ? `${b.toFixed(b >= 10 || i === 0 ? 0 : 1)} ${u[i]}` : ''; };
    const initials = (v) => String(v || '').trim().split(/\s+/).filter(Boolean).slice(0, 2).map((p) => p[0].toUpperCase()).join('') || 'CS';
    const presence = (v) => ['online', 'connected'].includes(v) ? v : 'disconnected';
    const presenceLabel = (v) => v === 'online' ? i18n.online : (v === 'connected' ? i18n.connected : i18n.disconnected);

    function resizeInput() {
        el.input.style.height = '0px';
        el.input.style.height = `${Math.min(el.input.scrollHeight, 120)}px`;
    }

    function setFeedback(message = '', tone = 'neutral') {
        clearTimeout(state.feedbackTimer);
        if (!message) {
            el.feedback.className = 'mt-3 hidden text-xs font-medium';
            el.feedback.textContent = '';
            return;
        }
        el.feedback.className = `mt-3 text-xs font-medium ${tone === 'error' ? 'text-rose-600' : 'text-slate-500'}`;
        el.feedback.textContent = message;
        state.feedbackTimer = setTimeout(() => setFeedback(''), 5000);
    }

    function setPresence(status) {
        const safe = presence(status);
        el.statusDot.className = `chat-premium-status-dot is-${safe}`;
        el.statusLabel.textContent = presenceLabel(safe);
    }

    function updatePartner(partner, userPresence) {
        state.partnerName = partner?.display_name || i18n.supportShort;
        const safe = presence(userPresence?.presence_status);
        el.avatar.textContent = initials(state.partnerName);
        el.subtitle.textContent = `${state.partnerName} - ${presenceLabel(safe)}`;
        setPresence(safe);
    }

    function setTyping(show) {
        if (show) {
            el.typingText.textContent = `${state.partnerName} - ${i18n.typing}`;
            el.typingWrap.classList.remove('hidden');
            return;
        }
        el.typingWrap.classList.add('hidden');
    }

    function loadingState(message = i18n.loadingMessages) {
        el.messages.innerHTML = `<div class="chat-premium-empty"><span class="chat-premium-empty-icon"><svg class="h-8 w-8 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg></span><p class="text-sm font-semibold text-slate-800">${esc(message)}</p></div>`;
    }

    function emptyState(title = i18n.noMessages, subtitle = i18n.startConversation) {
        el.messages.innerHTML = `<div class="chat-premium-empty"><span class="chat-premium-empty-icon"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg></span><div class="space-y-2"><p class="text-sm font-semibold text-slate-800">${esc(title)}</p><p class="text-xs text-slate-500">${esc(subtitle)}</p></div></div>`;
    }

    function attachmentHtml(msg, outgoing) {
        if (!msg.attachment_path) return '';
        const url = msg.attachment_url || `/storage/${msg.attachment_path}`;
        const name = msg.attachment_name || i18n.fileLabel;
        const fsize = msg.formatted_attachment_size || size(msg.attachment_size);
        if (msg.is_image_attachment || (msg.attachment_type || '').startsWith('image/')) {
            return `<button type="button" class="chat-premium-attachment w-full overflow-hidden text-left" data-client-chat-image="${esc(url)}"><img src="${esc(url)}" alt="${esc(name)}" class="chat-premium-image"></button>`;
        }
        return `<a href="${esc(url)}" target="_blank" rel="noopener" class="chat-premium-attachment chat-premium-file"><span class="chat-premium-file-icon"><i class="fas fa-file-alt text-sm"></i></span><span class="min-w-0 flex-1"><span class="block truncate text-sm font-semibold">${esc(name)}</span><span class="mt-1 block text-xs ${outgoing ? 'text-white/75' : 'text-slate-500'}">${esc(fsize)}</span></span></a>`;
    }

    function messageHtml(msg) {
        const outgoing = Number(msg.sender_id) === Number(currentUserId);
        const name = outgoing ? i18n.youLabel : (msg.sender?.display_name || msg.sender_display_name || state.partnerName || i18n.supportShort);
        return `<div class="chat-premium-message-row ${outgoing ? 'chat-premium-message-row--outgoing' : ''}">${outgoing ? '' : `<span class="chat-premium-avatar bg-white text-slate-700">${esc(initials(name))}</span>`}<div class="chat-premium-message-bubble">${msg.message ? `<p class="text-sm whitespace-pre-wrap break-words leading-6">${esc(msg.message)}</p>` : ''}${attachmentHtml(msg, outgoing)}<div class="chat-premium-meta"><span>${esc(name)}</span><span>&middot;</span><span>${esc(time(msg.created_at))}</span></div></div></div>`;
    }

    function renderMessages(messages) {
        if (!Array.isArray(messages) || !messages.length) { state.sig = ''; emptyState(); return; }
        const sig = messages.map((m) => `${m.id}:${m.updated_at || m.created_at || ''}`).join('|');
        const stick = el.messages.scrollHeight - el.messages.scrollTop - el.messages.clientHeight < 72;
        if (sig === state.sig) { if (stick) el.messages.scrollTop = el.messages.scrollHeight; return; }
        state.sig = sig;
        el.messages.innerHTML = `<div class="space-y-4">${messages.map(messageHtml).join('')}</div>`;
        el.messages.scrollTop = el.messages.scrollHeight;
    }

    async function json(url, options = {}) {
        const response = await fetch(url, { credentials: 'same-origin', ...options, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', ...(options.headers || {}) } });
        const text = await response.text();
        let data = null;
        try { data = text ? JSON.parse(text) : {}; } catch {}
        return { response, data };
    }

    async function loadMessages(forceLoader = false) {
        if (state.loading) return;
        state.loading = true;
        if (forceLoader && !state.init) loadingState();
        try {
            const { response, data } = await json('{{ route("chat.messages") }}');
            if (!response.ok || !data || !data.success) {
                emptyState(i18n.loadingError, data?.message || (response.status === 419 ? i18n.securitySessionExpired : i18n.unknownError));
                return;
            }
            state.init = true;
            updatePartner(data.chat_partner || null, data.user_presence || null);
            setTyping(Boolean(data.user_typing));
            renderMessages(data.messages || []);
            if (state.open) el.badge.classList.add('hidden');
        } catch (error) {
            emptyState(i18n.loadingError, error.message || i18n.unknownError);
        } finally {
            state.loading = false;
        }
    }

    async function unreadCount() {
        if (state.open) { el.badge.classList.add('hidden'); return; }
        try {
            const { response, data } = await json('{{ route("chat.unread-count") }}');
            if (!response.ok || !data || !data.success) return;
            const count = Number(data.count || 0);
            if (count > 0) {
                el.badge.textContent = count > 99 ? '99+' : `${count}`;
                el.badge.classList.remove('hidden');
            } else {
                el.badge.classList.add('hidden');
            }
        } catch {}
    }

    async function sendTyping(isTyping) {
        if (!csrfToken) return;
        const now = Date.now();
        if (isTyping && now - state.lastPing < 1800) return;
        state.lastPing = isTyping ? now : 0;
        try {
            await json('{{ route("chat.typing") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }, body: JSON.stringify({ is_typing: Boolean(isTyping) }) });
        } catch {}
    }

    function clearFile() {
        state.file = null;
        el.fileInput.value = '';
        el.fileChip.classList.add('hidden');
        el.fileName.textContent = '';
        el.fileSize.textContent = '';
    }

    async function sendMessage() {
        const message = el.input.value.trim();
        if (state.sending || (!message && !state.file)) return;
        if (!csrfToken) { setFeedback(i18n.securityCsrfMissing, 'error'); return; }
        state.sending = true;
        el.send.disabled = true;
        el.input.disabled = true;
        el.fileTrigger.disabled = true;
        clearTimeout(state.typingTimer);
        sendTyping(false);
        const form = new FormData();
        if (message) form.append('message', message);
        if (state.file) form.append('attachment', state.file);
        try {
            const { response, data } = await json('{{ route("chat.send") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: form });
            if (response.ok && data && data.success) {
                el.input.value = '';
                resizeInput();
                clearFile();
                setFeedback('');
                state.sig = '';
                await loadMessages();
            } else if (response.status === 419) {
                setFeedback(i18n.securitySessionExpired, 'error');
            } else if (response.status === 422) {
                setFeedback(i18n.validationError.replace(':message', data?.message || i18n.unknownError), 'error');
            } else {
                setFeedback(i18n.sendErrorDetail.replace(':message', data?.message || i18n.unknownError), 'error');
            }
        } catch {
            setFeedback(i18n.sendErrorConnection, 'error');
        } finally {
            state.sending = false;
            el.send.disabled = false;
            el.input.disabled = false;
            el.fileTrigger.disabled = false;
            el.input.focus();
        }
    }

    function lockBody(locked) {
        if (window.innerWidth < 640) document.body.classList.toggle('overflow-hidden', locked);
        if (!locked && !el.imageModal.classList.contains('is-open')) document.body.classList.remove('overflow-hidden');
    }

    function setOpen(open) {
        state.open = Boolean(open);
        el.toggle.setAttribute('aria-expanded', state.open ? 'true' : 'false');
        el.window.setAttribute('aria-hidden', state.open ? 'false' : 'true');
        el.window.classList.toggle('hidden', !state.open);
        el.window.classList.toggle('is-open', state.open);
        el.backdrop.classList.toggle('hidden', !state.open);
        el.backdrop.classList.toggle('is-open', state.open);
        lockBody(state.open);
        if (state.poll) clearInterval(state.poll);
        if (state.open) {
            setFeedback('');
            el.badge.classList.add('hidden');
            loadMessages(!state.init);
            state.poll = setInterval(() => loadMessages(false), 3500);
            setTimeout(() => el.input.focus(), 100);
        } else {
            sendTyping(false);
            setTyping(false);
        }
    }

    function toggle(force) { setOpen(typeof force === 'boolean' ? force : !state.open); }
    function openImage(src) { if (!src) return; el.imageFull.src = src; el.imageDownload.href = src; el.imageModal.classList.add('is-open'); document.body.classList.add('overflow-hidden'); }
    function closeImage() { el.imageModal.classList.remove('is-open'); el.imageFull.src = ''; el.imageDownload.removeAttribute('href'); if (!state.open || window.innerWidth >= 640) document.body.classList.remove('overflow-hidden'); }

    el.toggle.addEventListener('click', () => toggle());
    el.close.addEventListener('click', () => toggle(false));
    el.backdrop.addEventListener('click', () => toggle(false));
    el.fileTrigger.addEventListener('click', () => el.fileInput.click());
    el.fileInput.addEventListener('change', (event) => {
        state.file = event.target.files?.[0] || null;
        if (!state.file) { clearFile(); return; }
        el.fileName.textContent = state.file.name;
        el.fileSize.textContent = size(state.file.size);
        el.fileChip.classList.remove('hidden');
    });
    el.removeFile.addEventListener('click', clearFile);
    el.send.addEventListener('click', sendMessage);
    el.input.addEventListener('input', () => {
        resizeInput();
        sendTyping(true);
        clearTimeout(state.typingTimer);
        state.typingTimer = setTimeout(() => sendTyping(false), 1800);
    });
    el.input.addEventListener('blur', () => sendTyping(false));
    el.input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    });
    el.messages.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-client-chat-image]');
        if (trigger) openImage(trigger.getAttribute('data-client-chat-image'));
    });
    el.imageClose.addEventListener('click', closeImage);
    el.imageModal.addEventListener('click', (event) => { if (event.target === el.imageModal) closeImage(); });
    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        if (el.imageModal.classList.contains('is-open')) { closeImage(); return; }
        if (state.open) toggle(false);
    });

    resizeInput();
    state.unread = setInterval(unreadCount, 12000);
    unreadCount();
    window.toggleClientChat = toggle;
})();
</script>
