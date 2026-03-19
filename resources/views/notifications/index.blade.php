@extends('layouts.premium-dashboard')

@php
    $i18n = [
        'errorLoading' => __('notifications.error_loading'),
        'errorConnection' => __('notifications.error_connection'),
        'noneTitle' => __('notifications.none_title'),
        'noneMessage' => __('notifications.none_message'),
        'badgeUnread' => __('notifications.badge_unread'),
        'statusRead' => __('notifications.status_read'),
        'paginationInfo' => __('notifications.pagination_info'),
        'paginationPrevious' => __('notifications.pagination_previous'),
        'paginationNext' => __('notifications.pagination_next'),
        'receivedAt' => __('notifications.received_at'),
        'confirmMarkAllRead' => __('notifications.confirm_mark_all_read'),
        'confirmDeleteRead' => __('notifications.confirm_delete_read'),
        'timeJustNow' => __('notifications.time_just_now'),
        'timeMinutesAgo' => __('notifications.time_minutes_ago'),
        'timeHoursAgo' => __('notifications.time_hours_ago'),
        'timeDaysAgo' => __('notifications.time_days_ago'),
        'loading' => __('notifications.loading'),
        'loadingShort' => __('notifications.loading_short'),
        'detailTitle' => __('notifications.detail_title'),
        'detailEmpty' => __('notifications.detail_empty'),
        'typeLabels' => [
            'transaction' => __('notifications.type_transaction'),
            'message' => __('notifications.type_message'),
            'account' => __('notifications.type_account'),
            'alert' => __('notifications.type_alert'),
            'system' => __('notifications.type_system'),
        ],
    ];
@endphp

@section('title', __('notifications.page_title'))
@section('dashboard_theme', 'client')
@section('dashboard_page_title', __('notifications.title'))
@section('dashboard_page_subtitle', __('notifications.subtitle'))
@section('dashboard_section_label', __('dashboard.notifications'))
@section('dashboard_search_placeholder', __('dashboard.search_placeholder'))
@section('dashboard_brand_title', 'Valtrix Bank')
@section('dashboard_brand_subtitle', __('dashboard.client_area'))
@section('sidebar_primary_title', __('dashboard.menu'))
@section('sidebar_primary')
    <a href="{{ localized_route('dashboard') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-chart-pie"></i></span>
        <span>{{ __('dashboard.dashboard_title') }}</span>
    </a>
    <a href="{{ localized_route('transfer.create') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-paper-plane"></i></span>
        <span>{{ __('dashboard.new_transfer') }}</span>
    </a>
    <a href="{{ localized_route('transactions.history') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-clock-rotate-left"></i></span>
        <span>{{ __('dashboard.history') }}</span>
    </a>
    <a href="{{ localized_route('profile') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-user-shield"></i></span>
        <span>{{ __('dashboard.profile') }}</span>
    </a>
@endsection
@section('sidebar_secondary_title', __('dashboard.services'))
@section('sidebar_secondary')
    <a href="{{ localized_route('notifications.index') }}" class="premium-nav-item is-active flex items-center justify-between gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm ring-1 ring-emerald-200/80"><i class="fas fa-bell"></i></span>
            <span>{{ __('dashboard.notifications') }}</span>
        </span>
        <span id="sidebar-unread-count" class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">{{ $unreadNotificationsCount }}</span>
    </a>
    <a href="{{ localized_route('support.nous-contacter') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-headset"></i></span>
        <span>{{ __('dashboard.support') }}</span>
    </a>
    <form method="POST" action="{{ localized_route('logout') }}">
        @csrf
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-right-from-bracket"></i></span>
            <span>{{ __('dashboard.logout') }}</span>
        </button>
    </form>
@endsection
@section('sidebar_footer')
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('dashboard.concierge_service') }}</p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold">{{ __('dashboard.priority_access') }}</h3>
            <p class="mt-2 text-sm leading-6 text-white/78">{{ __('dashboard.concierge_description') }}</p>
            <div class="mt-5 flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('dashboard.profile') }}</p>
                    <p class="text-lg font-semibold">{{ $profileCompletion }}%</p>
                </div>
                <a href="{{ localized_route('profile') }}" class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-2 text-xs font-semibold text-slate-900">
                    {{ __('dashboard.complete') }}
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('topbar_actions')
    <div class="hidden items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 ring-1 ring-slate-200 md:inline-flex">
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
        {{ __('dashboard.secure_session') }}
    </div>
