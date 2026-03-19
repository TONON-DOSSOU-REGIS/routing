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

<div class="relative inline-block" data-user-id="{{ $currentUserId }}" data-is-admin="{{ $isAdminBell ? '1' : '0' }}">
    <button id="notification-bell" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full transition-colors duration-200">
        <i class="fas fa-bell text-xl"></i>
        <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
            0
        </span>
    </button>

    <!-- Dropdown Menu -->
    <div id="notification-dropdown" class="fixed left-1/2 top-16 w-[92vw] max-w-[28rem] -translate-x-1/2 md:absolute md:left-auto md:right-0 md:top-auto md:mt-2 md:w-96 md:max-w-[90vw] md:translate-x-0 bg-white/95 backdrop-blur rounded-xl shadow-2xl border border-gray-200 ring-1 ring-black/5 overflow-hidden z-[9999] hidden">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">{{ __('notifications.title') }}</h3>
            <p class="text-sm text-gray-600">{{ __('notifications.subtitle') }}</p>
        </div>

        <div id="notification-list" class="max-h-[60vh] overflow-y-auto divide-y divide-gray-100">
            <!-- Notifications will be loaded here -->
            <div class="p-4 text-center text-gray-500">
                <i class="fas fa-spinner fa-spin text-xl mb-2"></i>
                <p>{{ __('notifications.loading_short') }}</p>
            </div>
        </div>

        <div class="p-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
            <div class="flex justify-between items-center">
                <button id="mark-all-read" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    {{ __('notifications.mark_all_read') }}
                </button>
                <a href="{{ localized_route('notifications.index', ['locale' => app()->getLocale()]) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    {{ __('notifications.view_all') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bell = document.getElementById('notification-bell');
    const dropdown = document.getElementById('notification-dropdown');
    const count = document.getElementById('notification-count');
    const list = document.getElementById('notification-list');
    const markAllRead = document.getElementById('mark-all-read');
    const root = bell?.closest('[data-user-id]');
    const userId = root?.getAttribute('data-user-id');
    const isAdmin = root?.getAttribute('data-is-admin') === '1';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const locale = document.documentElement.lang || '{{ app()->getLocale() }}';
    const i18n = @json($notificationBellI18n);

    if (!bell || !dropdown || !count || !list || !markAllRead || !userId) {
        return;
    }

    function requireCsrf() {
        if (!csrfToken) {
            console.error('CSRF token missing');
            return false;
        }
        return true;
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

    document.addEventListener('click', enableSound, { once: true });
    document.addEventListener('pointerdown', enableSound, { once: true });
    document.addEventListener('keydown', enableSound, { once: true });
    document.addEventListener('touchstart', enableSound, { once: true });

    // Toggle dropdown
    bell.addEventListener('click', function(e) {
        e.stopPropagation();
        isOpen = !isOpen;

        if (isOpen) {
            dropdown.classList.remove('hidden');
            loadNotifications();
        } else {
            dropdown.classList.add('hidden');
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
            isOpen = false;
        }
    });

    // Load notifications
    function loadNotifications() {
        const locale = window.location.pathname.split('/')[1] || 'fr';
        fetch(`/${locale}/notifications/recent`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderNotifications(data.notifications);
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                list.innerHTML = `<div class="p-4 text-center text-gray-500"><p>${i18n.errorLoadingShort}</p></div>`;
            });
    }

    // Render notifications
    function renderNotifications(notifications) {
        if (notifications.length === 0) {
            list.innerHTML = `<div class="p-4 text-center text-gray-500"><i class="fas fa-bell-slash text-2xl mb-2"></i><p>${i18n.noneTitle}</p></div>`;
            return;
        }

        list.innerHTML = notifications.map(notification => `
            <div class="p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer notification-item ${!notification.is_read ? 'bg-blue-50' : ''}"
                 data-id="${notification.id}"
                 onclick="markAsRead(${notification.id})">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 ${getIconColor(notification.type)} rounded-full flex items-center justify-center">
                            <i class="${getIcon(notification.type)} text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            ${notification.title}
                        </p>
                        <p class="text-sm text-gray-600 line-clamp-2">
                            ${notification.message}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            ${formatDate(notification.created_at)}
                        </p>
                    </div>
                    ${!notification.is_read ? '<div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>' : ''}
                </div>
            </div>
        `).join('');
    }

    // Mark notification as read
    window.markAsRead = function(id) {
        const locale = window.location.pathname.split('/')[1] || 'fr';
        if (!requireCsrf()) return;
        fetch(`/${locale}/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(() => {
            updateUnreadCount({ silent: true });
            // Reload notifications to update UI
            loadNotifications();
        })
        .catch(error => console.error('Error marking as read:', error));
    };

    // Mark all as read
    markAllRead.addEventListener('click', function() {
        const locale = window.location.pathname.split('/')[1] || 'fr';
        if (!requireCsrf()) return;
        fetch(`/${locale}/notifications/mark-all-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(() => {
            updateUnreadCount({ silent: true });
            loadNotifications();
        })
        .catch(error => console.error('Error marking all as read:', error));
    });

    // Update unread count
    function updateUnreadCount(options = {}) {
        const { silent = false } = options;
        const locale = window.location.pathname.split('/')[1] || 'fr';
        fetch(`/${locale}/notifications/unread-count`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                const newCount = data.success ? Number(data.count || 0) : 0;
                if (!silent && lastUnreadCount !== null && newCount > lastUnreadCount) {
                    playNotificationSound();
                }
                lastUnreadCount = newCount;

                if (data.success && newCount > 0) {
                    count.textContent = newCount > 99 ? '99+' : newCount;
                    count.classList.remove('hidden');
                } else {
                    count.classList.add('hidden');
                }
            })
            .catch(error => console.error('Error updating count:', error));
    }

    // Helper functions
    function getIcon(type) {
        const icons = {
            'transaction': 'fas fa-exchange-alt',
            'message': 'fas fa-envelope',
            'account': 'fas fa-user',
            'alert': 'fas fa-exclamation-triangle',
            'system': 'fas fa-cog'
        };
        return icons[type] || 'fas fa-bell';
    }

    function getIconColor(type) {
        const colors = {
            'transaction': 'bg-green-500',
            'message': 'bg-blue-500',
            'account': 'bg-blue-500',
            'alert': 'bg-red-500',
            'system': 'bg-gray-500'
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
        return date.toLocaleDateString(locale);
    }

    // Initial load of unread count
    updateUnreadCount({ silent: true });

    // Real-time updates with Echo (fallback to polling)
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
        } catch (e) {
            // Ignore audio errors
        }
    }

    if (window.Echo && userId) {
        try {
            window.Echo.private(`user.${userId}`)
                .listen('.notification.created', (e) => {
                    const payload = e.notification || e;
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

    function startUnreadPolling() {
        if (unreadTimer) return;
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

    document.addEventListener('visibilitychange', () => {
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

    startUnreadPolling();
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

#notification-list {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

#notification-list::-webkit-scrollbar {
    width: 8px;
}

#notification-list::-webkit-scrollbar-track {
    background: transparent;
}

#notification-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 9999px;
}\n</style>






