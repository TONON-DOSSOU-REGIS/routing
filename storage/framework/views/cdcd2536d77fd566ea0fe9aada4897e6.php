
<div class="relative" x-data="notificationBell()" x-init="init()">
    <!-- Bell Icon with Badge -->
    <button @click="toggleDropdown()" 
            class="relative p-2 text-gray-700 hover:text-blue-600 focus:outline-none transition duration-300 rounded-lg hover:bg-blue-50">
        <i class="fas fa-bell text-xl" :class="{ 'animate-bounce': hasNewNotifications }"></i>
        
        <!-- Badge with count -->
        <span x-show="unreadCount > 0" 
              x-text="unreadCount > 99 ? '99+' : unreadCount"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 min-w-[20px] flex items-center justify-center px-1 animate-pulse">
        </span>
    </button>

    <!-- Dropdown -->
    <div x-show="isOpen" 
         @click.away="isOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden border border-gray-200"
         style="display: none;">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-white">Notifications</h3>
                    <p class="text-sm text-white/90" x-text="unreadCount > 0 ? unreadCount + ' non lue(s)' : 'Aucune nouvelle'"></p>
                </div>
                <button @click="markAllAsRead()" 
                        x-show="unreadCount > 0"
                        class="text-white/90 hover:text-white text-sm font-medium transition">
                    <i class="fas fa-check-double mr-1"></i>
                    Tout lire
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            <template x-if="loading">
                <div class="flex items-center justify-center py-12">
                    <i class="fas fa-spinner fa-spin text-3xl text-gray-400"></i>
                </div>
            </template>

            <template x-if="!loading && notifications.length === 0">
                <div class="flex flex-col items-center justify-center py-12 px-6">
                    <div class="bg-gray-100 p-4 rounded-full mb-4">
                        <i class="fas fa-bell-slash text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-600 font-medium">Aucune notification</p>
                    <p class="text-gray-500 text-sm mt-1">Vous êtes à jour!</p>
                </div>
            </template>

            <template x-for="notification in notifications" :key="notification.id">
                <div @click="markAsReadAndNavigate(notification)"
                     class="px-6 py-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition"
                     :class="{ 'bg-blue-50': !notification.is_read }">
                    <div class="flex items-start gap-3">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                 :class="{
                                     'bg-green-100 text-green-600': notification.color === 'green',
                                     'bg-blue-100 text-blue-600': notification.color === 'blue',
                                     'bg-red-100 text-red-600': notification.color === 'red',
                                     'bg-yellow-100 text-yellow-600': notification.color === 'yellow',
                                     'bg-purple-100 text-purple-600': notification.color === 'purple',
                                     'bg-gray-100 text-gray-600': notification.color === 'gray'
                                 }">
                                <i :class="'fas ' + notification.icon"></i>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="text-sm font-semibold text-gray-900" x-text="notification.title"></h4>
                                <span x-show="!notification.is_read" 
                                      class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full"></span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2" x-text="notification.message"></p>
                            <p class="text-xs text-gray-500 mt-2" x-text="formatDate(notification.created_at)"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            <a href="/notifications" 
               class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center justify-center gap-2">
                <span>Voir toutes les notifications</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<script>
function notificationBell() {
    return {
        isOpen: false,
        loading: false,
        notifications: [],
        unreadCount: 0,
        hasNewNotifications: false,
        pollInterval: null,
        audioContext: null,

        init() {
            this.loadNotifications();
            this.loadUnreadCount();
            
            // Initialize Audio Context
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
            
            // Poll every 30 seconds
            this.pollInterval = setInterval(() => {
                this.loadUnreadCount();
            }, 30000);
        },

        // Play notification sound
        playNotificationSound() {
            try {
                const ctx = this.audioContext;
                
                // Create oscillator for the first beep
                const oscillator1 = ctx.createOscillator();
                const gainNode1 = ctx.createGain();
                
                oscillator1.connect(gainNode1);
                gainNode1.connect(ctx.destination);
                
                // Set frequency (higher pitch)
                oscillator1.frequency.value = 800;
                oscillator1.type = 'sine';
                
                // Set volume envelope
                gainNode1.gain.setValueAtTime(0, ctx.currentTime);
                gainNode1.gain.linearRampToValueAtTime(0.3, ctx.currentTime + 0.01);
                gainNode1.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1);
                
                // Play first beep
                oscillator1.start(ctx.currentTime);
                oscillator1.stop(ctx.currentTime + 0.1);
                
                // Create second beep (slightly lower pitch)
                const oscillator2 = ctx.createOscillator();
                const gainNode2 = ctx.createGain();
                
                oscillator2.connect(gainNode2);
                gainNode2.connect(ctx.destination);
                
                oscillator2.frequency.value = 600;
                oscillator2.type = 'sine';
                
                gainNode2.gain.setValueAtTime(0, ctx.currentTime + 0.15);
                gainNode2.gain.linearRampToValueAtTime(0.3, ctx.currentTime + 0.16);
                gainNode2.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.25);
                
                oscillator2.start(ctx.currentTime + 0.15);
                oscillator2.stop(ctx.currentTime + 0.25);
                
            } catch (error) {
                console.error('Error playing notification sound:', error);
            }
        },

        toggleDropdown() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.loadNotifications();
            }
        },

        async loadNotifications() {
            this.loading = true;
            try {
                const response = await fetch('/notifications/recent');
                const data = await response.json();
                if (data.success) {
                    this.notifications = data.notifications;
                }
            } catch (error) {
                console.error('Error loading notifications:', error);
            } finally {
                this.loading = false;
            }
        },

        async loadUnreadCount() {
            try {
                const response = await fetch('/notifications/unread-count');
                const data = await response.json();
                if (data.success) {
                    const oldCount = this.unreadCount;
                    this.unreadCount = data.count;
                    
                    // Animate and play sound if new notifications
                    if (data.count > oldCount) {
                        this.hasNewNotifications = true;
                        
                        // Play notification sound
                        this.playNotificationSound();
                        
                        setTimeout(() => {
                            this.hasNewNotifications = false;
                        }, 3000);
                    }
                }
            } catch (error) {
                console.error('Error loading unread count:', error);
            }
        },

        async markAsReadAndNavigate(notification) {
            if (!notification.is_read) {
                try {
                    await fetch(`/notifications/${notification.id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    notification.is_read = true;
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                }
            }

            // Navigate if action_url exists
            if (notification.action_url) {
                window.location.href = notification.action_url;
            }
        },

        async markAllAsRead() {
            try {
                const response = await fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    this.notifications.forEach(n => n.is_read = true);
                    this.unreadCount = 0;
                }
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);

            if (diffMins < 1) return 'À l\'instant';
            if (diffMins < 60) return `Il y a ${diffMins} min`;
            if (diffHours < 24) return `Il y a ${diffHours}h`;
            if (diffDays < 7) return `Il y a ${diffDays}j`;
            
            return date.toLocaleDateString('fr-FR', { 
                day: 'numeric', 
                month: 'short' 
            });
        }
    }
}
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
