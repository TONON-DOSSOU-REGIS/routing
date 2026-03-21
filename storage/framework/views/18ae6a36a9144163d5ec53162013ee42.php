<?php
    $adminChatV2I18n = [
        'loadingError' => __('admin_chat.loading_error'),
        'loadingMessages' => __('admin_chat.loading_messages'),
        'noConversations' => __('admin_chat.no_conversations'),
        'noMessages' => __('admin_chat.no_messages'),
        'loadingMessagesError' => __('admin_chat.loading_messages_error'),
        'connectionError' => __('admin_chat.connection_error'),
        'startConversation' => __('admin_chat.start_conversation'),
        'messagesWillAppear' => __('admin_chat.messages_will_appear'),
        'userFallback' => __('admin_chat.user_fallback'),
        'online' => __('admin_chat.online'),
        'connected' => __('admin_chat.connected'),
        'disconnected' => __('admin_chat.disconnected'),
        'typing' => __('admin_chat.typing'),
        'selectUser' => __('admin_chat.select_user'),
        'recipientHint' => __('admin_chat.recipient_hint'),
        'recentConversations' => __('admin_chat.recent_conversations'),
        'selectedRecipient' => __('admin_chat.selected_recipient'),
        'changeRecipient' => __('admin_chat.change_recipient'),
        'recipientRequired' => __('admin_chat.recipient_required'),
        'selectUserPlaceholder' => __('admin_chat.select_user_placeholder'),
        'noUsersAvailable' => __('admin_chat.no_users_available'),
        'replyPlaceholder' => __('admin_chat.reply_placeholder'),
        'loadingConversations' => __('admin_chat.loading_conversations'),
        'attachFile' => __('chat.attach_file'),
        'fileLabel' => __('chat.file_label'),
        'download' => __('chat.download'),
        'imageAlt' => __('chat.image_preview_alt'),
    ];
?>

