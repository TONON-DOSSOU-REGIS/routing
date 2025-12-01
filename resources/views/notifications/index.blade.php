@extends('layouts.app')

@section('title', 'Notifications - SG BANK')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-900 via-red-800 to-red-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Notifications</h1>
                    <p class="mt-2 text-red-100">Gérez vos notifications et restez informé</p>
                </div>
                <div class="flex space-x-4">
                    <button id="mark-all-read-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-check-double mr-2"></i>Tout marquer comme lu
                    </button>
                    <button id="delete-read-btn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-trash mr-2"></i>Supprimer les lues
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex flex-wrap gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select id="type-filter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les types</option>
                        <option value="transaction">Transaction</option>
                        <option value="account">Compte</option>
                        <option value="alert">Alerte</option>
                        <option value="system">Système</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="status-filter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous</option>
                        <option value="unread">Non lues</option>
                        <option value="read">Lues</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button id="apply-filters" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filtrer
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div id="notifications-container">
                <!-- Loading state -->
                <div class="p-8 text-center">
                    <div class="inline-flex items-center">
                        <i class="fas fa-spinner fa-spin text-blue-600 text-xl mr-3"></i>
                        <span class="text-gray-600">Chargement des notifications...</span>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div id="pagination-container" class="px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                <div class="flex items-center justify-between">
                    <div id="pagination-info" class="text-sm text-gray-700"></div>
                    <div id="pagination-buttons" class="flex space-x-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Detail Modal -->
<div id="notification-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="modal-title" class="text-xl font-bold text-gray-900"></h3>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="modal-content" class="text-gray-700"></div>
                <div id="modal-date" class="mt-4 text-sm text-gray-500"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let currentFilters = {};

    const container = document.getElementById('notifications-container');
    const paginationContainer = document.getElementById('pagination-container');
    const paginationInfo = document.getElementById('pagination-info');
    const paginationButtons = document.getElementById('pagination-buttons');
    const modal = document.getElementById('notification-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');
    const modalDate = document.getElementById('modal-date');

    // Load notifications
    function loadNotifications(page = 1, filters = {}) {
        currentPage = page;
        currentFilters = filters;

        const params = new URLSearchParams({
            page: page,
            ...filters
        });

        fetch(`/notifications/data?${params}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderNotifications(data.notifications);
                    renderPagination(data.pagination);
                } else {
                    container.innerHTML = '<div class="p-8 text-center text-gray-500">Erreur lors du chargement des notifications</div>';
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                container.innerHTML = '<div class="p-8 text-center text-gray-500">Erreur de connexion</div>';
            });
    }

    // Render notifications
    function renderNotifications(notifications) {
        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="p-8 text-center">
                    <i class="fas fa-bell-slash text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune notification</h3>
                    <p class="text-gray-500">Vous n'avez pas encore de notifications.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = notifications.map(notification => `
            <div class="border-b border-gray-200 p-6 hover:bg-gray-50 cursor-pointer notification-item ${!notification.is_read ? 'bg-blue-50' : ''}"
                 data-id="${notification.id}">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 ${getIconColor(notification.type)} rounded-full flex items-center justify-center">
                            <i class="${getIcon(notification.type)} text-white"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                ${notification.title}
                            </h4>
                            <div class="flex items-center space-x-2">
                                ${!notification.is_read ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Non lu</span>' : ''}
                                <span class="text-sm text-gray-500">
                                    ${formatDate(notification.created_at)}
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            ${notification.message}
                        </p>
                    </div>
                </div>
            </div>
        `).join('');

        // Add click handlers
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.dataset.id;
                showNotificationDetail(id);
            });
        });
    }

    // Render pagination
    function renderPagination(pagination) {
        if (pagination.last_page <= 1) {
            paginationContainer.classList.add('hidden');
            return;
        }

        paginationContainer.classList.remove('hidden');
        paginationInfo.textContent = `Page ${pagination.current_page} sur ${pagination.last_page} (${pagination.total} notifications)`;

        let buttons = '';

        // Previous button
        if (pagination.current_page > 1) {
            buttons += `<button class="pagination-btn px-3 py-1 bg-white border border-gray-300 rounded-md text-sm hover:bg-gray-50" data-page="${pagination.current_page - 1}">Précédent</button>`;
        }

        // Page numbers
        for (let i = Math.max(1, pagination.current_page - 2); i <= Math.min(pagination.last_page, pagination.current_page + 2); i++) {
            const activeClass = i === pagination.current_page ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-50';
            buttons += `<button class="pagination-btn px-3 py-1 border border-gray-300 rounded-md text-sm ${activeClass}" data-page="${i}">${i}</button>`;
        }

        // Next button
        if (pagination.current_page < pagination.last_page) {
            buttons += `<button class="pagination-btn px-3 py-1 bg-white border border-gray-300 rounded-md text-sm hover:bg-gray-50" data-page="${pagination.current_page + 1}">Suivant</button>`;
        }

        paginationButtons.innerHTML = buttons;

        // Add click handlers
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const page = parseInt(this.dataset.page);
                loadNotifications(page, currentFilters);
            });
        });
    }

    // Show notification detail
    function showNotificationDetail(id) {
        fetch(`/notifications/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = data.notification;
                    modalTitle.textContent = notification.title;
                    modalContent.textContent = notification.message;
                    modalDate.textContent = `Reçu le ${new Date(notification.created_at).toLocaleString('fr-FR')}`;

                    modal.classList.remove('hidden');

                    // Mark as read
                    if (!notification.is_read) {
                        fetch(`/notifications/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        }).then(() => {
                            loadNotifications(currentPage, currentFilters);
                        });
                    }
                }
            })
            .catch(error => console.error('Error loading notification detail:', error));
    }

    // Event listeners
    document.getElementById('apply-filters').addEventListener('click', function() {
        const type = document.getElementById('type-filter').value;
        const status = document.getElementById('status-filter').value;

        const filters = {};
        if (type) filters.type = type;
        if (status) filters.status = status;

        loadNotifications(1, filters);
    });

    document.getElementById('mark-all-read-btn').addEventListener('click', function() {
        if (confirm('Marquer toutes les notifications comme lues ?')) {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(() => {
                loadNotifications(currentPage, currentFilters);
            });
        }
    });

    document.getElementById('delete-read-btn').addEventListener('click', function() {
        if (confirm('Supprimer toutes les notifications lues ?')) {
            fetch('/notifications/delete-all-read', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(() => {
                loadNotifications(1, currentFilters);
            });
        }
    });

    document.getElementById('close-modal').addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

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
            'account': 'bg-purple-500',
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

    // Initial load
    loadNotifications();
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
@endsection
