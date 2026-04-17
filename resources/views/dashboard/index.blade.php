@extends('layouts.premium-dashboard')

@section('title', __('dashboard.dashboard_title'))
@section('dashboard_theme', 'client')
@section('dashboard_page_title', __('dashboard.dashboard_title'))
@section('dashboard_page_subtitle', __('dashboard.page_subtitle'))
@section('dashboard_section_label', __('dashboard.client_area'))
@section('dashboard_search_placeholder', __('dashboard.search_placeholder'))
@section('dashboard_brand_title', 'Valtrix Bank')
@section('dashboard_brand_subtitle', __('dashboard.client_area'))
@section('sidebar_primary_title', __('dashboard.menu'))

@section('sidebar_primary')
    <a href="{{ localized_route('dashboard') }}" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm ring-1 ring-slate-200">
            <i class="fas fa-chart-pie"></i>
        </span>
        <span>{{ __('dashboard.dashboard_title') }}</span>
    </a>
    <a href="{{ localized_route('transfer.create') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-paper-plane"></i>
        </span>
        <span>{{ __('dashboard.new_transfer') }}</span>
    </a>
    <a href="{{ localized_route('transactions.history') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-clock-rotate-left"></i>
        </span>
        <span>{{ __('dashboard.history') }}</span>
    </a>
    <a href="{{ localized_route('profile') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-user-shield"></i>
        </span>
        <span>{{ __('dashboard.profile') }}</span>
    </a>
@endsection

@section('sidebar_secondary_title', __('dashboard.services'))
@section('sidebar_secondary')
    <a href="{{ localized_route('notifications.index') }}" class="premium-nav-item flex items-center justify-between gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
                <i class="fas fa-bell"></i>
            </span>
            <span>{{ __('dashboard.notifications') }}</span>
        </span>
        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">{{ $unreadNotificationsCount }}</span>
    </a>
    <a href="{{ localized_route('support.nous-contacter') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-headset"></i>
        </span>
        <span>{{ __('dashboard.support') }}</span>
    </a>
    <form method="POST" action="{{ localized_route('logout') }}">
        @csrf
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
                <i class="fas fa-right-from-bracket"></i>
            </span>
            <span>{{ __('dashboard.logout') }}</span>
        </button>
    </form>
@endsection

@section('sidebar_footer')
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('dashboard.concierge_service') }}</p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold">{{ __('dashboard.priority_access') }}</h3>
            <p class="mt-2 text-sm leading-6 text-white/78">
                {{ __('dashboard.concierge_description') }}
            </p>
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
    <a href="{{ localized_route('transactions.history') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-list-ul text-xs"></i>
        {{ __('dashboard.view_all') }}
    </a>
@endsection

