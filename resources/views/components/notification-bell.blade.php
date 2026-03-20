@props(['user' => null])
@php
    $resolvedUser = $user ?? auth()->user();
    $currentUserId = $resolvedUser?->id ?? auth()->id();
    $isAdminBell = $resolvedUser?->isAdmin() ?? false;
    $notificationBellI18n = [
        'loadingShort' => __('notifications.loading_short'),
        'errorLoadingShort' => __('notifications.error_loading_short'),
        'noneTitle' => __('notifications.none_title'),
        'timeJustNow' => __('notifications.time_just_now'),
        'timeMinutesAgo' => __('notifications.time_minutes_ago'),
        'timeHoursAgo' => __('notifications.time_hours_ago'),
        'timeDaysAgo' => __('notifications.time_days_ago'),
    ];
@endphp

<div class="relative inline-flex shrink-0" data-notification-root data-user-id="{{ $currentUserId }}" data-is-admin="{{ $isAdminBell ? '1' : '0' }}">
    <button
        type="button"
        data-notification-bell
        class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 shadow-sm transition-colors duration-200 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
        aria-label="{{ __('dashboard.notifications') }}"
        aria-haspopup="dialog"
        aria-expanded="false"
    >
        <i class="fas fa-bell text-lg"></i>
        <span id="notification-count" data-notification-count class="absolute -top-1 -right-1 hidden h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white shadow-sm">
            0
        </span>
    </button>

    <div data-notification-backdrop class="fixed inset-0 z-[9997] hidden bg-slate-950/30 backdrop-blur-[1px] md:hidden"></div>

    <div
        data-notification-dropdown
        class="fixed inset-x-3 bottom-3 top-[calc(env(safe-area-inset-top,0px)+4.75rem)] z-[9998] hidden flex-col overflow-hidden rounded-[28px] border border-slate-200 bg-white/95 shadow-2xl ring-1 ring-black/5 backdrop-blur md:absolute md:bottom-auto md:left-auto md:right-0 md:top-full md:mt-3 md:max-h-[min(70vh,42rem)] md:w-[26rem] md:max-w-[min(26rem,calc(100vw-2rem))] md:rounded-2xl"
        role="dialog"
        aria-modal="true"
        aria-hidden="true"
    >
        <div class="flex items-start justify-between gap-3 border-b border-slate-200 px-4 py-4 sm:px-5">
            <div class="min-w-0">
                <h3 class="text-lg font-semibold text-slate-800">{{ __('notifications.title') }}</h3>
                <p class="mt-1 text-sm text-slate-500">{{ __('notifications.subtitle') }}</p>
            </div>
            <button
                type="button"
                data-notification-close
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 md:hidden"
                aria-label="{{ __('common.close') }}"
            >
                <i class="fas fa-xmark"></i>
            </button>
        </div>

        <div data-notification-list class="notification-list flex-1 overflow-y-auto divide-y divide-slate-100 overscroll-contain">
            <div class="p-5 text-center text-slate-500">
                <i class="fas fa-spinner fa-spin text-xl"></i>
                <p class="mt-3 text-sm">{{ __('notifications.loading_short') }}</p>
            </div>
        </div>

        <div class="border-t border-slate-200 bg-slate-50/90 px-4 py-3 sm:px-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <button
                    type="button"
                    data-mark-all-read
                    class="inline-flex items-center justify-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                >
                    <i class="fas fa-check-double text-xs"></i>
                    {{ __('notifications.mark_all_read') }}
                </button>
                <a
                    href="{{ localized_route('notifications.index', ['locale' => app()->getLocale()]) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                    {{ __('notifications.view_all') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-notification-root]').forEach(function (root) {
        if (root.dataset.notificationInitialized === '1') {
            return;
        }

        root.dataset.notificationInitialized = '1';

        const bell = root.querySelector('[data-notification-bell]');
        const dropdown = root.querySelector('[data-notification-dropdown]');
        const backdrop = root.querySelector('[data-notification-backdrop]');
        const closeButton = root.querySelector('[data-notification-close]');
        const count = root.querySelector('[data-notification-count]');
        const list = root.querySelector('[data-notification-list]');
        const markAllRead = root.querySelector('[data-mark-all-read]');
        const userId = root.getAttribute('data-user-id');
        const isAdmin = root.getAttribute('data-is-admin') === '1';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const fallbackLocale = document.documentElement.lang || '{{ app()->getLocale() }}';
        const i18n = @json($notificationBellI18n);

        if (!bell || !dropdown || !backdrop || !closeButton || !count || !list || !markAllRead || !userId) {
            return;
        }

        let isOpen = false;
        let soundEnabled = localStorage.getItem('notification_sound_enabled') === '1';
        let lastUnreadCount = null;
        let audioContext = null;
        let notificationOutputNode = null;
        let notificationMasterGain = null;
        let unreadTimer = null;
        const unreadPollingIntervalMs = isAdmin ? 3000 : 10000;
        const notificationSoundProfile = isAdmin
            ? { notes: [740, 932, 1175], step: 0.085, duration: 0.35, bodyGain: 0.26, shimmerGain: 0.18, masterGain: 1.34 }
            : { notes: [698, 880, 1047], step: 0.09, duration: 0.33, bodyGain: 0.24, shimmerGain: 0.16, masterGain: 1.26 };

        function resolveLocale() {
            const pathLocale = window.location.pathname.split('/').filter(Boolean)[0];
            return pathLocale || fallbackLocale;
        }

        function isDesktopDropdown() {
            return window.innerWidth >= 768;
        }

        function setPageScrollLock(shouldLock) {
            const lock = shouldLock && !isDesktopDropdown();
            document.documentElement.classList.toggle('overflow-hidden', lock);
            document.body.classList.toggle('overflow-hidden', lock);
        }

        function setOpenState(next, options = {}) {
            const { shouldLoad = next } = options;
            isOpen = next;
            bell.setAttribute('aria-expanded', next ? 'true' : 'false');
            dropdown.setAttribute('aria-hidden', next ? 'false' : 'true');
            dropdown.classList.toggle('hidden', !next);
            dropdown.classList.toggle('flex', next);
            backdrop.classList.toggle('hidden', !next || isDesktopDropdown());
            setPageScrollLock(next);

            if (next && shouldLoad) {
                loadNotifications();
            }
        }

        function requireCsrf() {
            if (!csrfToken) {
                console.error('CSRF token missing');
                return false;
            }

            return true;
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, function (character) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;',
                }[character];
            });
        }

        function ensureAudioContext() {
            const AudioContextCtor = window.AudioContext || window.webkitAudioContext;

            if (!AudioContextCtor) {
                return null;
            }

            if (!audioContext) {
                audioContext = new AudioContextCtor();
            }

            if (audioContext.state === 'suspended') {
                audioContext.resume().catch(() => {});
            }

            return audioContext;
        }

        function ensureNotificationOutput(ctx) {
            if (notificationOutputNode && notificationMasterGain) {
                notificationMasterGain.gain.value = notificationSoundProfile.masterGain;
                return notificationOutputNode;
            }

            const compressor = ctx.createDynamicsCompressor();
            compressor.threshold.setValueAtTime(-26, ctx.currentTime);
            compressor.knee.setValueAtTime(18, ctx.currentTime);
            compressor.ratio.setValueAtTime(9, ctx.currentTime);
            compressor.attack.setValueAtTime(0.003, ctx.currentTime);
            compressor.release.setValueAtTime(0.2, ctx.currentTime);

            notificationMasterGain = ctx.createGain();
            notificationMasterGain.gain.value = notificationSoundProfile.masterGain;

            compressor.connect(notificationMasterGain);
            notificationMasterGain.connect(ctx.destination);
            notificationOutputNode = compressor;

            return notificationOutputNode;
        }

        function enableSound() {
            soundEnabled = true;
            localStorage.setItem('notification_sound_enabled', '1');
            ensureAudioContext();
        }

        function getIcon(type) {
            const icons = {
                transaction: 'fas fa-exchange-alt',
                message: 'fas fa-envelope',
                account: 'fas fa-user',
                alert: 'fas fa-exclamation-triangle',
                system: 'fas fa-cog',
            };

            return icons[type] || 'fas fa-bell';
        }

        function getIconColor(type) {
            const colors = {
                transaction: 'bg-green-500',
                message: 'bg-blue-500',
                account: 'bg-blue-500',
                alert: 'bg-red-500',
                system: 'bg-gray-500',
            };

            return colors[type] || 'bg-gray-500';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);

            if (minutes < 1) return i18n.timeJustNow;
            if (minutes < 60) return i18n.timeMinutesAgo.replace(':minutes', minutes);
            if (hours < 24) return i18n.timeHoursAgo.replace(':hours', hours);
            if (days < 7) return i18n.timeDaysAgo.replace(':days', days);

            return date.toLocaleDateString(resolveLocale());
        }

        function renderLoadingState() {
            list.innerHTML = `
                <div class="p-5 text-center text-slate-500">
                    <i class="fas fa-spinner fa-spin text-xl"></i>
                    <p class="mt-3 text-sm">${escapeHtml(i18n.loadingShort)}</p>
                </div>
            `;
        }

        function renderEmptyState() {
            list.innerHTML = `
                <div class="p-6 text-center text-slate-500">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <i class="fas fa-bell-slash text-xl"></i>
                    </div>
                    <p class="mt-4 text-sm font-medium">${escapeHtml(i18n.noneTitle)}</p>
                </div>
            `;
        }

        function renderErrorState() {
            list.innerHTML = `
                <div class="p-5 text-center text-slate-500">
                    <p class="text-sm">${escapeHtml(i18n.errorLoadingShort)}</p>
                </div>
            `;
        }

        function renderNotifications(notifications) {
            if (!Array.isArray(notifications) || notifications.length === 0) {
                renderEmptyState();
                return;
            }

            list.innerHTML = notifications.map(function (notification) {
                const unread = !notification.is_read;

                return `
                    <button
                        type="button"
                        class="notification-item block w-full px-4 py-4 text-left transition hover:bg-slate-50 ${unread ? 'bg-blue-50/70' : ''}"
                        data-notification-id="${notification.id}"
                    >
                        <span class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl ${getIconColor(notification.type)}">
                                <i class="${getIcon(notification.type)} text-sm text-white"></i>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="flex items-start justify-between gap-3">
                                    <span class="block min-w-0">
                                        <span class="block truncate text-sm font-semibold text-slate-900">${escapeHtml(notification.title)}</span>
                                        <span class="line-clamp-2 mt-1 block text-sm leading-5 text-slate-600">${escapeHtml(notification.message)}</span>
                                    </span>
                                    ${unread ? '<span class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-blue-500"></span>' : ''}
                                </span>
                                <span class="mt-2 block text-xs font-medium text-slate-400">${escapeHtml(formatDate(notification.created_at))}</span>
                            </span>
                        </span>
                    </button>
                `;
            }).join('');
        }

        function markAsRead(id) {
            if (!requireCsrf()) {
                return;
            }

            fetch(`/${resolveLocale()}/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(() => {
                    updateUnreadCount({ silent: true });
                    loadNotifications();
                })
                .catch((error) => console.error('Error marking as read:', error));
        }

        function loadNotifications() {
            renderLoadingState();

            fetch(`/${resolveLocale()}/notifications/recent`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        renderNotifications(data.notifications);
                        return;
                    }

                    renderErrorState();
                })
                .catch((error) => {
                    console.error('Error loading notifications:', error);
                    renderErrorState();
                });
        }

        function updateUnreadCount(options = {}) {
            const { silent = false } = options;

            fetch(`/${resolveLocale()}/notifications/unread-count`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    const newCount = data.success ? Number(data.count || 0) : 0;

                    if (!silent && lastUnreadCount !== null && newCount > lastUnreadCount) {
                        playNotificationSound();
                    }

                    lastUnreadCount = newCount;

                    if (data.success && newCount > 0) {
                        count.textContent = newCount > 99 ? '99+' : String(newCount);
                        count.classList.remove('hidden');
                        count.classList.add('flex');
                    } else {
                        count.classList.add('hidden');
                        count.classList.remove('flex');
                    }
                })
                .catch((error) => console.error('Error updating count:', error));
        }

        function playNotificationLayer(ctx, outputNode, frequency, startTime, gainAmount, duration, waveType = 'triangle', detune = 0) {
            const oscillator = ctx.createOscillator();
            const gainNode = ctx.createGain();
            oscillator.type = waveType;
            oscillator.frequency.value = frequency;
            oscillator.detune.value = detune;
            gainNode.gain.setValueAtTime(0.0001, startTime);
            gainNode.gain.exponentialRampToValueAtTime(gainAmount, startTime + 0.014);
            gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);
            oscillator.connect(gainNode);
            gainNode.connect(outputNode);
            oscillator.start(startTime);
            oscillator.stop(startTime + duration);
        }

        function playNotificationSound() {
            if (!soundEnabled) {
                return;
            }

            try {
                const ctx = ensureAudioContext();

                if (!ctx) {
                    return;
                }

                const startTime = ctx.currentTime + 0.01;
                const p = notificationSoundProfile;
                const outputNode = ensureNotificationOutput(ctx);

                p.notes.forEach((note, index) => {
                    const toneStart = startTime + (index * p.step);
                    playNotificationLayer(ctx, outputNode, note, toneStart, p.bodyGain, p.duration, 'triangle', 0);
                    playNotificationLayer(ctx, outputNode, note, toneStart + 0.008, p.shimmerGain, p.duration * 0.8, 'sine', 6);
                });
            } catch (error) {
                // Ignore audio errors.
            }
        }

        function startUnreadPolling() {
            if (unreadTimer) {
                return;
            }

            unreadTimer = setInterval(() => {
                if (document.visibilityState === 'visible') {
                    updateUnreadCount();

                    if (isOpen) {
                        loadNotifications();
                    }
                }
            }, unreadPollingIntervalMs);
        }

        function stopUnreadPolling() {
            if (unreadTimer) {
                clearInterval(unreadTimer);
                unreadTimer = null;
            }
        }

        document.addEventListener('click', enableSound, { once: true });
        document.addEventListener('pointerdown', enableSound, { once: true });
        document.addEventListener('keydown', enableSound, { once: true });
        document.addEventListener('touchstart', enableSound, { once: true });

        bell.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            setOpenState(!isOpen);
        });

        closeButton.addEventListener('click', function () {
            setOpenState(false, { shouldLoad: false });
        });

        backdrop.addEventListener('click', function () {
            setOpenState(false, { shouldLoad: false });
        });

        document.addEventListener('click', function (event) {
            if (isOpen && !root.contains(event.target)) {
                setOpenState(false, { shouldLoad: false });
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isOpen) {
                setOpenState(false, { shouldLoad: false });
            }
        });

        window.addEventListener('resize', function () {
            if (!isOpen) {
                return;
            }

            backdrop.classList.toggle('hidden', isDesktopDropdown());
            setPageScrollLock(true);
        });

        list.addEventListener('click', function (event) {
            const target = event.target.closest('[data-notification-id]');

            if (!target) {
                return;
            }

            markAsRead(target.getAttribute('data-notification-id'));
        });

        markAllRead.addEventListener('click', function () {
            if (!requireCsrf()) {
                return;
            }

            fetch(`/${resolveLocale()}/notifications/mark-all-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(() => {
                    updateUnreadCount({ silent: true });
                    loadNotifications();
                })
                .catch((error) => console.error('Error marking all as read:', error));
        });

        if (window.Echo && userId) {
            try {
                window.Echo.private(`user.${userId}`)
                    .listen('.notification.created', function (event) {
                        const payload = event.notification || event;
                        updateUnreadCount({ silent: true });

                        if (isOpen) {
                            loadNotifications();
                        }

                        playNotificationSound();
                        window.dispatchEvent(new CustomEvent('notification.created', { detail: payload }));
                    });
            } catch (error) {
                console.warn('Echo channel subscription failed, fallback polling remains active.', error);
            }
        }

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                updateUnreadCount({ silent: true });

                if (isOpen) {
                    loadNotifications();
                }

                startUnreadPolling();
            } else {
                stopUnreadPolling();
            }
        });

        updateUnreadCount({ silent: true });
        startUnreadPolling();
    });
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
}

.notification-list {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

.notification-list::-webkit-scrollbar {
    width: 8px;
}

.notification-list::-webkit-scrollbar-track {
    background: transparent;
}

.notification-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 9999px;
}
</style>