@endsection
@section('dashboard_header_actions')
    <a href="{{ localized_route('transfer.create') }}" class="inline-flex items-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition hover:bg-orange-600">
        <i class="fas fa-paper-plane text-xs"></i>
        {{ __('dashboard.new_transfer') }}
    </a>
    <a href="{{ localized_route('dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-chart-pie text-xs"></i>
        {{ __('dashboard.dashboard_title') }}
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .notification-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .notification-field:focus { background: rgba(255, 255, 255, 0.98); border-color: rgba(22, 124, 91, 0.38); box-shadow: 0 0 0 4px rgba(22, 124, 91, 0.1); outline: none; }
        .notification-card, .notification-item, .notification-modal-panel { border: 1px solid rgba(148, 163, 184, 0.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06); }
        .notification-stat { display: block; max-width: 100%; font-size: clamp(1.55rem, 1rem + 1.1vw, 2.65rem); line-height: 1.08; overflow-wrap: anywhere; word-break: break-word; }
        .notification-item { transition: transform .18s, background-color .18s, border-color .18s; }
        .notification-item:hover { transform: translateY(-1px); background: rgba(248, 250, 252, 0.98); }
        .notification-item.is-unread { background: linear-gradient(135deg, rgba(236, 253, 245, 0.85), rgba(255, 255, 255, 0.92)); border-color: rgba(16, 185, 129, 0.18); }
        .notification-icon { display: inline-flex; height: 3.25rem; width: 3.25rem; flex-shrink: 0; align-items: center; justify-content: center; border-radius: 1.1rem; box-shadow: inset 0 1px 0 rgba(255,255,255,.45); }
        .notification-chip { display: inline-flex; align-items: center; gap: .45rem; border-radius: 9999px; padding: .45rem .8rem; font-size: .75rem; font-weight: 700; }
        .notification-clamp { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .notification-scroll { scrollbar-width: thin; scrollbar-color: rgba(148,163,184,.6) transparent; }
        .notification-scroll::-webkit-scrollbar { width: 8px; }
        .notification-scroll::-webkit-scrollbar-thumb { background: rgba(148,163,184,.6); border-radius: 999px; }
        .notification-modal-backdrop { background: rgba(15, 23, 42, 0.58); backdrop-filter: blur(10px); }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 flex flex-col gap-6 2xl:flex-row 2xl:items-end 2xl:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-[0.22em] text-white/65">{{ __('dashboard.notification_center') }}</p>
                <h2 class="mt-4 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">{{ __('notifications.title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-white/78 sm:text-base">{{ __('notifications.subtitle') }}</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 2xl:grid-cols-4 2xl:min-w-[720px]">
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('notifications.summary_total') }}</p><p id="stat-total" class="notification-stat premium-kpi-number mt-2 font-semibold">{{ $totalNotificationsCount }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('notifications.summary_unread') }}</p><p id="stat-unread" class="notification-stat premium-kpi-number mt-2 font-semibold">{{ $unreadNotificationsCount }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('notifications.summary_read') }}</p><p id="stat-read" class="notification-stat premium-kpi-number mt-2 font-semibold">{{ $readNotificationsCount }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('notifications.summary_last_24h') }}</p><p id="stat-last24" class="notification-stat premium-kpi-number mt-2 font-semibold">{{ $notificationsLast24HoursCount }}</p></div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.6fr)_minmax(320px,380px)]">
        <section class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-3 border-b border-slate-200/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.instant_reading') }}</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('notifications.filters_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('notifications.filters_subtitle') }}</p>
                    </div>
                    <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold"><span id="active-filters-count">0</span> {{ __('notifications.active_filters') }}</span>
                </div>
                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <div><label for="type-filter" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('notifications.filter_type') }}</label><select id="type-filter" class="notification-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">{{ __('notifications.all_types') }}</option><option value="transaction">{{ __('notifications.type_transaction') }}</option><option value="message">{{ __('notifications.type_message') }}</option><option value="account">{{ __('notifications.type_account') }}</option><option value="alert">{{ __('notifications.type_alert') }}</option><option value="system">{{ __('notifications.type_system') }}</option></select></div>
                    <div><label for="status-filter" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('notifications.filter_status') }}</label><select id="status-filter" class="notification-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">{{ __('notifications.status_all') }}</option><option value="unread">{{ __('notifications.status_unread') }}</option><option value="read">{{ __('notifications.status_read') }}</option></select></div>
                    <div class="flex items-end"><button id="apply-filters" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition hover:bg-orange-600"><i class="fas fa-filter text-xs"></i>{{ __('notifications.filter_apply') }}</button></div>
                </div>
            </section>

            <section class="notification-card premium-panel premium-card-hover overflow-hidden rounded-[30px]">
                <div class="flex flex-col gap-4 border-b border-slate-200/70 px-5 py-5 sm:flex-row sm:items-start sm:justify-between sm:px-6">
                    <div><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.real_time') }}</p><h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('notifications.feed_title') }}</h2><p class="mt-2 text-sm leading-6 text-slate-500">{{ __('notifications.feed_subtitle') }}</p></div>
                    <div class="flex flex-wrap gap-3">
                        <button id="mark-all-read-btn" class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100"><i class="fas fa-check-double text-xs"></i>{{ __('notifications.mark_all_read') }}</button>
                        <button id="delete-read-btn" class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"><i class="fas fa-trash text-xs"></i>{{ __('notifications.delete_read') }}</button>
                    </div>
                </div>
                <div id="notifications-container" class="notification-scroll max-h-[960px] overflow-y-auto"><div class="px-5 py-12 text-center text-slate-500 sm:px-6"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 ring-1 ring-slate-200"><i class="fas fa-spinner fa-spin text-xl"></i></div><p class="mt-4 text-sm font-medium">{{ __('notifications.loading') }}</p></div></div>
                <div id="pagination-container" class="hidden border-t border-slate-200/70 bg-slate-50/75 px-5 py-4 sm:px-6"><div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"><div id="pagination-info" class="text-sm text-slate-500"></div><div id="pagination-buttons" class="flex flex-wrap gap-2"></div></div></div>
            </section>
        </section>

        <aside class="space-y-6">
            <section class="notification-card premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('notifications.archive_title') }}</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('dashboard.client_priorities') }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('notifications.archive_subtitle') }}</p>
                <div class="mt-5 space-y-4">
                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-center justify-between gap-3 py-3"><span class="text-sm text-slate-500">{{ __('notifications.summary_total') }}</span><span id="archive-total" class="text-sm font-semibold text-slate-950">{{ $totalNotificationsCount }}</span></div>
                        <div class="flex items-center justify-between gap-3 py-3"><span class="text-sm text-slate-500">{{ __('notifications.summary_unread') }}</span><span id="archive-unread" class="text-sm font-semibold text-slate-950">{{ $unreadNotificationsCount }}</span></div>
                        <div class="flex items-center justify-between gap-3 py-3"><span class="text-sm text-slate-500">{{ __('notifications.summary_read') }}</span><span id="archive-read" class="text-sm font-semibold text-slate-950">{{ $readNotificationsCount }}</span></div>
                        <div class="flex items-center justify-between gap-3 py-3"><span class="text-sm text-slate-500">{{ __('notifications.summary_last_24h') }}</span><span id="archive-last24" class="text-sm font-semibold text-slate-950">{{ $notificationsLast24HoursCount }}</span></div>
                        <div class="flex items-center justify-between gap-3 py-3"><span class="text-sm text-slate-500">{{ __('notifications.active_filters') }}</span><span id="archive-active-filters" class="text-sm font-semibold text-slate-950">0</span></div>
                    </div>
                </div>
            </section>

            <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-5">
                <div class="relative z-10">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/65">{{ __('dashboard.quick_pilot') }}</p>
                    <h3 class="mt-2 premium-brand-title text-2xl font-semibold">{{ __('notifications.detail_title') }}</h3>
                    <p class="mt-2 text-sm leading-6 text-white/78">{{ __('notifications.detail_empty') }}</p>
                    <div class="mt-5 space-y-3">
                        <a href="{{ localized_route('dashboard') }}" class="inline-flex w-full items-center justify-between gap-3 rounded-[22px] bg-white/10 px-4 py-4 text-sm font-semibold text-white transition hover:bg-white/16"><span class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/14"><i class="fas fa-chart-pie"></i></span><span>{{ __('dashboard.dashboard_title') }}</span></span><i class="fas fa-arrow-right text-[11px]"></i></a>
                        <a href="{{ localized_route('transactions.history') }}" class="inline-flex w-full items-center justify-between gap-3 rounded-[22px] bg-white/10 px-4 py-4 text-sm font-semibold text-white transition hover:bg-white/16"><span class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/14"><i class="fas fa-clock-rotate-left"></i></span><span>{{ __('dashboard.history') }}</span></span><i class="fas fa-arrow-right text-[11px]"></i></a>
                        <a href="{{ localized_route('profile') }}" class="inline-flex w-full items-center justify-between gap-3 rounded-[22px] bg-white/10 px-4 py-4 text-sm font-semibold text-white transition hover:bg-white/16"><span class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/14"><i class="fas fa-user-shield"></i></span><span>{{ __('dashboard.profile') }}</span></span><i class="fas fa-arrow-right text-[11px]"></i></a>
                    </div>
                </div>
            </section>
        </aside>
    </div>