<?php echo $__env->make('components.chat-premium-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div id="admin-chat-widget-v2" class="chat-premium-shell fixed bottom-[calc(env(safe-area-inset-bottom,0px)+1rem)] right-4 z-[72]" style="--chat-accent:#7c3aed; --chat-accent-strong:#5b21b6;">
    <div id="admin-chat-backdrop-v2" class="chat-premium-backdrop hidden"></div>
    <span id="admin-unread-badge-v2" class="pointer-events-none absolute -right-1 -top-1 z-[1] hidden min-w-[1.5rem] rounded-full bg-rose-500 px-1.5 py-1 text-center text-[11px] font-bold leading-none text-white shadow-lg shadow-rose-900/20">0</span>

    <button type="button" id="admin-chat-toggle-v2" class="chat-premium-launcher" aria-controls="admin-chat-window-v2" aria-expanded="false">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
        </svg>
    </button>

    <section id="admin-chat-window-v2" class="chat-premium-window chat-premium-window--admin fixed inset-x-0 bottom-0 top-0 hidden sm:absolute sm:inset-auto sm:bottom-20 sm:right-0" aria-hidden="true">
        <header class="chat-premium-header shrink-0">
            <div class="flex items-start justify-between gap-3">
                <div class="flex min-w-0 items-start gap-3">
                    <span class="chat-premium-avatar">AD</span>
                    <div class="min-w-0">
                        <div class="chat-premium-badge">
                            <span class="chat-premium-status-dot is-online"></span>
                            <span><?php echo e(__('admin_chat.online')); ?></span>
                        </div>
                        <h3 class="mt-3 truncate text-lg font-semibold"><?php echo e(__('admin_chat.title')); ?></h3>
                        <p class="mt-1 text-sm leading-5 text-white/80 sm:truncate"><?php echo e(__('admin_chat.subtitle')); ?></p>
                    </div>
                </div>
                <button type="button" id="admin-chat-close-v2" class="chat-premium-close" aria-label="Close">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </header>

        <div class="chat-premium-body flex min-h-0 flex-1 flex-col">
            <div id="admin-list-view-v2" class="flex min-h-0 flex-1 flex-col">
                <div class="shrink-0 border-b border-slate-200/70 bg-white/80 px-4 py-4 sm:px-5">
                    <div class="mb-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('admin_chat.select_user')); ?></p>
                        <h4 class="mt-2 text-sm font-semibold text-slate-900"><?php echo e(__('admin_chat.title')); ?></h4>
                        <p class="mt-1 text-xs leading-5 text-slate-500"><?php echo e(__('admin_chat.recipient_hint')); ?></p>
                    </div>
                    <label for="admin-user-search-v2" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-500"><?php echo e(__('admin_chat.select_user')); ?></label>
                    <input id="admin-user-search-v2" type="text" class="chat-premium-search" placeholder="<?php echo e(__('admin_chat.select_user_placeholder')); ?>">
                    <div id="admin-user-picker-list-v2" class="chat-premium-scroll mt-3 max-h-36 space-y-2 sm:max-h-44"></div>
                </div>
                <div id="conversations-items-v2" class="chat-premium-scroll min-h-0 flex-1 px-4 py-4 sm:px-5">
                    <div class="chat-premium-empty">
                        <span class="chat-premium-empty-icon">
                            <svg class="h-8 w-8 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </span>
                        <p class="text-sm font-semibold text-slate-800"><?php echo e(__('admin_chat.loading_conversations')); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e(__('admin_chat.recipient_hint')); ?></p>
                    </div>
                </div>
            </div>

            <div id="admin-thread-view-v2" class="hidden min-h-0 flex-1 flex-col">
                <div class="shrink-0 border-b border-slate-200/70 bg-white/85 px-4 py-4 sm:px-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex min-w-0 items-start gap-3">
                            <button type="button" id="admin-back-button-v2" class="chat-premium-icon-button mt-0.5 h-10 w-10 rounded-full">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <div class="flex min-w-0 items-start gap-3">
                                <span id="thread-avatar-v2" class="chat-premium-avatar bg-slate-100 text-slate-700">CL</span>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-400"><?php echo e(__('admin_chat.selected_recipient')); ?></p>
                                    <div class="mt-1 flex flex-wrap items-center gap-2">
                                        <p id="thread-name-v2" class="truncate text-sm font-semibold text-slate-900"></p>
                                        <span id="thread-status-dot-v2" class="chat-premium-status-dot is-disconnected"></span>
                                    </div>
                                    <p id="thread-email-v2" class="break-all text-xs text-slate-500 sm:truncate"></p>
                                    <p id="thread-status-v2" class="mt-1 text-xs font-medium text-slate-500"></p>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="admin-change-user-v2" class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900 sm:w-auto">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h12m0 0L13 4m3 3l-3 3M20 17H8m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                            <span><?php echo e(__('admin_chat.change_recipient')); ?></span>
                        </button>
                    </div>
                </div>

                <div id="chat-messages-container-v2" class="chat-premium-scroll min-h-0 flex-1 px-4 py-4 sm:px-5"></div>

                <div id="admin-thread-typing-wrap-v2" class="hidden px-4 pb-3 sm:px-5">
                    <div class="chat-premium-typing">
                        <span class="chat-premium-typing-dots" aria-hidden="true"><span></span><span></span><span></span></span>
                        <span id="admin-thread-typing-text-v2" class="text-xs font-medium"><?php echo e(__('admin_chat.typing')); ?></span>
                    </div>
                </div>

                <div class="chat-premium-composer shrink-0">
                    <div id="admin-file-preview-v2" class="chat-premium-file-chip hidden">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="chat-premium-file-icon"><i class="fas fa-paperclip text-sm"></i></span>
                            <div class="min-w-0">
                                <p id="admin-file-name-v2" class="truncate text-sm font-semibold text-slate-900"></p>
                                <p id="admin-file-size-v2" class="text-xs text-slate-500"></p>
                            </div>
                        </div>
                        <button type="button" id="admin-remove-file-v2" class="text-sm font-semibold text-rose-600">X</button>
                    </div>

                    <div class="chat-premium-composer-row">
                        <input type="file" id="admin-file-input-v2" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip">
                        <button type="button" id="admin-file-trigger-v2" class="chat-premium-icon-button" aria-label="<?php echo e(__('chat.attach_file')); ?>">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                        </button>
                        <textarea id="admin-chat-input-v2" rows="1" class="chat-premium-input" placeholder="<?php echo e(__('admin_chat.reply_placeholder')); ?>"></textarea>
                        <button type="button" id="admin-send-button-v2" class="chat-premium-send" aria-label="Send">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                    <p id="admin-chat-feedback-v2" class="mt-3 hidden text-xs font-medium"></p>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="admin-chat-image-modal-v2" class="chat-premium-image-modal">
    <button type="button" id="admin-chat-image-close-v2" class="absolute right-4 top-4 rounded-full border border-white/15 bg-white/10 px-3 py-2 text-sm font-semibold text-white">X</button>
    <a id="admin-chat-image-download-v2" class="absolute left-4 top-4 rounded-full border border-white/15 bg-white/10 px-3 py-2 text-sm font-semibold text-white" download><?php echo e(__('chat.download')); ?></a>
    <img id="admin-chat-image-full-v2" src="" alt="<?php echo e(__('chat.image_preview_alt')); ?>" class="chat-premium-image-view">
</div>

<script>
(() => {
    if (window.ValtrixAdminChatMounted) return;
    window.ValtrixAdminChatMounted = true;
    const i18n = <?php echo json_encode($adminChatV2I18n, 15, 512) ?>;
    const adminId = <?php echo e(auth()->id()); ?>;
    const locale = document.documentElement.lang || '<?php echo e(app()->getLocale()); ?>';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const el = {
        toggle: document.getElementById('admin-chat-toggle-v2'),
        window: document.getElementById('admin-chat-window-v2'),
        close: document.getElementById('admin-chat-close-v2'),
        backdrop: document.getElementById('admin-chat-backdrop-v2'),
        badge: document.getElementById('admin-unread-badge-v2'),
        search: document.getElementById('admin-user-search-v2'),
        picker: document.getElementById('admin-user-picker-list-v2'),
        conversations: document.getElementById('conversations-items-v2'),
        listView: document.getElementById('admin-list-view-v2'),
        threadView: document.getElementById('admin-thread-view-v2'),
        back: document.getElementById('admin-back-button-v2'),
        changeUser: document.getElementById('admin-change-user-v2'),
        threadName: document.getElementById('thread-name-v2'),
        threadEmail: document.getElementById('thread-email-v2'),
        threadStatus: document.getElementById('thread-status-v2'),
        threadStatusDot: document.getElementById('thread-status-dot-v2'),
        threadAvatar: document.getElementById('thread-avatar-v2'),
        messages: document.getElementById('chat-messages-container-v2'),
        typingWrap: document.getElementById('admin-thread-typing-wrap-v2'),
        typingText: document.getElementById('admin-thread-typing-text-v2'),
        input: document.getElementById('admin-chat-input-v2'),
        send: document.getElementById('admin-send-button-v2'),
        fileInput: document.getElementById('admin-file-input-v2'),
        fileTrigger: document.getElementById('admin-file-trigger-v2'),
        filePreview: document.getElementById('admin-file-preview-v2'),
        fileName: document.getElementById('admin-file-name-v2'),
        fileSize: document.getElementById('admin-file-size-v2'),
        removeFile: document.getElementById('admin-remove-file-v2'),
        feedback: document.getElementById('admin-chat-feedback-v2'),
        imageModal: document.getElementById('admin-chat-image-modal-v2'),
        imageClose: document.getElementById('admin-chat-image-close-v2'),
        imageDownload: document.getElementById('admin-chat-image-download-v2'),
        imageFull: document.getElementById('admin-chat-image-full-v2'),
    };
    const state = {
        open: false,
        activeUser: null,
        loadingList: false,
        loadingThread: false,
        sending: false,
        listPoll: null,
        threadPoll: null,
        unreadPoll: null,
        searchTimer: null,
        typingTimer: null,
        feedbackTimer: null,
        lastPing: 0,
        sig: '',
        file: null,
    };

    const esc = (v) => { const d = document.createElement('div'); d.textContent = v ?? ''; return d.innerHTML; };
    const time = (v) => { try { return v ? new Date(v).toLocaleTimeString(locale, { hour: '2-digit', minute: '2-digit' }) : ''; } catch { return ''; } };
    const size = (v) => { let b = Number(v || 0), u = ['B', 'KB', 'MB', 'GB'], i = 0; while (b >= 1024 && i < u.length - 1) { b /= 1024; i += 1; } return b ? `${b.toFixed(b >= 10 || i === 0 ? 0 : 1)} ${u[i]}` : ''; };
    const initials = (v) => String(v || '').trim().split(/\s+/).filter(Boolean).slice(0, 2).map((p) => p[0].toUpperCase()).join('') || 'CL';
    const presence = (v) => ['online', 'connected'].includes(v) ? v : 'disconnected';
    const presenceLabel = (v) => v === 'online' ? i18n.online : (v === 'connected' ? i18n.connected : i18n.disconnected);

    function resizeInput() {
        el.input.style.height = '0px';
        el.input.style.height = `${Math.min(el.input.scrollHeight, 120)}px`;
    }

    function syncComposerState() {
        const hasRecipient = Boolean(state.activeUser);
        const disabled = !hasRecipient || state.sending;
        el.input.disabled = disabled;
        el.send.disabled = disabled;
        el.fileTrigger.disabled = disabled;
        el.input.placeholder = hasRecipient ? i18n.replyPlaceholder : i18n.recipientRequired;
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

    function userName(user) {
        const label = [user?.first_name || '', user?.last_name || ''].join(' ').trim();
        return label || user?.display_name || i18n.userFallback;
    }

    function setThreadUser(user, userPresence) {
        const name = userName(user);
        const safe = presence(userPresence?.presence_status || user?.presence_status);
        state.activeUser = { id: Number(user?.id), name, email: user?.email || '', presence: safe };
        el.threadName.textContent = name;
        el.threadEmail.textContent = user?.email || '';
        el.threadStatus.textContent = presenceLabel(safe);
        el.threadStatusDot.className = `chat-premium-status-dot is-${safe}`;
        el.threadAvatar.textContent = initials(name);
    }

    function setTyping(show) {
        if (show && state.activeUser) {
            el.typingText.textContent = `${state.activeUser.name} - ${i18n.typing}`;
            el.typingWrap.classList.remove('hidden');
            return;
        }
        el.typingWrap.classList.add('hidden');
    }

    function listState(title, subtitle = '') {
        el.conversations.innerHTML = `<div class="space-y-3"><div class="flex items-center justify-between gap-3 px-1"><p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">${esc(i18n.recentConversations)}</p></div><div class="chat-premium-empty"><span class="chat-premium-empty-icon"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg></span><div class="space-y-2"><p class="text-sm font-semibold text-slate-800">${esc(title)}</p>${subtitle ? `<p class="text-xs text-slate-500">${esc(subtitle)}</p>` : ''}</div></div></div>`;
    }

    function threadState(title, subtitle = '') {
        el.messages.innerHTML = `<div class="chat-premium-empty"><span class="chat-premium-empty-icon"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg></span><div class="space-y-2"><p class="text-sm font-semibold text-slate-800">${esc(title)}</p>${subtitle ? `<p class="text-xs text-slate-500">${esc(subtitle)}</p>` : ''}</div></div>`;
    }

    function attachmentHtml(msg, outgoing) {
        if (!msg.attachment_path) return '';
        const url = msg.attachment_url || `/storage/${msg.attachment_path}`;
        const name = msg.attachment_name || i18n.fileLabel;
        const fsize = msg.formatted_attachment_size || size(msg.attachment_size);
        if (msg.is_image_attachment || (msg.attachment_type || '').startsWith('image/')) {
            return `<button type="button" class="chat-premium-attachment w-full overflow-hidden text-left" data-admin-chat-image="${esc(url)}"><img src="${esc(url)}" alt="${esc(name)}" class="chat-premium-image"></button>`;
        }
        return `<a href="${esc(url)}" target="_blank" rel="noopener" class="chat-premium-attachment chat-premium-file"><span class="chat-premium-file-icon"><i class="fas fa-file-alt text-sm"></i></span><span class="min-w-0 flex-1"><span class="block truncate text-sm font-semibold">${esc(name)}</span><span class="mt-1 block text-xs ${outgoing ? 'text-white/75' : 'text-slate-500'}">${esc(fsize)}</span></span></a>`;
    }

    function messageHtml(msg) {
        const outgoing = Number(msg.sender_id) === Number(adminId);
        const name = outgoing ? 'Admin' : (msg.sender?.display_name || msg.sender_display_name || state.activeUser?.name || i18n.userFallback);
        return `<div class="chat-premium-message-row ${outgoing ? 'chat-premium-message-row--outgoing' : ''}">${outgoing ? '' : `<span class="chat-premium-avatar bg-white text-slate-700">${esc(initials(name))}</span>`}<div class="chat-premium-message-bubble">${msg.message ? `<p class="text-sm whitespace-pre-wrap break-words leading-6">${esc(msg.message)}</p>` : ''}${attachmentHtml(msg, outgoing)}<div class="chat-premium-meta"><span>${esc(name)}</span><span>&middot;</span><span>${esc(time(msg.created_at))}</span></div></div></div>`;
    }

    function renderThread(messages) {
        if (!Array.isArray(messages) || !messages.length) {
            state.sig = '';
            threadState(i18n.noMessages, i18n.startConversation);
            return;
        }
        const sig = messages.map((m) => `${m.id}:${m.updated_at || m.created_at || ''}`).join('|');
        const stick = el.messages.scrollHeight - el.messages.scrollTop - el.messages.clientHeight < 72;
        if (sig === state.sig) {
            if (stick) el.messages.scrollTop = el.messages.scrollHeight;
            return;
        }
        state.sig = sig;
        el.messages.innerHTML = `<div class="space-y-4">${messages.map(messageHtml).join('')}</div>`;
        el.messages.scrollTop = el.messages.scrollHeight;
    }

    function userCard(user, preview = '', unread = 0) {
        const safe = presence(user?.presence_status);
        const label = userName(user);
        return `<button type="button" class="chat-premium-user-item" data-user-id="${Number(user.id)}" data-user-name="${esc(label)}" data-user-email="${esc(user.email || '')}" data-user-presence="${safe}"><div class="flex items-start gap-3"><span class="chat-premium-avatar bg-slate-100 text-slate-700">${esc(initials(label))}</span><div class="min-w-0 flex-1"><div class="flex items-center justify-between gap-2"><p class="truncate text-sm font-semibold text-slate-900">${esc(label)}</p>${unread > 0 ? `<span class="rounded-full bg-rose-500 px-2 py-0.5 text-[11px] font-bold text-white">${unread}</span>` : ''}</div><p class="mt-1 truncate text-xs text-slate-500">${esc(user.email || '')}</p><div class="mt-2 flex items-center gap-2"><span class="chat-premium-status-dot is-${safe}"></span><span class="text-xs font-medium text-slate-500">${esc(presenceLabel(safe))}</span></div>${preview ? `<p class="mt-2 truncate text-xs text-slate-500">${esc(preview)}</p>` : ''}</div></div></button>`;
    }

    function bindUserCards(scope) {
        scope.querySelectorAll('[data-user-id]').forEach((button) => {
            button.addEventListener('click', () => openThread({
                id: Number(button.getAttribute('data-user-id')),
                first_name: button.getAttribute('data-user-name'),
                last_name: '',
                email: button.getAttribute('data-user-email'),
                presence_status: button.getAttribute('data-user-presence'),
                display_name: button.getAttribute('data-user-name'),
            }));
        });
    }

    async function json(url, options = {}) {
        const response = await fetch(url, {
            credentials: 'same-origin',
            ...options,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                ...(options.headers || {}),
            },
        });
        const text = await response.text();
        let data = null;
        try { data = text ? JSON.parse(text) : {}; } catch {}
        return { response, data };
    }

    async function loadUsers(search = '') {
        const url = search ? `<?php echo e(route("chat.users")); ?>?q=${encodeURIComponent(search)}` : '<?php echo e(route("chat.users")); ?>';
        try {
            const { response, data } = await json(url);
            if (!response.ok || !data || !data.success || !Array.isArray(data.users) || !data.users.length) {
                el.picker.innerHTML = `<div class="rounded-2xl border border-dashed border-slate-200 px-4 py-4 text-center text-xs text-slate-500">${esc(i18n.noUsersAvailable)}</div>`;
                return;
            }
            el.picker.innerHTML = `<div class="chat-premium-user-list">${data.users.map((user) => userCard(user, i18n.messagesWillAppear, Number(user.unread_count || 0))).join('')}</div>`;
            bindUserCards(el.picker);
        } catch {
            el.picker.innerHTML = `<div class="rounded-2xl border border-dashed border-slate-200 px-4 py-4 text-center text-xs text-slate-500">${esc(i18n.noUsersAvailable)}</div>`;
        }
    }

    async function loadConversations() {
        if (state.loadingList || state.activeUser) return;
        state.loadingList = true;
        try {
            const { response, data } = await json('<?php echo e(route("chat.messages")); ?>');
            if (!response.ok || !data || !data.success) {
                listState(i18n.loadingError, data?.message || i18n.connectionError);
                return;
            }
            if (!Array.isArray(data.conversations) || !data.conversations.length) {
                listState(i18n.noConversations, i18n.recipientHint);
                return;
            }
            const activeConversations = data.conversations.filter((conv) => Boolean(conv.last_message));
            const availableClients = data.conversations.filter((conv) => !conv.last_message);
            const sections = [];

            if (activeConversations.length) {
                sections.push(`<div class="space-y-3"><div class="flex items-center justify-between gap-3 px-1"><p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">${esc(i18n.recentConversations)}</p></div><div class="chat-premium-user-list">${activeConversations.map((conv) => userCard(conv.user, conv.last_message?.message || conv.last_message?.attachment_name || i18n.noMessages, Number(conv.unread_count || 0))).join('')}</div></div>`);
            }

            if (availableClients.length) {
                sections.push(`<div class="space-y-3"><div class="flex items-center justify-between gap-3 px-1"><p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">${esc(i18n.selectUser)}</p></div><div class="chat-premium-user-list">${availableClients.map((conv) => userCard(conv.user, i18n.messagesWillAppear, Number(conv.unread_count || 0))).join('')}</div></div>`);
            }

            el.conversations.innerHTML = `<div class="space-y-4">${sections.join('')}</div>`;
            bindUserCards(el.conversations);
            unreadCount();
        } catch (error) {
            listState(i18n.loadingError, error.message || i18n.connectionError);
        } finally {
            state.loadingList = false;
        }
    }

    async function loadThread() {
        if (!state.activeUser || state.loadingThread) return;
        state.loadingThread = true;
        try {
            const { response, data } = await json(`<?php echo e(route("chat.messages")); ?>/${state.activeUser.id}`);
            if (!response.ok || !data || !data.success) {
                threadState(i18n.loadingMessagesError, data?.message || i18n.connectionError);
                return;
            }
            setThreadUser(data.chat_partner || state.activeUser, data.user_presence || state.activeUser);
            setTyping(Boolean(data.user_typing));
            renderThread(data.messages || []);
            el.badge.classList.add('hidden');
        } catch (error) {
            threadState(i18n.loadingMessagesError, error.message || i18n.connectionError);
        } finally {
            state.loadingThread = false;
        }
    }

    async function unreadCount() {
        if (state.open && state.activeUser) {
            el.badge.classList.add('hidden');
            return;
        }
        try {
            const { response, data } = await json('<?php echo e(route("chat.unread-count")); ?>');
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
        if (!csrfToken || !state.activeUser) return;
        const now = Date.now();
        if (isTyping && now - state.lastPing < 1800) return;
        state.lastPing = isTyping ? now : 0;
        try {
            await json('<?php echo e(route("chat.typing")); ?>', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                body: JSON.stringify({ receiver_id: state.activeUser.id, is_typing: Boolean(isTyping) }),
            });
        } catch {}
    }

    function clearFile() {
        state.file = null;
        el.fileInput.value = '';
        el.filePreview.classList.add('hidden');
        el.fileName.textContent = '';
        el.fileSize.textContent = '';
    }

    async function sendMessage() {
        const message = el.input.value.trim();
        if (!state.activeUser) {
            setFeedback(i18n.recipientRequired, 'error');
            return;
        }
        if (state.sending || (!message && !state.file)) return;
        if (!csrfToken) {
            setFeedback(i18n.connectionError, 'error');
            return;
        }
        state.sending = true;
        syncComposerState();
        clearTimeout(state.typingTimer);
        sendTyping(false);
        const body = new FormData();
        body.append('receiver_id', state.activeUser.id);
        if (message) body.append('message', message);
        if (state.file) body.append('attachment', state.file);
        try {
            const { response, data } = await json('<?php echo e(route("chat.send")); ?>', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body,
            });
            if (response.ok && data && data.success) {
                el.input.value = '';
                resizeInput();
                clearFile();
                state.sig = '';
                setFeedback('');
                await loadThread();
            } else if (response.status === 422) {
                setFeedback(data?.message || i18n.connectionError, 'error');
            } else {
                setFeedback(i18n.connectionError, 'error');
            }
        } catch {
            setFeedback(i18n.connectionError, 'error');
        } finally {
            state.sending = false;
            syncComposerState();
            el.input.focus();
        }
    }

    function startListPolling() {
        stopListPolling();
        state.listPoll = setInterval(() => {
            loadUsers(el.search.value.trim());
            loadConversations();
        }, 6000);
    }

    function stopListPolling() {
        if (state.listPoll) clearInterval(state.listPoll);
        state.listPoll = null;
    }

    function startThreadPolling() {
        stopThreadPolling();
        state.threadPoll = setInterval(loadThread, 3200);
    }

    function stopThreadPolling() {
        if (state.threadPoll) clearInterval(state.threadPoll);
        state.threadPoll = null;
    }

    function lockBody(locked) {
        if (window.innerWidth < 640) document.body.classList.toggle('overflow-hidden', locked);
        if (!locked && !el.imageModal.classList.contains('is-open')) document.body.classList.remove('overflow-hidden');
    }

    function openThread(user) {
        state.sig = '';
        stopListPolling();
        clearFile();
        setFeedback('');
        el.badge.classList.add('hidden');
        el.listView.classList.add('hidden');
        el.threadView.classList.remove('hidden');
        setThreadUser(user, user);
        syncComposerState();
        threadState(i18n.loadingMessages, i18n.startConversation);
        startThreadPolling();
        loadThread();
        setTimeout(() => el.input.focus(), 100);
    }

    function backToList() {
        state.sig = '';
        stopThreadPolling();
        setTyping(false);
        sendTyping(false);
        clearFile();
        setFeedback('');
        state.activeUser = null;
        syncComposerState();
        el.threadView.classList.add('hidden');
        el.listView.classList.remove('hidden');
        loadUsers(el.search.value.trim());
        loadConversations();
        startListPolling();
        setTimeout(() => el.search.focus(), 80);
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
        if (!state.open) {
            stopListPolling();
            stopThreadPolling();
            sendTyping(false);
            syncComposerState();
            return;
        }
        if (state.activeUser) {
            startThreadPolling();
            loadThread();
        } else {
            loadUsers(el.search.value.trim());
            loadConversations();
            startListPolling();
        }
        unreadCount();
    }

    function toggle(force) { setOpen(typeof force === 'boolean' ? force : !state.open); }
    function openImage(src) { if (!src) return; el.imageFull.src = src; el.imageDownload.href = src; el.imageModal.classList.add('is-open'); document.body.classList.add('overflow-hidden'); }
    function closeImage() { el.imageModal.classList.remove('is-open'); el.imageFull.src = ''; el.imageDownload.removeAttribute('href'); if (!state.open || window.innerWidth >= 640) document.body.classList.remove('overflow-hidden'); }

    el.toggle.addEventListener('click', () => toggle());
    el.close.addEventListener('click', () => toggle(false));
    el.backdrop.addEventListener('click', () => toggle(false));
    el.back.addEventListener('click', backToList);
    el.changeUser.addEventListener('click', backToList);
    el.search.addEventListener('input', () => {
        clearTimeout(state.searchTimer);
        state.searchTimer = setTimeout(() => loadUsers(el.search.value.trim()), 220);
    });
    el.fileTrigger.addEventListener('click', () => el.fileInput.click());
    el.fileInput.addEventListener('change', (event) => {
        state.file = event.target.files?.[0] || null;
        if (!state.file) { clearFile(); return; }
        el.fileName.textContent = state.file.name;
        el.fileSize.textContent = size(state.file.size);
        el.filePreview.classList.remove('hidden');
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
        const trigger = event.target.closest('[data-admin-chat-image]');
        if (trigger) openImage(trigger.getAttribute('data-admin-chat-image'));
    });
    el.imageClose.addEventListener('click', closeImage);
    el.imageModal.addEventListener('click', (event) => { if (event.target === el.imageModal) closeImage(); });
    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        if (el.imageModal.classList.contains('is-open')) { closeImage(); return; }
        if (!state.open) return;
        if (state.activeUser) { backToList(); return; }
        toggle(false);
    });

    resizeInput();
    syncComposerState();
    state.unreadPoll = setInterval(unreadCount, 12000);
    unreadCount();
    window.toggleAdminChatV2 = toggle;
})();
</script>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/admin-chat-widget-v2.blade.php ENDPATH**/ ?>