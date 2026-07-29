@extends('layouts.premium-dashboard')

@section('title', __('dashboard.dashboard_title'))
@section('dashboard_theme', 'client')
@section('dashboard_page_title', __('dashboard.dashboard_title'))
@section('dashboard_page_subtitle', __('dashboard.page_subtitle'))
@section('dashboard_section_label', __('dashboard.client_area'))
@section('dashboard_search_placeholder', __('dashboard.search_placeholder'))
@section('dashboard_brand_title', 'Zuider Bank S.A')
@section('dashboard_brand_subtitle', __('dashboard.client_area'))
@section('sidebar_primary_title', __('dashboard.menu'))

@section('sidebar_primary')
    <a href="{{ localized_route('dashboard') }}" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm ring-1 ring-slate-200">
            <i class="fas fa-chart-pie"></i>
        </span>
        <span>{{ __('dashboard.dashboard_title') }}</span>
    </a>
    <a href="{{ localized_route('transfer.create') }}" data-ui-no-loading class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
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
    <a href="{{ localized_route('home') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span>{{ __('dashboard.nav_back') }}</span>
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
    <a href="{{ localized_route('transfer.create') }}" data-ui-no-loading class="relative z-10 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-700 to-cyan-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:-translate-y-0.5 hover:shadow-xl">
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

    <div class="grid items-start gap-6 2xl:grid-cols-[minmax(0,1.72fr)_minmax(320px,380px)]">
        <section class="balance-card premium-card-hover relative min-w-0 overflow-hidden rounded-[26px] p-5 sm:p-6">
            <div class="balance-card-mesh pointer-events-none absolute inset-0"></div>

            <div class="relative z-10">
                <div class="flex flex-wrap items-start justify-between gap-x-4 gap-y-3">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            </span>
                            <span class="text-[10px] font-semibold uppercase tracking-[0.28em] text-white/55">{{ __('dashboard.live_balance') }}</span>
                        </div>

                        <h2 class="balance-figure mt-2 font-semibold tabular-nums tracking-[-0.04em] text-white">
                            {{ $balanceFormatted }}
                        </h2>

                        <div class="mt-3 flex flex-wrap items-center gap-1.5">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-400/12 px-3 py-1 text-xs font-semibold text-emerald-300 ring-1 ring-emerald-400/20">
                                <i class="fas fa-circle-check text-[10px]"></i>
                                {{ $accountStatusLabel }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/8 px-3 py-1 text-xs font-semibold text-white/70 ring-1 ring-white/10">
                                <i class="fas fa-lock text-[10px]"></i>
                                {{ __('dashboard.secure_session') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-2.5 sm:max-w-[360px]">
                    <a href="{{ localized_route('transfer.create') }}" data-ui-no-loading class="balance-quick-action group flex items-center gap-3 rounded-2xl p-3.5">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-slate-950 transition group-hover:scale-105">
                            <i class="fas fa-paper-plane text-sm"></i>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm font-semibold text-white">{{ __('dashboard.new_transfer') }}</span>
                            <span class="block text-xs text-white/50">{{ __('dashboard.send_payment') }}</span>
                        </span>
                    </a>

                    <a href="{{ localized_route('transactions.history') }}" class="balance-quick-action group flex items-center gap-3 rounded-2xl p-3.5">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/12 text-white transition group-hover:scale-105">
                            <i class="fas fa-clock-rotate-left text-sm"></i>
                        </span>
                        <span class="min-w-0">
                            <span class="block truncate text-sm font-semibold text-white">{{ $latestTransactionLabel }}</span>
                            <span class="block truncate text-xs text-white/50">{{ $latestTransactionStatusLabel }}</span>
                        </span>
                    </a>
                </div>

                @if($transactions->isNotEmpty())
                    <div class="mt-5 rounded-2xl bg-white/5 p-4 ring-1 ring-white/8">
                        <div class="flex items-center justify-between">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-white/50">{{ __('dashboard.client_priorities') }}</p>
                            <a href="{{ localized_route('transactions.history') }}" class="text-[11px] font-semibold text-white/60 transition hover:text-white">{{ __('dashboard.view_all') }}</a>
                        </div>

                        <div class="mt-3 space-y-2.5">
                            @foreach($transactions->take(3) as $recentTx)
                                @php
                                    $txStatusDot = match ($recentTx->status) {
                                        'success' => 'bg-emerald-400',
                                        'on_hold' => 'bg-amber-400',
                                        'pending' => 'bg-sky-400',
                                        'failed' => 'bg-rose-400',
                                        default => 'bg-white/40',
                                    };
                                @endphp
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex min-w-0 items-center gap-2.5">
                                        <span class="h-1.5 w-1.5 shrink-0 rounded-full {{ $txStatusDot }}"></span>
                                        <span class="truncate text-xs font-medium text-white/85">{{ $translateTransactionType($recentTx->type) }} #{{ $recentTx->id }}</span>
                                    </div>
                                    <span class="shrink-0 text-xs text-white/45">{{ $recentTx->created_at->format('d/m H:i') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.quick_pilot') }}</p>
                    <h2 class="premium-brand-title mt-2 text-xl font-semibold text-slate-950">{{ __('dashboard.smart_actions') }}</h2>
                </div>
                <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">{{ __('dashboard.flash') }}</span>
            </div>

            <div class="mt-4 space-y-2.5">
                <a href="{{ localized_route('transfer.create') }}" data-ui-no-loading class="group flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3.5 ring-1 ring-slate-200/70 transition hover:bg-white hover:ring-emerald-200">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <i class="fas fa-paper-plane text-sm"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.new_transfer') }}</p>
                            <p class="truncate text-xs text-slate-500">{{ __('dashboard.send_payment') }}</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-xs text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-emerald-600"></i>
                </a>

                <a href="{{ localized_route('notifications.index') }}" class="group flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3.5 ring-1 ring-slate-200/70 transition hover:bg-white hover:ring-blue-200">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                            <i class="fas fa-bell text-sm"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.notification_center') }}</p>
                            <p class="truncate text-xs text-slate-500">{{ __('dashboard.notification_center_description', ['count' => $unreadNotificationsCount]) }}</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-xs text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-blue-600"></i>
                </a>

                <a href="{{ localized_route('profile') }}" class="group flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3.5 ring-1 ring-slate-200/70 transition hover:bg-white hover:ring-amber-200">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                            <i class="fas fa-user-gear text-sm"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.my_profile') }}</p>
                            <p class="truncate text-xs text-slate-500">{{ __('dashboard.profile_completion_short', ['percent' => $profileCompletion]) }}</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-xs text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-amber-600"></i>
                </a>
            </div>
        </section>
    </div>

    <div data-client-news-section>
        @include('components.live-news-feed', ['audience' => 'client'])
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
                        $transactionAmountFormatted = \App\Helpers\CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR');
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
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-{{ $transactionColor }}-50 text-{{ $transactionColor }}-700">
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

                        <div class="flex items-center justify-between gap-3 sm:flex-col sm:items-end sm:justify-center">
                            <p class="text-sm font-semibold {{ $isPositive ? 'text-emerald-700' : 'text-slate-900' }}">
                                {{ $isPositive ? '+' : '-' }}{{ $transactionAmountFormatted }}
                            </p>
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
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('dashboard.experience') }}</p>
                <h2 class="premium-brand-title mt-2 text-xl font-semibold text-slate-950">{{ __('dashboard.premium_journey') }}</h2>

                <div class="mt-5 space-y-3">
                    <div class="flex items-start gap-3 rounded-2xl bg-slate-50 px-4 py-3.5 ring-1 ring-slate-200/70">
                        <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <i class="fas fa-shield-heart text-sm"></i>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.secure_area') }}</p>
                            <p class="mt-0.5 text-xs leading-5 text-slate-500">{{ __('dashboard.secure_area_description') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 rounded-2xl bg-slate-50 px-4 py-3.5 ring-1 ring-slate-200/70">
                        <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                            <i class="fas fa-wave-square text-sm"></i>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.instant_reading') }}</p>
                            <p class="mt-0.5 text-xs leading-5 text-slate-500">{{ __('dashboard.instant_reading_description') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="premium-gradient-card premium-grid-glow min-w-0 rounded-[30px] p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">{{ __('dashboard.priority_channel') }}</p>
                <h2 class="premium-brand-title mt-3 text-2xl font-semibold">{{ __('dashboard.banking_assistance') }}</h2>
                <p class="mt-3 text-sm leading-6 text-white/78">
                    {{ __('dashboard.banking_assistance_description') }}
                </p>

                <div class="mt-5 rounded-2xl bg-white/10 px-4 py-3.5">
                    <p class="text-xs uppercase tracking-[0.16em] text-white/60">{{ __('dashboard.latest_operation') }}</p>
                    <p class="mt-1.5 text-sm font-semibold text-white">{{ $latestTransactionLabel }}</p>
                    <p class="mt-1 text-xs text-white/65">{{ $latestTransactionStatusLabel }}</p>
                </div>

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