@endsection

@section('dashboard_overlays')
    <div id="notification-modal" class="notification-modal-backdrop fixed inset-0 z-[120] hidden px-4 py-6">
        <div class="flex min-h-full items-center justify-center">
            <div class="notification-modal-panel w-full max-w-3xl rounded-[32px] p-5 sm:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('notifications.detail_title') }}</p>
                        <h3 id="modal-title" class="mt-2 text-2xl font-semibold text-slate-950">{{ __('notifications.detail_title') }}</h3>
                    </div>
                    <button id="close-modal" type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-slate-300 hover:text-slate-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <span id="modal-status" class="notification-chip bg-slate-100 text-slate-600 ring-1 ring-slate-200"><i class="fas fa-circle text-[8px]"></i>{{ __('notifications.status_read') }}</span>
                    <span id="modal-date" class="text-sm text-slate-500">{{ __('notifications.detail_empty') }}</span>
                </div>
                <div id="modal-content" class="mt-6 whitespace-pre-line text-sm leading-7 text-slate-600">{{ __('notifications.detail_empty') }}</div>
            </div>
        </div>
    </div>
    @include('components.client-chat-widget')
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentPage = 1;
            let currentFilters = {};
            const i18n = @json($i18n);
            const byId = (id) => document.getElementById(id);
            const container = byId('notifications-container');
            const pagination = byId('pagination-container');
            const paginationInfo = byId('pagination-info');
            const paginationButtons = byId('pagination-buttons');
            const modal = byId('notification-modal');
            const modalTitle = byId('modal-title');
            const modalContent = byId('modal-content');
            const modalDate = byId('modal-date');
            const modalStatus = byId('modal-status');
            const typeFilter = byId('type-filter');
            const statusFilter = byId('status-filter');
            const bellCount = byId('notification-count');
            const locale = document.documentElement.lang || window.location.pathname.split('/')[1] || 'fr';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!container || !pagination || !paginationInfo || !paginationButtons || !modal || !modalTitle || !modalContent || !modalDate || !modalStatus || !typeFilter || !statusFilter) {
                return;
            }

            const escapeHtml = (value) => String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            const iconClass = (notification) => {
                const raw = String(notification.icon || '').trim();
                const defaults = { transaction: 'fas fa-exchange-alt', message: 'fas fa-envelope', account: 'fas fa-user', alert: 'fas fa-exclamation-triangle', system: 'fas fa-cog' };
                if (raw !== '') return raw.includes('fa-') && !raw.includes('fas ') && !raw.includes('far ') && !raw.includes('fab ') ? `fas ${raw}` : raw;
                return defaults[notification.type] || 'fas fa-bell';
            };
            const palette = (notification) => ({ green: ['bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200/80', 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80'], blue: ['bg-blue-100 text-blue-700 ring-1 ring-blue-200/80', 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/80'], purple: ['bg-violet-100 text-violet-700 ring-1 ring-violet-200/80', 'bg-violet-50 text-violet-700 ring-1 ring-violet-200/80'], red: ['bg-rose-100 text-rose-700 ring-1 ring-rose-200/80', 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80'], gray: ['bg-slate-100 text-slate-700 ring-1 ring-slate-200/80', 'bg-slate-100 text-slate-700 ring-1 ring-slate-200/80'] }[String(notification.color || '').toLowerCase()] || ['bg-blue-100 text-blue-700 ring-1 ring-blue-200/80', 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/80']);
            const ensureCsrf = () => !!csrfToken;
            const formatDate = (value) => {
                const date = new Date(value);
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
            };
            const syncUnread = (count) => {
                const sidebar = byId('sidebar-unread-count');
                if (sidebar) sidebar.textContent = count;
                if (bellCount) {
                    bellCount.textContent = Number(count) > 99 ? '99+' : String(count);
                    bellCount.classList.toggle('hidden', Number(count) <= 0);
                }
            };
            const setActiveFilters = (filters) => {
                const count = Object.values(filters).filter(Boolean).length;
                byId('active-filters-count').textContent = count;
                byId('archive-active-filters').textContent = count;
            };
            const updateOverview = (overview) => {
                if (!overview) return;
                [['stat-total', overview.total], ['stat-unread', overview.unread], ['stat-read', overview.read], ['stat-last24', overview.last_24_hours], ['archive-total', overview.total], ['archive-unread', overview.unread], ['archive-read', overview.read], ['archive-last24', overview.last_24_hours]].forEach(([id, value]) => { if (byId(id)) byId(id).textContent = value; });
                syncUnread(overview.unread);
            };
            const setLoading = () => { container.innerHTML = `<div class="px-5 py-12 text-center text-slate-500 sm:px-6"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 ring-1 ring-slate-200"><i class="fas fa-spinner fa-spin text-xl"></i></div><p class="mt-4 text-sm font-medium">${escapeHtml(i18n.loading)}</p></div>`; };
            const setEmpty = () => { container.innerHTML = `<div class="px-5 py-14 text-center sm:px-6"><div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400 ring-1 ring-slate-200"><i class="fas fa-bell-slash text-2xl"></i></div><h3 class="mt-5 text-lg font-semibold text-slate-950">${escapeHtml(i18n.noneTitle)}</h3><p class="mt-2 text-sm leading-6 text-slate-500">${escapeHtml(i18n.noneMessage)}</p></div>`; };
            const setError = (message) => { container.innerHTML = `<div class="px-5 py-12 text-center text-slate-500 sm:px-6"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-rose-50 text-rose-500 ring-1 ring-rose-200"><i class="fas fa-wifi text-xl"></i></div><p class="mt-4 text-sm font-medium">${escapeHtml(message)}</p></div>`; };

            const renderNotifications = (notifications) => {
                if (!Array.isArray(notifications) || notifications.length === 0) {
                    setEmpty();
                    return;
                }

                container.innerHTML = notifications.map((notification) => {
                    const tones = palette(notification);
                    const statusLabel = notification.is_read ? i18n.statusRead : i18n.badgeUnread;
                    const statusClass = notification.is_read ? 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' : 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80';
                    const typeLabel = i18n.typeLabels[notification.type] || notification.type || 'Notification';

                    return `<article class="notification-item ${notification.is_read ? '' : 'is-unread'} cursor-pointer border-b border-slate-200/70 px-5 py-5 last:border-b-0 sm:px-6" data-id="${notification.id}"><div class="flex items-start gap-4"><span class="notification-icon ${tones[0]}"><i class="${escapeHtml(iconClass(notification))}"></i></span><div class="min-w-0 flex-1"><div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"><div class="min-w-0"><div class="flex flex-wrap items-center gap-2"><span class="notification-chip ${tones[1]}">${escapeHtml(typeLabel)}</span><span class="notification-chip ${statusClass}"><i class="fas fa-circle text-[8px]"></i>${escapeHtml(statusLabel)}</span></div><h3 class="mt-3 text-base font-semibold text-slate-950 sm:text-lg">${escapeHtml(notification.title)}</h3><p class="notification-clamp mt-2 text-sm leading-6 text-slate-500">${escapeHtml(notification.message)}</p></div><div class="shrink-0 text-sm text-slate-400 sm:ml-4 sm:text-right"><p class="font-semibold text-slate-500">${escapeHtml(formatDate(notification.created_at))}</p></div></div></div></div></article>`;
                }).join('');

                document.querySelectorAll('.notification-item').forEach((element) => {
                    element.addEventListener('click', () => showNotification(element.dataset.id));
                });
            };

            const renderPagination = (meta) => {
                if (!meta || meta.last_page <= 1) {
                    pagination.classList.add('hidden');
                    paginationButtons.innerHTML = '';
                    paginationInfo.textContent = '';
                    return;
                }

                pagination.classList.remove('hidden');
                paginationInfo.textContent = i18n.paginationInfo.replace(':current', meta.current_page).replace(':last', meta.last_page).replace(':total', meta.total);
                let html = '';
                if (meta.current_page > 1) html += `<button class="pagination-btn inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50" data-page="${meta.current_page - 1}">${escapeHtml(i18n.paginationPrevious)}</button>`;
                for (let index = Math.max(1, meta.current_page - 2); index <= Math.min(meta.last_page, meta.current_page + 2); index += 1) {
                    const activeClass = index === meta.current_page ? 'border-emerald-500 bg-emerald-600 text-white shadow-lg shadow-emerald-900/15' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:bg-slate-50';
                    html += `<button class="pagination-btn inline-flex h-10 w-10 items-center justify-center rounded-full border text-sm font-semibold transition ${activeClass}" data-page="${index}">${index}</button>`;
                }
                if (meta.current_page < meta.last_page) html += `<button class="pagination-btn inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50" data-page="${meta.current_page + 1}">${escapeHtml(i18n.paginationNext)}</button>`;
                paginationButtons.innerHTML = html;
                document.querySelectorAll('.pagination-btn').forEach((button) => button.addEventListener('click', () => loadNotifications(Number(button.dataset.page || 1), currentFilters)));
            };

            const closeModal = () => modal.classList.add('hidden');
            const showNotification = (id) => {
                modal.classList.remove('hidden');
                modalTitle.textContent = i18n.detailTitle;
                modalContent.textContent = i18n.loadingShort;
                modalDate.textContent = i18n.detailEmpty;

                fetch(`/${locale}/notifications/${id}`, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then((response) => response.json())
                    .then((data) => {
                        if (!data.success) {
                            modalContent.textContent = i18n.errorLoading;
                            return;
                        }

                        const notification = data.notification;
                        const unread = !notification.is_read;
                        modalTitle.textContent = notification.title || i18n.detailTitle;
                        modalContent.textContent = notification.message || i18n.detailEmpty;
                        modalDate.textContent = i18n.receivedAt.replace(':date', new Date(notification.created_at).toLocaleString(document.documentElement.lang || locale, { dateStyle: 'medium', timeStyle: 'short' }));
                        modalStatus.className = `notification-chip ${unread ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80' : 'bg-slate-100 text-slate-600 ring-1 ring-slate-200'}`;
                        modalStatus.innerHTML = `<i class="fas fa-circle text-[8px]"></i>${escapeHtml(unread ? i18n.badgeUnread : i18n.statusRead)}`;

                        if (unread && ensureCsrf()) {
                            fetch(`/${locale}/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }).then(() => loadNotifications(currentPage, currentFilters));
                        }
                    })
                    .catch(() => { modalContent.textContent = i18n.errorConnection; });
            };

            const loadNotifications = (page = 1, filters = {}) => {
                currentPage = page;
                currentFilters = filters;
                setActiveFilters(filters);
                setLoading();

                const params = new URLSearchParams({ page, ...filters });
                fetch(`/${locale}/notifications/data?${params.toString()}`, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then((response) => response.json())
                    .then((data) => {
                        if (!data.success) {
                            setError(i18n.errorLoading);
                            return;
                        }

                        renderNotifications(data.notifications);
                        renderPagination(data.pagination);
                        updateOverview(data.overview);
                    })
                    .catch(() => setError(i18n.errorConnection));
            };

            byId('apply-filters').addEventListener('click', () => {
                const filters = {};
                if (typeFilter.value) filters.type = typeFilter.value;
                if (statusFilter.value) filters.status = statusFilter.value;
                loadNotifications(1, filters);
            });

            byId('mark-all-read-btn').addEventListener('click', () => {
                if (!confirm(i18n.confirmMarkAllRead) || !ensureCsrf()) return;
                fetch(`/${locale}/notifications/mark-all-read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }).then(() => loadNotifications(currentPage, currentFilters));
            });

            byId('delete-read-btn').addEventListener('click', () => {
                if (!confirm(i18n.confirmDeleteRead) || !ensureCsrf()) return;
                fetch(`/${locale}/notifications/delete-all-read`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }).then(() => loadNotifications(1, currentFilters));
            });

            byId('close-modal').addEventListener('click', closeModal);
            modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });
            document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });

            setActiveFilters({});
            syncUnread({{ $unreadNotificationsCount }});
            loadNotifications();
        });
    </script>
@endpush
