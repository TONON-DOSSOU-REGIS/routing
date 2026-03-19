@extends('layouts.premium-dashboard')

@php
    $historyTotal = $historySummary['total'] ?? $transactions->total();
    $historySuccess = $historySummary['success'] ?? 0;
    $historyPending = $historySummary['pending'] ?? 0;
    $historyVolume = \App\Helpers\CurrencyHelper::format($historySummary['volume'] ?? 0, $user->default_currency ?? 'EUR');
    $activeFiltersCount = collect(request()->only(['type', 'status', 'date_from', 'date_to']))->filter()->count();
    $statusMap = [
        'pending' => 'status_pending',
        'on_hold' => 'status_on_hold',
        'success' => 'status_success',
        'failed' => 'status_failed',
        'refunded' => 'status_refunded',
    ];
    $typeMap = [
        'transfer' => 'type_transfer',
        'deposit' => 'type_deposit',
        'withdrawal' => 'type_withdrawal',
    ];
@endphp

@section('title', __('transactions.history_page_title'))
@section('dashboard_theme', 'client')
@section('dashboard_page_title', __('transactions.history_title'))
@section('dashboard_page_subtitle', __('transactions.history_subtitle'))
@section('dashboard_section_label', __('dashboard.activity'))
@section('dashboard_search_placeholder', __('dashboard.search_placeholder'))
@section('dashboard_brand_title', 'Valtrix Bank')
@section('dashboard_brand_subtitle', __('dashboard.client_area'))
@section('sidebar_primary_title', __('dashboard.menu'))

