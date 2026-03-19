@extends('layouts.premium-dashboard')

@php
    $balanceFormatted = \App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR');
    $currencyCode = $user->default_currency ?? 'EUR';
    $formattedClientIban = $user->iban
        ? trim(chunk_split(preg_replace('/\s+/', '', (string) $user->iban), 4, ' '))
        : __('transactions.not_available');
@endphp

@section('title', __('transactions.page_title'))
@section('dashboard_theme', 'client')
@section('dashboard_page_title', __('transactions.transfer_title'))
@section('dashboard_page_subtitle', __('transactions.transfer_subtitle'))
@section('dashboard_section_label', __('dashboard.client_area'))
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
    <a href="{{ localized_route('transfer.create') }}" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-orange-600 shadow-sm ring-1 ring-orange-200/80">
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
    <span class="inline-flex items-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20">
        <i class="fas fa-paper-plane text-xs"></i>
        {{ __('transactions.new_transfer') }}
    </span>
    <a href="{{ localized_route('transactions.history') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-clock-rotate-left text-xs"></i>
        {{ __('dashboard.history') }}
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .transfer-field {
            background: rgba(248, 250, 252, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.24);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72);
            transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
        }

        .transfer-field:focus {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(249, 115, 22, 0.48);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.12);
            outline: none;
        }

        .transfer-group {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 250, 252, 0.88));
            border: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
        }

        .transfer-step {
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
        }

        .transfer-step.is-active {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.18);
        }

        .transfer-draft-item {
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(248, 250, 252, 0.82);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                backdrop-filter: blur(0);
            }

            to {
                opacity: 1;
                backdrop-filter: blur(10px);
            }
        }

        @keyframes flashPromptIn {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.94);
                filter: blur(3px);
            }

            65% {
                opacity: 1;
                transform: translateY(-2px) scale(1.01);
                filter: blur(0);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes flashPromptPulse {
            0% {
                box-shadow: 0 30px 80px rgba(15, 23, 42, 0.36), 0 0 0 0 rgba(59, 130, 246, 0.22);
            }

            100% {
                box-shadow: 0 30px 80px rgba(15, 23, 42, 0.36), 0 0 0 18px rgba(59, 130, 246, 0);
            }
        }

        @keyframes flashErrorNudge {
            0% { transform: translateX(0); }
            20% { transform: translateX(-5px); }
            40% { transform: translateX(5px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
            100% { transform: translateX(0); }
        }

        @keyframes flashSuccessPulse {
            0% {
                box-shadow: 0 28px 72px rgba(15, 23, 42, 0.34), 0 0 0 0 rgba(16, 185, 129, 0.2);
            }

            100% {
                box-shadow: 0 28px 72px rgba(15, 23, 42, 0.34), 0 0 0 16px rgba(16, 185, 129, 0);
            }
        }

        @keyframes flashIconFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-3px);
            }
        }

        .icon-fade-transition {
            transition: opacity 0.5s ease, transform 0.5s ease;
            opacity: 0;
            transform: scale(0.8);
        }

        .icon-visible {
            opacity: 1 !important;
            transform: scale(1) !important;
        }

        .flash-overlay {
            position: fixed !important;
            inset: 0;
            display: none;
            place-items: center;
            padding: clamp(0.75rem, 2vw, 2rem);
            min-height: 100dvh;
            background:
                radial-gradient(1200px 540px at 50% -10%, rgba(249, 115, 22, 0.18), transparent 72%),
                rgba(15, 23, 42, 0.62);
            backdrop-filter: blur(8px);
            z-index: 9999 !important;
        }

        .flash-overlay.is-visible {
            display: grid;
            animation: fadeIn 0.25s ease forwards;
        }

        .flash-card {
            --accent: #ef4444;
            --accent-strong: #dc2626;
            --accent-soft: rgba(239, 68, 68, 0.12);
            width: min(560px, calc(100vw - 1.5rem));
            max-height: min(88dvh, 760px);
            border-radius: 1.5rem;
            padding: clamp(1.15rem, 2.5vw, 2rem);
            text-align: center;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(248, 250, 252, 0.94));
            border: 1px solid rgba(148, 163, 184, 0.28);
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.36);
            position: relative;
            overflow: auto;
            scrollbar-width: thin;
        }

        .flash-card::before {
            content: '';
            position: absolute;
            inset: -80px auto auto -70px;
            width: 170px;
            height: 170px;
            border-radius: 9999px;
            background: radial-gradient(circle, var(--accent-soft), transparent 65%);
            pointer-events: none;
        }

        .flash-card--flashin {
            animation: flashPromptIn 0.42s cubic-bezier(0.16, 1, 0.3, 1), flashPromptPulse 0.92s ease 0.08s 1;
        }

        .flash-card--error-attention {
            animation: flashPromptIn 0.42s cubic-bezier(0.16, 1, 0.3, 1), flashErrorNudge 0.45s ease-out 0.08s 1;
        }

        .flash-card--success-attention {
            animation: flashPromptIn 0.42s cubic-bezier(0.16, 1, 0.3, 1), flashSuccessPulse 0.8s ease 0.08s 1;
        }

        .flash-card::after {
            content: '';
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-strong));
        }

        .flash-card--success {
            --accent: #10b981;
            --accent-strong: #059669;
            --accent-soft: rgba(16, 185, 129, 0.16);
        }

        .flash-card--progress {
            --accent: #f97316;
            --accent-strong: #ea580c;
            --accent-soft: rgba(249, 115, 22, 0.16);
        }

        .flash-icon-container {
            background: var(--accent-soft);
            width: 72px;
            height: 72px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.25);
        }

        .flash-icon-container--animated {
            animation: flashIconFloat 2.1s ease-in-out infinite;
        }

        .flash-icon {
            color: var(--accent);
            font-size: 1.75rem;
        }

        .flash-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }

        .flash-message {
            color: #475569;
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            word-break: break-word;
        }

        .flash-client-panel {
            margin-bottom: 1rem;
            text-align: left;
            border-radius: 1rem;
            border: 1px solid rgba(249, 115, 22, 0.2);
            background: linear-gradient(135deg, rgba(255, 247, 237, 0.95), rgba(255, 255, 255, 0.95));
            padding: 0.9rem 1rem;
        }

        .flash-client-panel.hidden {
            display: none;
        }

        .flash-client-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.75rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: #c2410c;
            font-weight: 700;
            background: rgba(249, 115, 22, 0.12);
            border: 1px solid rgba(249, 115, 22, 0.16);
            border-radius: 9999px;
            padding: 0.32rem 0.65rem;
            margin-bottom: 0.75rem;
        }

        .flash-client-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.55rem;
        }

        .flash-client-row {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(148, 163, 184, 0.24);
            border-radius: 0.75rem;
            padding: 0.6rem 0.75rem;
        }

        .flash-client-label {
            display: block;
            font-size: 0.72rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin-bottom: 0.2rem;
        }

        .flash-client-value {
            display: block;
            color: #0f172a;
            font-size: 0.92rem;
            font-weight: 700;
            word-break: break-word;
        }

        .flash-button {
            width: 100%;
            border-radius: 0.9rem;
            padding: 0.85rem 1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .flash-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.24);
        }

        .flash-button:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.2), 0 18px 35px rgba(15, 23, 42, 0.24);
        }

        .flash-progress-wrap {
            text-align: left;
            margin: 1.25rem 0 0.75rem;
            padding: 1rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.08), rgba(251, 191, 36, 0.08));
            border: 1px solid rgba(249, 115, 22, 0.16);
        }

        .flash-progress-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #334155;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.65rem;
        }

        .flash-progress-track {
            width: 100%;
            height: 0.7rem;
            border-radius: 9999px;
            background: rgba(148, 163, 184, 0.35);
            overflow: hidden;
        }

        .flash-progress-fill {
            width: 0%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #f97316, #f59e0b);
            transition: width 0.45s ease;
        }

        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        @media (min-width: 520px) {
            .flash-client-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .flash-overlay {
                padding: 0.6rem;
            }

            .flash-card {
                width: min(100vw - 0.6rem, 100%);
                max-height: 90dvh;
                border-radius: 1.1rem;
                padding: 1.15rem;
            }
        }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 flex flex-col gap-6 2xl:flex-row 2xl:items-end 2xl:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-[0.22em] text-white/65">{{ __('dashboard.secure_session') }}</p>
                <h2 class="mt-4 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">
                    {{ __('transactions.transfer_details') }}
                </h2>
                <p class="mt-3 text-sm leading-6 text-white/78 sm:text-base">
                    {{ __('transactions.transfer_subtitle') }}
                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-3 2xl:min-w-[520px]">
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('dashboard.current_balance') }}</p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $balanceFormatted }}</p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('dashboard.operations_to_track') }}</p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $pendingOperationsCount }}</p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('dashboard.notifications') }}</p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $unreadNotificationsCount }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.55fr)_minmax(320px,380px)]">
        <section class="space-y-6">
            <div class="premium-panel rounded-[30px] bg-slate-900 p-5 sm:p-6">
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="transfer-step is-active rounded-[24px] px-4 py-4 text-white">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/16 text-sm shadow-sm">
                            <i class="fas fa-edit"></i>
                        </div>
                        <p class="mt-4 text-sm font-semibold">{{ __('transactions.step_information') }}</p>
                    </div>
                    <div class="transfer-step rounded-[24px] px-4 py-4 text-white/82">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/12 text-sm shadow-sm">
                            <i class="fas fa-cog"></i>
                        </div>
                        <p class="mt-4 text-sm font-semibold">{{ __('transactions.step_processing') }}</p>
                    </div>
                    <div class="transfer-step rounded-[24px] px-4 py-4 text-white/82">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/12 text-sm shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="mt-4 text-sm font-semibold">{{ __('transactions.step_confirmation') }}</p>
                    </div>
                </div>
            </div>

            <section class="premium-panel premium-card-hover rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-3 border-b border-slate-200/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.immediate_summary') }}</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('transactions.transfer_details') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('transactions.beneficiary_info') }}</p>
                    </div>
                    <div class="rounded-full bg-orange-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-orange-700 ring-1 ring-orange-200/80">
                        {{ __('transactions.new_transfer') }}
                    </div>
                </div>

                <form id="transferForm" method="POST" class="mt-6 space-y-6">
                    @csrf

                    <div class="grid gap-6 xl:grid-cols-2">
                        <div class="transfer-group rounded-[28px] p-5 xl:col-span-2">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                    <i class="fas fa-wallet"></i>
                                </span>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-950">{{ __('transactions.transfer_amount') }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ __('transactions.transfer_subtitle') }}</p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <label for="amount" class="mb-3 block text-sm font-semibold text-slate-800">
                                    {{ __('transactions.transfer_amount') }}
                                </label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="fas fa-euro-sign"></i>
                                    </span>
                                    <input
                                        type="number"
                                        step="0.01"
                                        id="amount"
                                        name="amount"
                                        value="{{ old('amount') }}"
                                        required
                                        class="transfer-field input-field block w-full rounded-2xl px-4 py-3.5 pl-12 text-sm text-slate-900 placeholder:text-slate-400"
                                        placeholder="{{ __('transactions.amount_placeholder') }}"
                                    >
                                </div>
                                @error('amount')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="transfer-group rounded-[28px] p-5">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                    <i class="fas fa-user"></i>
                                </span>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-950">{{ __('transactions.beneficiary_info') }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ __('transactions.recipient_name') }}</p>
                                </div>
                            </div>

                            <div class="mt-5 space-y-5">
                                <div>
                                    <label for="recipient_name" class="mb-3 block text-sm font-semibold text-slate-800">
                                        {{ __('transactions.recipient_name') }}
                                    </label>
                                    <input
                                        type="text"
                                        id="recipient_name"
                                        name="recipient_name"
                                        value="{{ old('recipient_name') }}"
                                        required
                                        class="transfer-field input-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400"
                                        placeholder="{{ __('transactions.recipient_name_placeholder') }}"
                                    >
                                    @error('recipient_name')
                                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bank_name" class="mb-3 block text-sm font-semibold text-slate-800">
                                        {{ __('transactions.bank_name') }}
                                    </label>
                                    <input
                                        type="text"
                                        id="bank_name"
                                        name="bank_name"
                                        value="{{ old('bank_name') }}"
                                        required
                                        class="transfer-field input-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400"
                                        placeholder="{{ __('transactions.bank_name_placeholder') }}"
                                    >
                                    @error('bank_name')
                                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="transfer-group rounded-[28px] p-5">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700">
                                    <i class="fas fa-building-columns"></i>
                                </span>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-950">{{ __('transactions.banking_details') }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ __('transactions.recipient_iban') }}</p>
                                </div>
                            </div>

                            <div class="mt-5 space-y-5">
                                <div>
                                    <label for="recipient_iban" class="mb-3 block text-sm font-semibold text-slate-800">
                                        {{ __('transactions.recipient_iban') }}
                                    </label>
                                    <input
                                        type="text"
                                        id="recipient_iban"
                                        name="recipient_iban"
                                        value="{{ old('recipient_iban') }}"
                                        required
                                        class="transfer-field input-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400"
                                        placeholder="{{ __('transactions.recipient_iban_placeholder') }}"
                                    >
                                    @error('recipient_iban')
                                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="recipient_bic" class="mb-3 block text-sm font-semibold text-slate-800">
                                        {{ __('transactions.recipient_bic') }}
                                    </label>
                                    <input
                                        type="text"
                                        id="recipient_bic"
                                        name="recipient_bic"
                                        value="{{ old('recipient_bic') }}"
                                        required
                                        class="transfer-field input-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400"
                                        placeholder="{{ __('transactions.recipient_bic_placeholder') }}"
                                    >
                                    @error('recipient_bic')
                                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="transfer-group rounded-[28px] p-5 xl:col-span-2">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-950">{{ __('transactions.additional_info') }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ __('transactions.activation_code') }}</p>
                                </div>
                            </div>

                            <div class="mt-5 grid gap-5 xl:grid-cols-2">
                                <div>
                                    <label for="reason" class="mb-3 block text-sm font-semibold text-slate-800">
                                        {{ __('transactions.transfer_reason') }}
                                    </label>
                                    <input
                                        type="text"
                                        id="reason"
                                        name="reason"
                                        value="{{ old('reason') }}"
                                        class="transfer-field input-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400"
                                        placeholder="{{ __('transactions.transfer_reason_placeholder') }}"
                                    >
                                    @error('reason')
                                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="activation_code" class="mb-3 block text-sm font-semibold text-slate-800">
                                        {{ __('transactions.activation_code') }}
                                    </label>
                                    <input
                                        type="text"
                                        id="activation_code"
                                        name="activation_code"
                                        value="{{ old('activation_code') }}"
                                        required
                                        class="transfer-field input-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400"
                                        placeholder="{{ __('transactions.activation_code_placeholder') }}"
                                    >
                                    @error('activation_code')
                                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200/70 pt-6 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ localized_route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                            <i class="fas fa-arrow-left text-xs"></i>
                            {{ __('transactions.cancel') }}
                        </a>
                        <button type="button" id="startBtn" class="inline-flex min-w-[220px] items-center justify-center gap-2 rounded-full border border-orange-300 bg-orange-500 px-6 py-3.5 text-sm font-semibold text-white shadow-[0_18px_45px_rgba(249,115,22,0.35)] transition hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-200 disabled:cursor-not-allowed disabled:opacity-80">
                            <i class="fas fa-paper-plane text-xs"></i>
                            {{ __('transactions.start_transfer') }}
                        </button>
                    </div>
                </form>
            </section>
        </section>

        <aside class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.instant_reading') }}</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('transactions.transfer_progress') }}</h2>
                    </div>
                    <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                        {{ __('dashboard.real_time') }}
                    </span>
                </div>

                <div class="mt-5 space-y-3">
                    <div class="transfer-draft-item rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('transactions.transfer_amount') }}</p>
                        <p id="transferSummaryAmount" class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">0.00 {{ $currencyCode }}</p>
                    </div>
                    <div class="transfer-draft-item rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('transactions.recipient_name') }}</p>
                        <p id="transferSummaryRecipient" class="mt-2 text-sm font-semibold text-slate-900">{{ __('transactions.not_available') }}</p>
                    </div>
                    <div class="transfer-draft-item rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400">{{ __('transactions.recipient_iban') }}</p>
                        <p id="transferSummaryIban" class="mt-2 break-all text-sm font-semibold text-slate-900">{{ __('transactions.not_available') }}</p>
                    </div>
                </div>
            </section>

            <section class="premium-gradient-card rounded-[30px] p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-white/65">{{ __('dashboard.current_balance') }}</p>
                <h3 class="mt-3 premium-brand-title text-3xl font-semibold">{{ $balanceFormatted }}</h3>
                <div class="mt-5 space-y-3">
                    <div class="rounded-[22px] bg-white/10 px-4 py-3">
                        <p class="text-xs uppercase tracking-[0.16em] text-white/60">{{ __('transactions.client_name_label') }}</p>
                        <p class="mt-1 text-sm font-semibold">{{ $user->name }}</p>
                    </div>
                    <div class="rounded-[22px] bg-white/10 px-4 py-3">
                        <p class="text-xs uppercase tracking-[0.16em] text-white/60">{{ __('transactions.client_iban_label') }}</p>
                        <p class="mt-1 break-all text-sm font-semibold">{{ $formattedClientIban }}</p>
                    </div>
                </div>
            </section>

            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('dashboard.secure_area') }}</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('dashboard.priority_access') }}</h3>
                <p class="mt-3 text-sm leading-6 text-slate-500">{{ __('dashboard.secure_area_description') }}</p>

                <div class="mt-5 space-y-3">
                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ __('dashboard.operations_to_track') }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ __('dashboard.operations_to_track_description') }}</p>
                            </div>
                            <span class="premium-brand-title text-3xl font-semibold text-slate-950">{{ $pendingOperationsCount }}</span>
                        </div>
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

    <div id="flashOverlay" class="flash-overlay" aria-hidden="true">
        <div id="flashCard" class="flash-card flash-card--error" role="dialog" aria-modal="true" aria-labelledby="flashTitle" aria-describedby="flashMessage">
            <div id="flashIconContainer" class="flash-icon-container">
                <i id="flashIcon" class="flash-icon fas fa-exclamation-triangle"></i>
            </div>
            <h3 id="flashTitle" class="flash-title">{{ __('transactions.operation_interrupted') }}</h3>
            <div id="flashClientPanel" class="flash-client-panel hidden">
                <span class="flash-client-badge">
                    <i class="fas fa-shield-alt"></i>{{ __('transactions.client_info_title') }}
                </span>
                <div class="flash-client-grid">
                    <div class="flash-client-row">
                        <span class="flash-client-label">{{ __('transactions.client_name_label') }}</span>
                        <span id="flashClientName" class="flash-client-value">{{ __('transactions.not_available') }}</span>
                    </div>
                    <div class="flash-client-row">
                        <span class="flash-client-label">{{ __('transactions.client_iban_label') }}</span>
                        <span id="flashClientIban" class="flash-client-value">{{ __('transactions.not_available') }}</span>
                    </div>
                </div>
            </div>
            <p id="flashMessage" class="flash-message"></p>
            <div id="flashProgressWrap" class="flash-progress-wrap hidden" aria-live="polite">
                <div class="flash-progress-head">
                    <span>{{ __('transactions.progress_label') }}</span>
                    <span id="flashProgressText">0%</span>
                </div>
                <div class="flash-progress-track">
                    <div id="flashProgressBar" class="flash-progress-fill progress-bar"></div>
                </div>
            </div>
            <button id="closeFlash" class="flash-button">
                <i class="fas fa-check mr-2"></i>{{ __('transactions.understood') }}
            </button>
        </div>
    </div>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const transferForm = document.getElementById('transferForm');
            const startBtn = document.getElementById('startBtn');
            const overlay = document.getElementById('flashOverlay');
            const flashMsg = document.getElementById('flashMessage');
            const closeFlash = document.getElementById('closeFlash');
            const flashIcon = document.getElementById('flashIcon');
            const flashIconContainer = document.getElementById('flashIconContainer');
            const flashCard = document.getElementById('flashCard');
            const flashTitle = document.getElementById('flashTitle');
            const flashProgressWrap = document.getElementById('flashProgressWrap');
            const flashProgressBar = document.getElementById('flashProgressBar');
            const flashProgressText = document.getElementById('flashProgressText');
            const flashClientPanel = document.getElementById('flashClientPanel');
            const flashClientName = document.getElementById('flashClientName');
            const flashClientIban = document.getElementById('flashClientIban');
            const summaryAmount = document.getElementById('transferSummaryAmount');
            const summaryRecipient = document.getElementById('transferSummaryRecipient');
            const summaryIban = document.getElementById('transferSummaryIban');

            if (!transferForm || !startBtn || !overlay) {
                return;
            }

            let txId = null;
            let ticking = false;
            let progressMode = false;
            let audioContext = null;
            let soundUnlocked = false;
            let transferClientSnapshot = {
                name: '',
                iban: ''
            };

            function getOnHoldFallbackMessage() {
                return '{{ __('transactions.transaction_on_hold') }}';
            }

            function formatIban(iban) {
                const compact = (iban || '').replace(/\s+/g, '').toUpperCase();
                if (!compact) {
                    return '{{ __('transactions.not_available') }}';
                }

                return compact.match(/.{1,4}/g).join(' ');
            }

            function formatAmount(amount) {
                const normalized = Number.parseFloat(amount);

                if (Number.isNaN(normalized)) {
                    return '0.00 {{ $currencyCode }}';
                }

                return normalized.toFixed(2) + ' {{ $currencyCode }}';
            }

            function updateTransferSummary() {
                const amountInput = document.getElementById('amount');
                const recipientNameInput = document.getElementById('recipient_name');
                const recipientIbanInput = document.getElementById('recipient_iban');

                summaryAmount.textContent = formatAmount(amountInput ? amountInput.value : 0);
                summaryRecipient.textContent = recipientNameInput && recipientNameInput.value.trim() !== ''
                    ? recipientNameInput.value.trim()
                    : '{{ __('transactions.not_available') }}';
                summaryIban.textContent = formatIban(recipientIbanInput ? recipientIbanInput.value : '');
            }

            function buildClientSnapshot() {
                const recipientNameInput = document.getElementById('recipient_name');
                const recipientIbanInput = document.getElementById('recipient_iban');
                const name = (recipientNameInput && recipientNameInput.value ? recipientNameInput.value : '').trim();
                const iban = (recipientIbanInput && recipientIbanInput.value ? recipientIbanInput.value : '').trim();

                return {
                    name: name || '{{ __('transactions.not_available') }}',
                    iban: formatIban(iban),
                };
            }

            function updateClientPanel() {
                const source = transferClientSnapshot && (transferClientSnapshot.name || transferClientSnapshot.iban)
                    ? transferClientSnapshot
                    : buildClientSnapshot();

                flashClientName.textContent = source.name || '{{ __('transactions.not_available') }}';
                flashClientIban.textContent = source.iban || '{{ __('transactions.not_available') }}';
            }

            function updateSnapshotFromServer(data) {
                if (!data || typeof data !== 'object') {
                    return;
                }

                const serverName = (data.recipient_name || '').trim();
                const serverIban = (data.recipient_iban || '').trim();

                if (serverName === '' && serverIban === '') {
                    return;
                }

                transferClientSnapshot = {
                    name: serverName || transferClientSnapshot.name || '{{ __('transactions.not_available') }}',
                    iban: serverIban ? formatIban(serverIban) : (transferClientSnapshot.iban || '{{ __('transactions.not_available') }}'),
                };
            }

            function resolveInterruptionMessage(rawMessage) {
                if (typeof rawMessage !== 'string') {
                    return getOnHoldFallbackMessage();
                }

                const normalized = rawMessage.trim();

                return normalized !== '' ? normalized : getOnHoldFallbackMessage();
            }

            function getAudioContext() {
                if (!audioContext) {
                    audioContext = new (window.AudioContext || window.webkitAudioContext)();
                }

                return audioContext;
            }

            function unlockAudio() {
                try {
                    const ctx = getAudioContext();
                    if (ctx.state === 'suspended') {
                        ctx.resume();
                    }
                } catch (error) {
                }
            }

            function playTone(frequency, startTime, duration, volume) {
                const ctx = getAudioContext();
                const oscillator = ctx.createOscillator();
                const gainNode = ctx.createGain();

                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(frequency, startTime);
                gainNode.gain.setValueAtTime(0, startTime);
                gainNode.gain.linearRampToValueAtTime(volume, startTime + 0.02);
                gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);

                oscillator.connect(gainNode);
                gainNode.connect(ctx.destination);

                oscillator.start(startTime);
                oscillator.stop(startTime + duration + 0.02);
            }

            function playModalSound(type) {
                if (!soundUnlocked) {
                    return;
                }

                try {
                    const ctx = getAudioContext();
                    const now = ctx.currentTime;

                    if (type === 'success') {
                        playTone(660, now, 0.2, 0.07);
                        playTone(880, now + 0.05, 0.25, 0.06);
                    } else {
                        playTone(360, now, 0.25, 0.08);
                    }
                } catch (error) {
                }
            }

            document.addEventListener('click', function () {
                soundUnlocked = true;
                unlockAudio();
            }, { once: true });

            function setProgress(progress) {
                flashProgressBar.style.width = progress + '%';
                flashProgressText.textContent = progress + '%';
            }

            function openOverlay() {
                overlay.classList.add('is-visible');
                overlay.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
            }

            function triggerFlashCardAnimation(type) {
                flashCard.classList.remove('flash-card--flashin', 'flash-card--error-attention', 'flash-card--success-attention');
                void flashCard.offsetWidth;

                if (type === 'error') {
                    flashCard.classList.add('flash-card--error-attention');
                    return;
                }

                if (type === 'success') {
                    flashCard.classList.add('flash-card--success-attention');
                    return;
                }

                flashCard.classList.add('flash-card--flashin');
            }

            function showProgressFlash() {
                progressMode = true;
                flashIcon.classList.remove('icon-visible');
                flashIcon.className = 'flash-icon fas fa-spinner fa-spin icon-fade-transition';
                flashIconContainer.className = 'flash-icon-container';
                flashIconContainer.classList.add('flash-icon-container--animated');
                flashCard.classList.remove('flash-card--success', 'flash-card--error');
                flashCard.classList.add('flash-card--progress');
                flashTitle.textContent = '{{ __('transactions.processing') }}';
                flashMsg.textContent = '{{ __('transactions.processing_message') }}';
                flashClientPanel.classList.add('hidden');
                flashProgressWrap.classList.remove('hidden');
                closeFlash.classList.add('hidden');
                openOverlay();
                triggerFlashCardAnimation('progress');

                setTimeout(function () {
                    flashIcon.classList.add('icon-visible');
                }, 50);
            }

            function resetStartButton() {
                startBtn.disabled = false;
                startBtn.innerHTML = '<i class="fas fa-paper-plane text-xs"></i>{{ __('transactions.start_transfer') }}';
            }

            function showMessage(message, type) {
                progressMode = false;
                flashMsg.textContent = message;
                flashProgressWrap.classList.add('hidden');
                closeFlash.classList.remove('hidden');
                flashIcon.classList.remove('icon-visible');
                flashIcon.classList.add('icon-fade-transition');
                flashCard.classList.remove('flash-card--success', 'flash-card--error', 'flash-card--progress');

                if (type === 'success') {
                    flashIcon.className = 'flash-icon fas fa-check-circle icon-fade-transition';
                    flashIconContainer.className = 'flash-icon-container';
                    flashIconContainer.classList.add('flash-icon-container--animated');
                    flashCard.classList.add('flash-card--success');
                    flashTitle.textContent = '{{ __('transactions.operation_success') }}';
                    flashClientPanel.classList.add('hidden');

                    setTimeout(function () {
                        flashIcon.classList.add('icon-visible');
                    }, 50);
                } else {
                    flashIcon.className = 'flash-icon fas fa-exclamation-triangle icon-fade-transition';
                    flashIconContainer.className = 'flash-icon-container';
                    flashIconContainer.classList.add('flash-icon-container--animated');
                    flashCard.classList.add('flash-card--error');
                    flashTitle.textContent = '{{ __('transactions.operation_interrupted') }}';
                    updateClientPanel();
                    flashClientPanel.classList.remove('hidden');

                    setTimeout(function () {
                        flashIcon.classList.add('icon-visible');
                    }, 50);
                }

                openOverlay();
                triggerFlashCardAnimation(type);
                playModalSound(type);
            }

            async function tick() {
                if (!ticking || !txId) {
                    return;
                }

                try {
                    const res = await fetch('{{ localized_route('transactions.progress') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ tx_id: txId })
                    });
                    const data = await res.json();

                    updateSnapshotFromServer(data);
                    setProgress(data.progress);

                    if (data.status === 'on_hold') {
                        ticking = false;
                        resetStartButton();
                        showMessage(resolveInterruptionMessage(data.message), 'error');
                        return;
                    }

                    if (data.status === 'success') {
                        ticking = false;
                        resetStartButton();
                        setProgress(100);
                        showMessage('{{ __('transactions.transfer_success_message') }}', 'success');

                        setTimeout(function () {
                            window.location.href = '{{ localized_route('transactions.history') }}';
                        }, 2000);
                        return;
                    }

                    setTimeout(tick, 500);
                } catch (error) {
                    ticking = false;
                    resetStartButton();
                    showMessage('{{ __('transactions.connection_error_processing') }}', 'error');
                }
            }

            async function handleTransferStart() {
                if (ticking) {
                    return;
                }

                soundUnlocked = true;
                unlockAudio();
                transferClientSnapshot = buildClientSnapshot();

                try {
                    const res = await fetch('{{ localized_route('transactions.start') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: new FormData(transferForm)
                    });
                    const data = await res.json().catch(function () {
                        return {};
                    });

                    if (res.ok) {
                        txId = data.tx_id;
                        ticking = true;
                        setProgress(0);
                        showProgressFlash();
                        startBtn.disabled = true;
                        startBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>{{ __('transactions.processing_in_progress') }}';
                        tick();
                        return;
                    }

                    const firstError = data.errors
                        ? Object.values(data.errors)[0][0]
                        : (data.message || '{{ __('transactions.error_starting_transfer') }}');
                    showMessage(firstError, 'error');
                } catch (error) {
                    showMessage('{{ __('transactions.connection_error') }}', 'error');
                }
            }

            startBtn.addEventListener('click', handleTransferStart);

            closeFlash.addEventListener('click', function () {
                if (progressMode) {
                    return;
                }

                overlay.classList.remove('is-visible');
                overlay.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
            });

            overlay.addEventListener('click', function (event) {
                if (progressMode) {
                    return;
                }

                if (event.target === overlay) {
                    overlay.classList.remove('is-visible');
                    overlay.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('overflow-hidden');
                }
            });

            document.querySelectorAll('.input-field').forEach(function (input) {
                input.addEventListener('input', function () {
                    updateTransferSummary();
                });
            });

            updateTransferSummary();
        });
    </script>
@endpush
