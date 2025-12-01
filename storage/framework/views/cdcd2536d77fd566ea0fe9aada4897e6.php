<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['user' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="relative inline-block">
    <button id="notification-bell" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full transition-colors duration-200">
        <i class="fas fa-bell text-xl"></i>
        <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
            0
        </span>
    </button>

    <!-- Dropdown Menu -->
    <div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
            <p class="text-sm text-gray-600">Vos dernières notifications</p>
        </div>

        <div id="notification-list" class="max-h-96 overflow-y-auto">
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
                <a href="<?php echo e(route('notifications.index')); ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
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

    let isOpen = false;

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
        fetch('/notifications/recent')
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
        fetch(`/notifications/${id}/read`, {
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
        fetch('/notifications/mark-all-read', {
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
        fetch('/notifications/unread-count')
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
            'message': 'fas fa-envelope',
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

        if (minutes < 1) return 'À l\'instant';
        if (minutes < 60) return `Il y a ${minutes} min`;
        if (hours < 24) return `Il y a ${hours} h`;
        if (days < 7) return `Il y a ${days} j`;
        return date.toLocaleDateString('fr-FR');
    }

    // Initial load of unread count
    updateUnreadCount();

    // Auto-refresh every 30 seconds
    setInterval(updateUnreadCount, 30000);
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/notification-bell.blade.php ENDPATH**/ ?>