@section('dashboard_content')
    @php
        $balanceFormatted = \App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR');
        $transactionTypeKeys = [
            'transfer' => 'type_transfer',
            'deposit' => 'type_deposit',
            'withdrawal' => 'type_withdrawal',
        ];
        $transactionStatusKeys = [
            'pending' => 'status_pending',
            'on_hold' => 'status_on_hold',
            'success' => 'status_success',
            'failed' => 'status_failed',
            'refunded' => 'status_refunded',
        ];
        $translateTransactionType = function ($type) use ($transactionTypeKeys) {
            $key = $transactionTypeKeys[$type] ?? null;

            return $key ? __('transactions.' . $key) : ucfirst(str_replace('_', ' ', (string) $type));
        };
        $translateTransactionStatus = function ($status) use ($transactionStatusKeys) {
            $key = $transactionStatusKeys[$status] ?? null;

            return $key ? __('transactions.' . $key) : ucfirst(str_replace('_', ' ', (string) $status));
        };
        $accountStatusKey = 'profile.account_statuses.' . $user->status;
        $accountStatusLabel = __($accountStatusKey);
        if ($accountStatusLabel === $accountStatusKey) {
            $accountStatusLabel = ucfirst((string) $user->status);
        }
        $accountStatusBadgeClasses = match ($user->status) {
            'active' => 'bg-emerald-100 text-emerald-800 ring-emerald-200/80',
            'pending' => 'bg-amber-100 text-amber-800 ring-amber-200/80',
            'suspended' => 'bg-rose-100 text-rose-800 ring-rose-200/80',
            default => 'bg-slate-100 text-slate-700 ring-slate-200/80',
        };
        $accountStatusIconClasses = match ($user->status) {
            'active' => 'bg-emerald-50 text-emerald-700',
            'pending' => 'bg-amber-50 text-amber-700',
            'suspended' => 'bg-rose-50 text-rose-700',
            default => 'bg-slate-100 text-slate-700',
        };
        $latestTransactionLabel = $latestTransaction
            ? $translateTransactionType($latestTransaction->type) . ' #' . $latestTransaction->id
            : __('dashboard.no_recent_operation');
        $latestTransactionStatusLabel = $latestTransaction
            ? $translateTransactionStatus($latestTransaction->status)
            : __('dashboard.no_recorded_movement');
        $profileCompletionWidth = min(max($profileCompletion, 10), 100);
    @endphp

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.72fr)_minmax(320px,380px)]">
        <section class="premium-gradient-card premium-grid-glow premium-card-hover relative min-w-0 overflow-hidden rounded-[30px] p-6 sm:p-7">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -right-20 top-8 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 h-40 w-40 rounded-full bg-emerald-300/10 blur-3xl"></div>
            </div>

            <div class="relative z-10">
                <div class="flex min-w-0 flex-col gap-6 2xl:flex-row 2xl:items-start 2xl:justify-between">
                    <div class="min-w-0 max-w-3xl">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/12 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-white/78 ring-1 ring-white/12">
                            <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                            {{ __('dashboard.immediate_summary') }}
                        </span>
                        <p class="mt-6 text-xs font-semibold uppercase tracking-[0.22em] text-white/60">{{ __('dashboard.loan_amount_title') }}</p>
                        <h2 class="mt-4 premium-page-title text-4xl font-semibold tracking-[-0.06em] sm:text-5xl">
                            {{ $balanceFormatted }}
                        </h2>
                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/78 sm:text-base">
                            {{ __('dashboard.loan_amount_description') }}
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/12 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/12">
                                <i class="fas fa-shield-check text-[11px]"></i>
                                {{ __('dashboard.secure_session') }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/12 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/12">
                                <i class="fas fa-circle-check text-[11px]"></i>
                                {{ __('dashboard.account') }} : {{ $accountStatusLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="grid w-full gap-3 sm:grid-cols-2 2xl:max-w-[420px]">
                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm ring-1 ring-white/10">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('dashboard.account') }}</p>
                                    <p class="mt-2 text-lg font-semibold text-white">{{ $accountStatusLabel }}</p>
                                </div>
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $accountStatusIconClasses }}">
                                    <i class="fas fa-shield-check"></i>
                                </span>
                            </div>
                            <p class="mt-4 inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $accountStatusBadgeClasses }}">
                                {{ __('dashboard.verified_account') }}
                            </p>
                        </div>

                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm ring-1 ring-white/10">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('dashboard.latest_operation') }}</p>
                                    <p class="mt-2 text-lg font-semibold text-white">{{ $latestTransactionLabel }}</p>
                                </div>
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/12 text-white">
                                    <i class="fas fa-clock-rotate-left"></i>
                                </span>
                            </div>
                            <p class="mt-4 text-xs text-white/70">
                                {{ $latestTransaction?->created_at?->format('d/m/Y H:i') ?? __('dashboard.no_recorded_movement') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-3">
                    <article class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm ring-1 ring-white/10">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-white">{{ __('dashboard.unread_notifications') }}</p>
                                <p class="mt-1 text-sm text-white/70">{{ __('dashboard.unread_notifications_description') }}</p>
                            </div>
                            <span class="rounded-full bg-white/14 px-3 py-1 text-xs font-semibold text-white">{{ $unreadNotificationsCount }}</span>
                        </div>
                    </article>

                    <article class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm ring-1 ring-white/10">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-white">{{ __('dashboard.operations_to_track') }}</p>
                                <p class="mt-1 text-sm text-white/70">{{ __('dashboard.operations_to_track_description') }}</p>
                            </div>
                            <span class="rounded-full bg-white/14 px-3 py-1 text-xs font-semibold text-white">{{ $pendingOperationsCount }}</span>
                        </div>
                    </article>

                    <article class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm ring-1 ring-white/10">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-white">{{ __('dashboard.premium_profile') }}</p>
                                <p class="mt-1 text-sm text-white/70">{{ __('dashboard.premium_profile_description') }}</p>
                            </div>
                            <span class="rounded-full bg-white/14 px-3 py-1 text-xs font-semibold text-white">{{ $profileCompletion }}%</span>
                        </div>
                        <div class="mt-4 h-2 rounded-full bg-white/15">
                            <div class="h-2 rounded-full bg-white" style="width: {{ $profileCompletionWidth }}%"></div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.daily_focus') }}</p>
                    <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('dashboard.client_priorities') }}</h2>
                </div>
                <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                    {{ __('dashboard.real_time') }}
                </span>
            </div>

            <div class="mt-5 space-y-4">
                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.unread_notifications') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ __('dashboard.unread_notifications_description') }}</p>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $unreadNotificationsCount }}</span>
                    </div>
                </div>

                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.operations_to_track') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ __('dashboard.operations_to_track_description') }}</p>
                        </div>
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">{{ $pendingOperationsCount }}</span>
                    </div>
                </div>

                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.premium_profile') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ __('dashboard.premium_profile_description') }}</p>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $profileCompletion }}%</span>
                    </div>
                    <div class="mt-3 h-2.5 rounded-full bg-slate-200">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-700" style="width: {{ $profileCompletionWidth }}%"></div>
                    </div>
                </div>

                <a href="{{ localized_route('support.nous-contacter') }}" class="premium-gradient-card block rounded-[24px] p-4">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/65">{{ __('dashboard.direct_support') }}</p>
                    <h3 class="mt-2 text-lg font-semibold">{{ __('dashboard.support_immediate_title') }}</h3>
                    <p class="mt-2 text-sm text-white/78">{{ __('dashboard.support_immediate_description') }}</p>
                </a>
            </div>
        </section>
    </div>

    <section class="grid gap-4 md:grid-cols-2 2xl:grid-cols-4">
        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">{{ __('dashboard.secure_area') }}</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fas fa-shield-heart"></i>
                </span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-950">{{ __('dashboard.priority_access') }}</p>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('dashboard.secure_area_description') }}</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">{{ __('dashboard.instant_reading') }}</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fas fa-wave-square"></i>
                </span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-950">{{ __('dashboard.client_priorities') }}</p>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('dashboard.instant_reading_description') }}</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">{{ __('dashboard.support') }}</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-700">
                    <i class="fas fa-headset"></i>
                </span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-950">{{ __('dashboard.support_immediate_title') }}</p>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('dashboard.support_immediate_description') }}</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">{{ __('dashboard.account') }}</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                    <i class="fas fa-circle-check"></i>
                </span>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-950">{{ $accountStatusLabel }}</p>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('dashboard.verified_account') }}</p>
        </article>
    </section>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.65fr)_minmax(320px,360px)]">
        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('dashboard.experience') }}</p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">{{ __('dashboard.premium_journey') }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">{{ __('dashboard.concierge_description') }}</p>
                </div>
                <span class="premium-soft-chip inline-flex rounded-full px-3 py-1 text-xs font-semibold">{{ __('dashboard.guidance') }}</span>
            </div>

            <div class="mt-6 grid gap-4 xl:grid-cols-[minmax(0,1.12fr)_minmax(260px,320px)]">
                <div class="space-y-4">
                    <div class="rounded-[26px] border border-slate-200/70 bg-slate-50 px-5 py-5">
                        <div class="flex items-start gap-4">
                            <span class="mt-1 flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <i class="fas fa-shield-heart"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('dashboard.secure_area') }}</p>
                                <p class="mt-2 text-lg font-semibold text-slate-950">{{ __('dashboard.priority_access') }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('dashboard.secure_area_description') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[26px] border border-slate-200/70 bg-slate-50 px-5 py-5">
                        <div class="flex items-start gap-4">
                            <span class="mt-1 flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <i class="fas fa-bell"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('dashboard.notification_center') }}</p>
                                <p class="mt-2 text-lg font-semibold text-slate-950">{{ __('dashboard.client_priorities') }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('dashboard.notification_center_description', ['count' => $unreadNotificationsCount]) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[26px] border border-slate-200/70 bg-slate-50 px-5 py-5">
                        <div class="flex items-start gap-4">
                            <span class="mt-1 flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                <i class="fas fa-headset"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('dashboard.direct_support') }}</p>
                                <p class="mt-2 text-lg font-semibold text-slate-950">{{ __('dashboard.support_immediate_title') }}</p>
                                <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('dashboard.support_close_description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="premium-gradient-card premium-grid-glow rounded-[28px] p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">{{ __('dashboard.priority_channel') }}</p>
                    <h3 class="premium-brand-title mt-3 text-2xl font-semibold">{{ __('dashboard.banking_assistance') }}</h3>
                    <p class="mt-3 text-sm leading-6 text-white/78">{{ __('dashboard.banking_assistance_description') }}</p>

                    <div class="mt-6 space-y-3">
                        <div class="rounded-[22px] bg-white/10 px-4 py-4">
                            <p class="text-xs uppercase tracking-[0.16em] text-white/60">{{ __('dashboard.account') }}</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ $accountStatusLabel }}</p>
                        </div>
                        <div class="rounded-[22px] bg-white/10 px-4 py-4">
                            <p class="text-xs uppercase tracking-[0.16em] text-white/60">{{ __('dashboard.latest_operation') }}</p>
                            <p class="mt-2 text-sm font-semibold text-white">{{ $latestTransactionLabel }}</p>
                            <p class="mt-2 text-xs text-white/65">{{ $latestTransactionStatusLabel }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <button type="button" onclick="toggleClientChat()" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-slate-900">
                            <i class="fas fa-comments text-xs"></i>
                            {{ __('dashboard.open_chat') }}
                        </button>
                        <a href="{{ localized_route('support.nous-contacter') }}" class="inline-flex items-center gap-2 rounded-full border border-white/30 px-4 py-2.5 text-sm font-semibold text-white">
                            {{ __('home.footer_contact_us') }}
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="min-w-0 space-y-6">
            <section class="premium-panel premium-card-hover min-w-0 rounded-[28px] p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('dashboard.quick_pilot') }}</p>
                        <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">{{ __('dashboard.smart_actions') }}</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">{{ __('dashboard.flash') }}</span>
                </div>

                <div class="mt-5 space-y-3">
                    <a href="{{ localized_route('transfer.create') }}" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.new_transfer') }}</p>
                                <p class="text-sm text-slate-500">{{ __('dashboard.send_payment') }}</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="{{ localized_route('notifications.index') }}" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <i class="fas fa-bell"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.notification_center') }}</p>
                                <p class="text-sm text-slate-500">{{ __('dashboard.notification_center_description', ['count' => $unreadNotificationsCount]) }}</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="{{ localized_route('profile') }}" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                <i class="fas fa-user-gear"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.my_profile') }}</p>
                                <p class="text-sm text-slate-500">{{ __('dashboard.profile_completion_short', ['percent' => $profileCompletion]) }}</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>
                </div>
            </section>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2 2xl:grid-cols-[minmax(0,1.45fr)_minmax(0,1fr)]">
        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('dashboard.activity') }}</p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">{{ __('dashboard.recent_transactions') }}</h2>
                </div>
                <a href="{{ localized_route('transactions.history') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    {{ __('dashboard.view_all') }}
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse($transactions as $transaction)
                    @php
                        $isPositive = $transaction->type === 'deposit';
                        $transactionColor = $isPositive ? 'emerald' : ($transaction->status === 'on_hold' ? 'amber' : 'slate');
                        $transactionTypeLabel = $translateTransactionType($transaction->type);
                        $transactionStatusLabel = $translateTransactionStatus($transaction->status);
                        $transactionStatusClasses = match ($transaction->status) {
                            'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-200/80',
                            'pending' => 'bg-blue-50 text-blue-700 ring-blue-200/80',
                            'on_hold' => 'bg-amber-50 text-amber-700 ring-amber-200/80',
                            'failed', 'refunded' => 'bg-rose-50 text-rose-700 ring-rose-200/80',
                            default => 'bg-slate-100 text-slate-700 ring-slate-200/80',
                        };
                    @endphp
                    <div class="flex flex-col gap-3 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-{{ $transactionColor }}-50 text-{{ $transactionColor }}-700">
                                <i class="fas {{ $isPositive ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $transactionTypeLabel }}
                                    <span class="ml-2 text-xs font-medium uppercase tracking-[0.16em] text-slate-400">#{{ $transaction->id }}</span>
                                </p>
                                <p class="mt-1 truncate text-sm text-slate-500">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                    @if($transaction->recipient_name)
                                        | {{ $transaction->recipient_name }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-left sm:text-right">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $transactionStatusClasses }}">
                                {{ $transactionStatusLabel }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-[24px] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center">
                        <p class="text-lg font-semibold text-slate-900">{{ __('dashboard.no_recent_transactions') }}</p>
                        <p class="mt-2 text-sm text-slate-500">{{ __('dashboard.no_recent_transactions_description') }}</p>
                    </div>
                @endforelse
            </div>
        </section>

        <div class="min-w-0 space-y-6">
            <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('dashboard.experience') }}</p>
                        <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">{{ __('dashboard.premium_journey') }}</h2>
                    </div>
                    <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">{{ __('dashboard.guidance') }}</span>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <i class="fas fa-shield-heart"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.secure_area') }}</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">{{ __('dashboard.secure_area_description') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <i class="fas fa-wave-square"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.instant_reading') }}</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">{{ __('dashboard.instant_reading_description') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                <i class="fas fa-headset"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.support_close') }}</p>
                                <p class="mt-1 text-sm leading-6 text-slate-500">{{ __('dashboard.support_close_description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="premium-gradient-card min-w-0 rounded-[30px] p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">{{ __('dashboard.priority_channel') }}</p>
                <h2 class="premium-brand-title mt-3 text-2xl font-semibold">{{ __('dashboard.banking_assistance') }}</h2>
                <p class="mt-3 text-sm leading-6 text-white/78">
                    {{ __('dashboard.banking_assistance_description') }}
                </p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <button type="button" onclick="toggleClientChat()" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-slate-900">
                        <i class="fas fa-comments text-xs"></i>
                        {{ __('dashboard.open_chat') }}
                    </button>
                    <a href="{{ localized_route('support.nous-contacter') }}" class="inline-flex items-center gap-2 rounded-full border border-white/30 px-4 py-2.5 text-sm font-semibold text-white">
                        {{ __('home.footer_contact_us') }}
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('dashboard_overlays')
    @include('components.client-chat-widget')
@endsection
