@extends('layouts.premium-dashboard')

@php
    $adminNavActive = trim($__env->yieldContent('admin_nav_active', ''));
@endphp

@section('title', trim($__env->yieldContent('title', 'Administration - Zuider Bank S.A')))
@section('dashboard_theme', 'admin')
@section('dashboard_page_title', trim($__env->yieldContent('dashboard_page_title', __('admin_dashboard.admin_title'))))
@section('dashboard_page_subtitle', trim($__env->yieldContent('dashboard_page_subtitle', __('admin_dashboard.admin_subtitle'))))
@section('dashboard_section_label', trim($__env->yieldContent('dashboard_section_label', __('admin_dashboard.admin_section'))))
@section('dashboard_search_placeholder', __('admin_dashboard.search_placeholder'))
@section('dashboard_brand_title', __('admin_dashboard.brand_title'))
@section('dashboard_brand_subtitle', __('admin_dashboard.brand_subtitle'))
@section('sidebar_primary_title', __('admin_dashboard.sidebar_navigation'))
@section('sidebar_secondary_title', __('admin_dashboard.sidebar_operations'))

@section('sidebar_primary')
    <a href="{{ localized_route('admin.dashboard') }}" class="premium-nav-item {{ $adminNavActive === 'dashboard' ? 'is-active text-slate-900' : 'text-slate-600' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $adminNavActive === 'dashboard' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70' }} shadow-sm"><i class="fas fa-chart-line"></i></span>
        <span>{{ __('admin_dashboard.nav_dashboard') }}</span>
    </a>
    <a href="{{ localized_route('admin.users') }}" class="premium-nav-item {{ in_array($adminNavActive, ['users', 'users-create'], true) ? 'is-active text-slate-900' : 'text-slate-600' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ in_array($adminNavActive, ['users', 'users-create'], true) ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70' }} shadow-sm"><i class="fas fa-users"></i></span>
        <span>{{ __('admin_dashboard.nav_users') }}</span>
    </a>
    <a href="{{ localized_route('admin.transactions') }}" class="premium-nav-item {{ $adminNavActive === 'transactions' ? 'is-active text-slate-900' : 'text-slate-600' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $adminNavActive === 'transactions' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70' }} shadow-sm"><i class="fas fa-exchange-alt"></i></span>
        <span>{{ __('admin_dashboard.nav_transfers') }}</span>
    </a>
    <a href="{{ localized_route('admin.deposit') }}" class="premium-nav-item {{ $adminNavActive === 'deposit' ? 'is-active text-slate-900' : 'text-slate-600' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $adminNavActive === 'deposit' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70' }} shadow-sm"><i class="fas fa-plus-circle"></i></span>
        <span>{{ __('admin_dashboard.nav_deposit') }}</span>
    </a>
@endsection

@section('sidebar_secondary')
    <a href="{{ localized_route('admin.settings') }}" class="premium-nav-item {{ $adminNavActive === 'settings' ? 'is-active text-slate-900' : 'text-slate-600' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $adminNavActive === 'settings' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70' }} shadow-sm"><i class="fas fa-gear"></i></span>
        <span>{{ __('admin_dashboard.nav_settings') }}</span>
    </a>
    <a href="{{ localized_route('admin.export.pdf') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-file-pdf"></i></span>
        <span>Export PDF</span>
    </a>
    <a href="{{ localized_route('admin.export.excel') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-file-excel"></i></span>
        <span>Export Excel</span>
    </a>
    <a href="{{ localized_route('home') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-arrow-left"></i></span>
        <span>{{ __('admin_dashboard.nav_back') }}</span>
    </a>
    <form method="POST" action="{{ localized_route('logout') }}">@csrf
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-right-from-bracket"></i></span>
            <span>{{ __('admin_dashboard.nav_logout') }}</span>
        </button>
    </form>
@endsection

@section('sidebar_footer')
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">{{ __('admin_dashboard.footer_pilotage') }}</p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold">{{ __('admin_dashboard.active_coverage') }}</h3>
            <p class="mt-2 text-sm leading-6 text-white/78">{{ __('admin_dashboard.active_coverage_text', ['rate' => $activeUsersRate]) }}</p>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-white/10 px-4 py-3"><p class="text-xs uppercase tracking-[0.16em] text-white/60">{{ __('admin_dashboard.alerts') }}</p><p class="mt-2 text-lg font-semibold">{{ $unreadNotificationsCount }}</p></div>
                <div class="rounded-2xl bg-white/10 px-4 py-3"><p class="text-xs uppercase tracking-[0.16em] text-white/60">Chat</p><p class="mt-2 text-lg font-semibold">{{ $chatUnreadCount }}</p></div>
            </div>
        </div>
    </div>
@endsection

@section('topbar_actions')
    <div class="hidden items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 ring-1 ring-slate-200 md:inline-flex">
        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
        {{ __('admin_dashboard.active_supervision') }}
    </div>
@endsection

@section('dashboard_overlays')
    @yield('admin_dashboard_overlays')
    @include('components.admin-chat-widget-v2')
@endsection
