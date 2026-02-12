@extends('layouts.app')

@section('title', __('notifications.page_title'))

@section('content')
@php
    $notificationIndexI18n = [
        'errorLoading' => __('notifications.error_loading'),
        'errorConnection' => __('notifications.error_connection'),
        'noneTitle' => __('notifications.none_title'),
        'noneMessage' => __('notifications.none_message'),
        'badgeUnread' => __('notifications.badge_unread'),
        'paginationInfo' => __('notifications.pagination_info'),
        'receivedAt' => __('notifications.received_at'),
        'confirmMarkAllRead' => __('notifications.confirm_mark_all_read'),
        'confirmDeleteRead' => __('notifications.confirm_delete_read'),
        'timeJustNow' => __('notifications.time_just_now'),
        'timeMinutesAgo' => __('notifications.time_minutes_ago'),
        'timeHoursAgo' => __('notifications.time_hours_ago'),
        'timeDaysAgo' => __('notifications.time_days_ago'),
    ];
@endphp
@include('components.background-slider')
<div class="min-h-screen bg-slate-900/60 relative z-[1]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ __('notifications.title') }}</h1>
                    <p class="mt-2 text-red-100">{{ __('notifications.subtitle') }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <button id="mark-all-read-btn" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors w-full sm:w-auto">
                        <i class="fas fa-check-double mr-2"></i>{{ __('notifications.mark_all_read') }}
                    </button>
                    <button id="delete-read-btn" class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors w-full sm:w-auto">
                        <i class="fas fa-trash mr-2"></i>{{ __('notifications.delete_read') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('notifications.filter_type') }}</label>
                    <select id="type-filter" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ __('notifications.all_types') }}</option>
                        <option value="transaction">{{ __('notifications.type_transaction') }}</option>
                        <option value="account">{{ __('notifications.type_account') }}</option>
                        <option value="alert">{{ __('notifications.type_alert') }}</option>
                        <option value="system">{{ __('notifications.type_system') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('notifications.filter_status') }}</label>
                    <select id="status-filter" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ __('notifications.status_all') }}</option>
                        <option value="unread">{{ __('notifications.status_unread') }}</option>
                        <option value="read">{{ __('notifications.status_read') }}</option>
                    </select>
                </div>
                <div class="flex items-end sm:col-span-2 lg:col-span-1">
                    <button id="apply-filters" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors w-full">
                        <i class="fas fa-filter mr-2"></i>{{ __('notifications.filter_apply') }}
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
                        <span class="text-gray-600">{{ __('notifications.loading') }}</span>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div id="pagination-container" class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div id="pagination-info" class="text-sm text-gray-700"></div>
                    <div id="pagination-buttons" class="flex flex-wrap gap-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Detail Modal -->
<div id="notification-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
            <div class="p-4 sm:p-6">
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

    const i18n = @json($notificationIndexI18n);

    const container = document.getElementById('notifications-container');
    const paginationContainer = document.getElementById('pagination-container');
    const paginationInfo = document.getElementById('pagination-info');
    const paginationButtons = document.getElementById('pagination-buttons');
    const modal = document.getElementById('notification-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');
    const modalDate = document.getElementById('modal-date');
    const locale = window.location.pathname.split('/')[1] || 'fr';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function requireCsrf() {
        if (!csrfToken) {
            console.error('CSRF token missing');
            return false;
        }
        return true;
    }

    // Load notifications
    function loadNotifications(page = 1, filters = {}) {
        currentPage = page;
        currentFilters = filters;

        const params = new URLSearchParams({
            page: page,
            ...filters
        });

        fetch(`/${locale}/notifications/data?${params}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderNotifications(data.notifications);
                    renderPagination(data.pagination);
                } else {
                    container.innerHTML = `<div class="p-8 text-center text-gray-500">${i18n.errorLoading}</div>`;
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                container.innerHTML = `<div class="p-8 text-center text-gray-500">${i18n.errorConnection}</div>`;
            });
    }

    // Render notifications
    function renderNotifications(notifications) {
        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="p-8 text-center">
                    <i class="fas fa-bell-slash text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">${i18n.noneTitle}</h3>
                    <p class="text-gray-500">${i18n.noneMessage}</p>
                </div>
            `;
            return;
        }

        container.innerHTML = notifications.map(notification => `
            <div class="border-b border-gray-200 p-4 sm:p-6 hover:bg-gray-50 cursor-pointer notification-item ${!notification.is_read ? 'bg-blue-50' : ''}"
                 data-id="${notification.id}">
                <div class="flex flex-col sm:flex-row sm:items-start sm:space-x-4 space-y-3 sm:space-y-0">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 ${getIconColor(notification.type)} rounded-full flex items-center justify-center">
                            <i class="${getIcon(notification.type)} text-white"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                ${notification.title}
                            </h4>
                            <div class="flex flex-wrap items-center gap-2">
                                ${!notification.is_read ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">${i18n.badgeUnread}</span>` : ''}
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
        paginationInfo.textContent = i18n.paginationInfo
            .replace(':current', pagination.current_page)
            .replace(':last', pagination.last_page)
            .replace(':total', pagination.total);

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
        fetch(`/${locale}/notifications/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = data.notification;
                    modalTitle.textContent = notification.title;
                    modalContent.textContent = notification.message;
                    modalDate.textContent = i18n.receivedAt.replace(':date', new Date(notification.created_at).toLocaleString(document.documentElement.lang || 'fr'));

                    modal.classList.remove('hidden');

                    // Mark as read
                    if (!notification.is_read) {
                        if (!requireCsrf()) return;
                        fetch(`/${locale}/notifications/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
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
        if (confirm(i18n.confirmMarkAllRead)) {
            if (!requireCsrf()) return;
            fetch(`/${locale}/notifications/mark-all-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            }).then(() => {
                loadNotifications(currentPage, currentFilters);
            });
        }
    });

    document.getElementById('delete-read-btn').addEventListener('click', function() {
        if (confirm(i18n.confirmDeleteRead)) {
            if (!requireCsrf()) return;
            fetch(`/${locale}/notifications/delete-all-read`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
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

        if (minutes < 1) return i18n.timeJustNow;
        if (minutes < 60) return i18n.timeMinutesAgo.replace(':minutes', minutes);
        if (hours < 24) return i18n.timeHoursAgo.replace(':hours', hours);
        if (days < 7) return i18n.timeDaysAgo.replace(':days', days);
        return date.toLocaleDateString(document.documentElement.lang || locale);
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

