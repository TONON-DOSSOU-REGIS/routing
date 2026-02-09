@props(['user' => null])
@php
    $currentUserId = $user?->id ?? auth()->id();
@endphp

<div class="relative inline-block" data-user-id="{{ $currentUserId }}">
    <button id="notification-bell" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full transition-colors duration-200">
        <i class="fas fa-bell text-xl"></i>
        <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
            0
        </span>
    </button>

    <!-- Dropdown Menu -->
    <div id="notification-dropdown" class="absolute right-0 mt-2 w-96 max-w-[90vw] bg-white/95 backdrop-blur rounded-xl shadow-2xl border border-gray-200 ring-1 ring-black/5 overflow-hidden z-[9999] hidden" style="position: absolute; z-index: 9999;">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
            <p class="text-sm text-gray-600">Vos dernières notifications</p>
        </div>

        <div id="notification-list" class="max-h-[60vh] overflow-y-auto divide-y divide-gray-100">
            <!-- Notifications will be loaded here -->
            <div class="p-4 text-center text-gray-500">
                <i class="fas fa-spinner fa-spin text-xl mb-2"></i>
                <p>Chargement...</p>
            </div>
        </div>

        <div class="p-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
            <div class="flex justify-between items-center">
                <button id="mark-all-read" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Tout marquer comme lu
                </button>
                <a href="{{ localized_route('notifications.index', ['locale' => app()->getLocale()]) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Voir tout
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
    const userId = document.querySelector('[data-user-id]')?.getAttribute('data-user-id');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function requireCsrf() {
        if (!csrfToken) {
            console.error('CSRF token missing');
            return false;
        }
        return true;
    }

    let isOpen = false;
    let soundEnabled = false;

    document.addEventListener('click', () => { soundEnabled = true; }, { once: true });

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
        fetch(`/${locale}/notifications/recent`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderNotifications(data.notifications);
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                list.innerHTML = '<div class="p-4 text-center text-gray-500"><p>Erreur de chargement</p></div>';
            });
    }

    // Render notifications
    function renderNotifications(notifications) {
        if (notifications.length === 0) {
            list.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-bell-slash text-2xl mb-2"></i><p>Aucune notification</p></div>';
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
            updateUnreadCount();
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
            updateUnreadCount();
            loadNotifications();
        })
        .catch(error => console.error('Error marking all as read:', error));
    });

    // Update unread count
    function updateUnreadCount() {
        const locale = window.location.pathname.split('/')[1] || 'fr';
        fetch(`/${locale}/notifications/unread-count`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.count > 0) {
                    count.textContent = data.count > 99 ? '99+' : data.count;
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

        if (minutes < 1) return 'À l'instant';
        if (minutes < 60) return `Il y a ${minutes} min`;
        if (hours < 24) return `Il y a ${hours} h`;
        if (days < 7) return `Il y a ${days} j`;
        return date.toLocaleDateString('fr-FR');
    }

    // Initial load of unread count
    updateUnreadCount();

    // Real-time updates with Echo (fallback to polling)
    function playNotificationSound() {
        if (!soundEnabled) {
            return;
        }
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            oscillator.type = 'triangle';
            oscillator.frequency.value = 740;
            gainNode.gain.value = 0.06;
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            oscillator.start();
            oscillator.stop(audioContext.currentTime + 0.18);
        } catch (e) {
            // Ignore audio errors
        }
    }

    if (window.Echo && userId) {
        window.Echo.private(`user.${userId}`)
            .listen('.notification.created', (e) => {
                const payload = e.notification || e;
                updateUnreadCount();
                if (isOpen) {
                    loadNotifications();
                }
                playNotificationSound();
                window.dispatchEvent(new CustomEvent('notification.created', { detail: payload }));
            });
    } else {
        // Auto-refresh with a lighter polling cadence and pause when hidden
        let unreadTimer = null;

        function startUnreadPolling() {
            if (unreadTimer) return;
            unreadTimer = setInterval(() => {
                if (document.visibilityState === 'visible') {
                    updateUnreadCount();
                }
            }, 30000);
        }

        function stopUnreadPolling() {
            if (unreadTimer) {
                clearInterval(unreadTimer);
                unreadTimer = null;
            }
        }

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                updateUnreadCount();
                startUnreadPolling();
            } else {
                stopUnreadPolling();
            }
        });

        startUnreadPolling();
    }
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