@section('sidebar_primary')
    <a href="{{ localized_route('dashboard') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
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
    <a href="{{ localized_route('transactions.history') }}" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm ring-1 ring-emerald-200/80">
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
    <a href="{{ localized_route('dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-chart-pie text-xs"></i>
        {{ __('dashboard.dashboard_title') }}
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .history-field {
            background: rgba(248, 250, 252, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.24);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72);
            transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
        }

        .history-field:focus {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(22, 124, 91, 0.38);
            box-shadow: 0 0 0 4px rgba(22, 124, 91, 0.1);
            outline: none;
        }

        .history-summary-card {
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 250, 252, 0.88));
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
        }

        .history-table-row {
            transition: background-color 180ms ease, transform 180ms ease;
        }

        .history-table-row:hover {
            background: rgba(248, 250, 252, 0.88);
        }

        .history-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 9999px;
            padding: 0.45rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .history-progress-track {
            height: 0.45rem;
            overflow: hidden;
            border-radius: 9999px;
            background: rgba(226, 232, 240, 0.95);
        }

        .history-progress-fill {
            height: 100%;
            border-radius: inherit;
            transition: width 220ms ease;
        }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 flex flex-col gap-6 2xl:flex-row 2xl:items-end 2xl:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-[0.22em] text-white/65">{{ __('dashboard.immediate_summary') }}</p>
                <h2 class="mt-4 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">
                    {{ __('transactions.history_title') }}
                </h2>
                <p class="mt-3 text-sm leading-6 text-white/78 sm:text-base">
                    {{ __('transactions.history_overview') }}
                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 2xl:grid-cols-4 2xl:min-w-[720px]">
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('transactions.table_transaction') }}</p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $historyTotal }}</p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('transactions.status_success') }}</p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $historySuccess }}</p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('transactions.status_pending') }}</p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $historyPending }}</p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('transactions.table_amount') }}</p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $historyVolume }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.6fr)_minmax(320px,380px)]">
        <section class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-3 border-b border-slate-200/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.real_time') }}</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('transactions.filter_apply') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('transactions.history_subtitle') }}</p>
                    </div>
                    @if($activeFiltersCount > 0)
                        <a href="{{ localized_route('transactions.history') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                            <i class="fas fa-rotate-left text-xs"></i>
                            {{ __('transactions.reset_filters') }}
                        </a>
                    @endif
                </div>

                <form method="GET" class="mt-6 grid gap-4 xl:grid-cols-5">
                    <div>
                        <label for="type" class="mb-3 block text-sm font-semibold text-slate-800">{{ __('transactions.filter_type') }}</label>
                        <select name="type" id="type" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                            <option value="">{{ __('transactions.all_types') }}</option>
                            <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>{{ __('transactions.type_transfer') }}</option>
                            <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>{{ __('transactions.type_deposit') }}</option>
                            <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>{{ __('transactions.type_withdrawal') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="mb-3 block text-sm font-semibold text-slate-800">{{ __('transactions.filter_status') }}</label>
                        <select name="status" id="status" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                            <option value="">{{ __('transactions.all_statuses') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('transactions.status_pending') }}</option>
                            <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>{{ __('transactions.status_on_hold') }}</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>{{ __('transactions.status_success') }}</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>{{ __('transactions.status_failed') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="mb-3 block text-sm font-semibold text-slate-800">{{ __('transactions.filter_date_from') }}</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                    </div>

                    <div>
                        <label for="date_to" class="mb-3 block text-sm font-semibold text-slate-800">{{ __('transactions.filter_date_to') }}</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            <i class="fas fa-filter text-xs"></i>
                            {{ __('transactions.filter_apply') }}
                        </button>
                    </div>
                </form>
            </section>

            <section class="premium-panel premium-card-hover overflow-hidden rounded-[30px]">
                <div class="flex flex-col gap-4 border-b border-slate-200/70 px-5 py-5 sm:px-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.activity') }}</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('transactions.history_overview') }}</h2>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        @if($activeFiltersCount > 0)
                            <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                                {{ $activeFiltersCount }} {{ __('transactions.filter_type') }}
                            </span>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ localized_route('admin.export.pdf') }}" class="history-export-link inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100">
                                <i class="fas fa-file-pdf text-xs"></i>
                                {{ __('transactions.export_pdf') }}
                            </a>
                            <a href="{{ localized_route('admin.export.excel') }}" class="history-export-link inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                                <i class="fas fa-file-excel text-xs"></i>
                                {{ __('transactions.export_excel') }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="premium-scroll overflow-x-auto">
                    <table class="min-w-[980px] w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50/85">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_transaction') }}</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_type') }}</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_amount') }}</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_beneficiary') }}</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_status') }}</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_progress') }}</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_date') }}</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ __('transactions.table_actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80 bg-white">
                            @forelse($transactions as $transaction)
                                @php
                                    $typeKey = $typeMap[$transaction->type] ?? null;
                                    $typeLabel = $typeKey ? __('transactions.' . $typeKey) : ucfirst($transaction->type);
                                    $statusKey = $statusMap[$transaction->status] ?? null;
                                    $statusLabel = $statusKey ? __('transactions.' . $statusKey) : ucfirst(str_replace('_', ' ', $transaction->status));
                                    $statusClass = match ($transaction->status) {
                                        'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80',
                                        'on_hold' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80',
                                        'pending' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200/80',
                                        'failed', 'refunded' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80',
                                        default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                                    };
                                    $progressClass = match (true) {
                                        $transaction->progress >= 100 => 'bg-emerald-500',
                                        $transaction->progress >= 70 => 'bg-sky-500',
                                        $transaction->progress >= 30 => 'bg-amber-500',
                                        default => 'bg-rose-500',
                                    };
                                @endphp
                                <tr class="history-table-row">
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold text-slate-950">#{{ $transaction->id }}</div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl
                                                @if($transaction->type === 'transfer') bg-sky-50 text-sky-700
                                                @elseif($transaction->type === 'deposit') bg-emerald-50 text-emerald-700
                                                @else bg-rose-50 text-rose-700 @endif">
                                                <i class="fas fa-@if($transaction->type === 'transfer') paper-plane @elseif($transaction->type === 'deposit') arrow-down @else arrow-up @endif"></i>
                                            </span>
                                            <span class="font-semibold text-slate-900">{{ $typeLabel }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold @if($transaction->type === 'deposit') text-emerald-700 @elseif($transaction->type === 'withdrawal') text-rose-700 @else text-slate-950 @endif">
                                            {{ \App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR') }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold text-slate-900">
                                            {{ $transaction->recipient_name ?? __('transactions.not_available') }}
                                        </div>
                                        @if($transaction->recipient_iban)
                                            <div class="mt-1 text-xs text-slate-500">
                                                {{ substr($transaction->recipient_iban, 0, 4) }}...{{ substr($transaction->recipient_iban, -4) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <span class="history-status-badge {{ $statusClass }}">
                                            <i class="fas fa-@if($transaction->status === 'success') check-circle @elseif($transaction->status === 'on_hold') clock @elseif($transaction->status === 'pending') hourglass-half @else ban @endif"></i>
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="history-progress-track w-full">
                                            <div class="history-progress-fill {{ $progressClass }}" style="width: {{ $transaction->progress }}%"></div>
                                        </div>
                                        <div class="mt-2 text-xs font-semibold text-slate-500">{{ $transaction->progress }}%</div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold text-slate-900">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $transaction->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            @if($transaction->status === 'success' && in_array($transaction->type, ['transfer', 'deposit']))
                                                <a href="{{ localized_route('transactions.receipt', $transaction) }}" class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:border-sky-300 hover:bg-sky-100" title="{{ __('transactions.action_download_receipt') }}">
                                                    <i class="fas fa-download text-[10px]"></i>
                                                    {{ __('transactions.action_receipt') }}
                                                </a>
                                            @endif
                                            @if($transaction->status === 'on_hold')
                                                <span class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700">
                                                    <i class="fas fa-triangle-exclamation text-[10px]"></i>
                                                    {{ $transaction->message }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-14 text-center">
                                        <div class="mx-auto max-w-md">
                                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                                <i class="fas fa-exchange-alt text-2xl"></i>
                                            </div>
                                            <h3 class="mt-5 text-lg font-semibold text-slate-950">{{ __('transactions.no_transactions') }}</h3>
                                            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('transactions.no_transactions_message') }}</p>
                                            <a href="{{ localized_route('transactions.history') }}" class="mt-5 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                                                <i class="fas fa-rotate-left text-xs"></i>
                                                {{ __('transactions.reset_filters') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="flex flex-col gap-4 border-t border-slate-200/70 px-5 py-5 sm:px-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-slate-600">
                            {{ __('transactions.showing_results', ['first' => $transactions->firstItem(), 'last' => $transactions->lastItem(), 'total' => $transactions->total()]) }}
                        </div>
                        <div>
                            {{ $transactions->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                @endif
            </section>
        </section>

        <aside class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.instant_reading') }}</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('transactions.filter_status') }}</h2>
                    </div>
                    <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                        {{ $activeFiltersCount }}
                    </span>
                </div>

                <div class="mt-5 space-y-3">
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('transactions.filter_type') }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">
                            {{ request('type') ? __('transactions.' . ($typeMap[request('type')] ?? 'all_types')) : __('transactions.all_types') }}
                        </p>
                    </div>
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('transactions.filter_status') }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">
                            {{ request('status') ? __('transactions.' . ($statusMap[request('status')] ?? 'all_statuses')) : __('transactions.all_statuses') }}
                        </p>
                    </div>
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('transactions.table_date') }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">
                            {{ request('date_from') ?: __('transactions.not_available') }} - {{ request('date_to') ?: __('transactions.not_available') }}
                        </p>
                    </div>
                </div>
            </section>

            @if(auth()->user()->isAdmin())
                <section class="premium-gradient-card rounded-[30px] p-5">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/65">{{ __('dashboard.priority_channel') }}</p>
                    <h3 class="mt-2 premium-brand-title text-2xl font-semibold">{{ __('transactions.table_actions') }}</h3>
                    <p class="mt-3 text-sm leading-6 text-white/78">{{ __('transactions.history_overview') }}</p>
                    <div class="mt-5 space-y-3">
                        <a href="{{ localized_route('admin.export.pdf') }}" class="history-export-link inline-flex w-full items-center justify-center gap-2 rounded-full bg-white/90 px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-white">
                            <i class="fas fa-file-pdf text-xs"></i>
                            {{ __('transactions.export_pdf') }}
                        </a>
                        <a href="{{ localized_route('admin.export.excel') }}" class="history-export-link inline-flex w-full items-center justify-center gap-2 rounded-full border border-white/30 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            <i class="fas fa-file-excel text-xs"></i>
                            {{ __('transactions.export_excel') }}
                        </a>
                    </div>
                </section>
            @endif

            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.operations_to_track') }}</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('dashboard.client_priorities') }}</h3>
                <div class="mt-5 space-y-3">
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('dashboard.operations_to_track') }}</p>
                        <p class="premium-brand-title mt-2 text-3xl font-semibold text-slate-950">{{ $pendingOperationsCount }}</p>
                    </div>
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('dashboard.notifications') }}</p>
                        <p class="premium-brand-title mt-2 text-3xl font-semibold text-slate-950">{{ $unreadNotificationsCount }}</p>
                    </div>
                    <a href="{{ localized_route('support.nous-contacter') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                        <i class="fas fa-headset text-xs"></i>
                        {{ __('dashboard.support') }}
                    </a>
                </div>
            </section>
        </aside>
    </div>
@endsection

@section('dashboard_overlays')
    @include('components.client-chat-widget')
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const statusSelect = document.getElementById('status');
            const dateFrom = document.getElementById('date_from');
            const dateTo = document.getElementById('date_to');

            if (typeSelect) {
                typeSelect.addEventListener('change', function () {
                    this.form.submit();
                });
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', function () {
                    this.form.submit();
                });
            }

            function submitDateFilter() {
                if (dateFrom && dateTo && dateFrom.value && dateTo.value) {
                    dateFrom.form.submit();
                }
            }

            if (dateFrom) {
                dateFrom.addEventListener('change', submitDateFilter);
            }

            if (dateTo) {
                dateTo.addEventListener('change', submitDateFilter);
            }

            document.querySelectorAll('.history-export-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>{{ __('transactions.generating') }}';

                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 3000);
                });
            });
        });
    </script>
@endpush
