@extends('layouts.admin-premium')

@php
    $targetUser = $selectedUser;
    $stopPercentage = old('stop_percentage', $settings->stop_percentage ?? 1);
    $stopMessage = old('stop_message', $settings->stop_message ?? __('admin_pages.transaction_suspended'));
@endphp

@section('title', __('admin_pages.settings_title'))
@section('admin_nav_active', 'settings')
@section('dashboard_page_title', __('admin_pages.transfer_settings_title'))
@section('dashboard_page_subtitle', __('admin_pages.settings_subtitle'))
@section('dashboard_section_label', __('admin_pages.system_settings'))

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.deposit') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-plus-circle text-xs"></i>
        {{ __('admin_pages.new_deposit') }}
    </a>
    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-users text-xs"></i>
        {{ __('admin_pages.users') }}
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .emoji-btn { display: inline-flex; align-items: center; gap: .45rem; border-radius: 9999px; border: 1px solid rgba(14,116,144,.25); background: linear-gradient(135deg, rgba(236,254,255,.9), rgba(224,242,254,.9)); color: #0f766e; font-weight: 700; font-size: .75rem; padding: .45rem .75rem; transition: all .25s ease; }
        .emoji-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgba(15,23,42,.12); }
        .emoji-picker__wrapper, .emoji-picker { z-index: 25000 !important; }

        /* Transfer stop-rule card — modern redesign */
        .stop-rule-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 32px;
            background:
                radial-gradient(circle at 100% -10%, rgba(37, 99, 235, .10), transparent 42%),
                radial-gradient(circle at 0% 100%, rgba(249, 115, 22, .06), transparent 40%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 24px 60px rgba(15, 23, 42, .08);
        }

        .stop-rule-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, #2563eb, #7c3aed, #2563eb);
            background-size: 200% 100%;
            animation: stopRuleShimmer 6s linear infinite;
        }

        @keyframes stopRuleShimmer { to { background-position: -200% 0; } }

        /* Circular gauge showing the stop threshold */
        .gauge-wrap {
            position: relative;
            display: grid;
            place-items: center;
            width: 132px;
            height: 132px;
            flex-shrink: 0;
        }

        .gauge-ring {
            transform: rotate(-90deg);
        }

        .gauge-ring circle {
            fill: none;
            stroke-width: 10;
        }

        .gauge-ring .gauge-track {
            stroke: #e2e8f0;
        }

        .gauge-ring .gauge-fill {
            stroke: url(#gaugeGradient);
            stroke-linecap: round;
            transition: stroke-dashoffset .25s cubic-bezier(.16,1,.3,1);
        }

        .gauge-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .gauge-center strong {
            font-size: 1.7rem;
            font-weight: 800;
            font-variant-numeric: tabular-nums;
            color: #0f172a;
            line-height: 1;
        }

        .gauge-center span {
            margin-top: 4px;
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #94a3b8;
        }

        /* Range slider */
        .stop-range {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(90deg, #2563eb var(--range-progress, 70%), #e2e8f0 var(--range-progress, 70%));
            outline: none;
            cursor: pointer;
        }

        .stop-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .35);
            cursor: grab;
            transition: transform .15s ease;
        }

        .stop-range::-webkit-slider-thumb:hover {
            transform: scale(1.12);
        }

        .stop-range::-moz-range-thumb {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .35);
            cursor: grab;
        }

        .stop-range::-moz-range-track {
            height: 10px;
            border-radius: 999px;
            background: #e2e8f0;
        }

        /* Message textarea with char counter */
        .stop-message-wrap {
            position: relative;
        }

        .stop-message-counter {
            position: absolute;
            right: 14px;
            bottom: 12px;
            font-size: .7rem;
            font-weight: 700;
            color: #94a3b8;
            background: rgba(248, 250, 252, .92);
            padding: 2px 8px;
            border-radius: 999px;
            pointer-events: none;
        }

        /* Phone-style live preview */
        .phone-preview {
            position: relative;
            border-radius: 28px;
            padding: 4px;
            background: linear-gradient(180deg, #0f172a, #1e293b);
            box-shadow: 0 20px 44px rgba(15, 23, 42, .22);
        }

        .phone-preview__notch {
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 16px;
            border-radius: 0 0 12px 12px;
            background: #0f172a;
            z-index: 2;
        }

        .phone-preview__screen {
            position: relative;
            border-radius: 24px;
            background: linear-gradient(180deg, #fff7ed, #fffbeb);
            padding: 26px 16px 16px;
            min-height: 220px;
        }

        .phone-alert {
            border-radius: 18px;
            background: #fff;
            border: 1px solid rgba(245, 158, 11, .3);
            box-shadow: 0 10px 24px rgba(217, 119, 6, .1);
            padding: 16px;
        }

        .submit-stop-rule-btn {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1d4ed8, #2563eb 55%, #7c3aed);
            background-size: 200% 100%;
            box-shadow: 0 16px 32px rgba(37, 99, 235, .28);
            transition: background-position .5s ease, transform .18s ease, box-shadow .18s ease;
        }

        .submit-stop-rule-btn:hover {
            background-position: 100% 0;
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, .34);
        }

        @media (prefers-reduced-motion: reduce) {
            .stop-rule-card::before,
            .submit-stop-rule-btn,
            .gauge-ring .gauge-fill { animation: none; transition: none; }
        }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.current_stop') }}</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $stopPercentage }}%</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.scope') }}</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ __('admin_pages.specific') }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.target_client') }}</p><p class="mt-2 truncate text-lg font-semibold">{{ $targetUser ? $targetUser->first_name . ' ' . $targetUser->last_name : __('admin_pages.choose_client') }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">{{ __('admin_pages.queues_to_process') }}</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $pendingTransactionsCount }}</p></div>
        </div>
    </section>

    @if(session('status'))
        <div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4">
            <p class="text-sm font-semibold text-rose-800">{{ __('admin_pages.validation_errors') }}</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.55fr)_380px]">
        <section class="stop-rule-card p-5 sm:p-7">
            <div class="flex flex-col gap-3 border-b border-slate-200/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-blue-100 text-blue-600"><i class="fas fa-sliders text-[11px]"></i></span>
                        {{ __('admin_pages.configuration') }}
                    </p>
                    <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950 sm:text-3xl">{{ __('admin_pages.transfer_stop_rule') }}</h2>
                    <p class="mt-2 max-w-md text-sm leading-6 text-slate-500">{{ __('admin_pages.transfer_stop_rule_help') }}</p>
                </div>
                <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 ring-1 ring-blue-200/70">
                    <i class="fas fa-shield-halved text-[10px]"></i>
                    {{ __('admin_pages.system_settings') }}
                </span>
            </div>

            <form id="client-settings-form" method="POST" action="{{ localized_route('admin.settings.save') }}" class="mt-6 space-y-7">
                @csrf

                <div>
                    <label for="target_user_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.target_client') }}</label>
                    <select
                        name="target_user_id"
                        id="target_user_id"
                        data-settings-url="{{ localized_route('admin.settings') }}"
                        class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"
                        required
                    >
                        <option value="">{{ __('admin_pages.choose_client') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (string) old('target_user_id', $targetUser?->id) === (string) $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <div class="mt-3 flex items-start gap-3 rounded-2xl border {{ $targetUser ? 'border-blue-200 bg-blue-50 text-blue-800' : 'border-amber-200 bg-amber-50 text-amber-800' }} px-4 py-3 text-sm">
                        <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg {{ $targetUser ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                            <i class="fas {{ $targetUser ? 'fa-user-check' : 'fa-circle-info' }} text-xs"></i>
                        </span>
                        <div class="min-w-0">
                            @if($targetUser)
                                <p class="font-semibold">{{ $targetUser->first_name }} {{ $targetUser->last_name }}</p>
                                <p class="mt-0.5 truncate opacity-75">{{ $targetUser->email }}</p>
                            @else
                                <p class="font-semibold">{{ __('admin_pages.choose_client') }}</p>
                                <p class="mt-0.5 opacity-75">{{ __('admin_pages.specific_rule_help') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <fieldset class="space-y-7 transition-opacity {{ $targetUser ? '' : 'opacity-45' }}" {{ $targetUser ? '' : 'disabled' }}>
                    <div class="flex flex-col gap-6 rounded-[26px] border border-slate-200/70 bg-slate-50/60 p-5 sm:flex-row sm:items-center">
                        <div class="gauge-wrap">
                            <svg viewBox="0 0 132 132" class="gauge-ring" width="132" height="132">
                                <defs>
                                    <linearGradient id="gaugeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#2563eb"/>
                                        <stop offset="100%" stop-color="#7c3aed"/>
                                    </linearGradient>
                                </defs>
                                <circle class="gauge-track" cx="66" cy="66" r="56"/>
                                <circle id="gauge-fill" class="gauge-fill" cx="66" cy="66" r="56" stroke-dasharray="351.86"/>
                            </svg>
                            <div class="gauge-center">
                                <strong id="gauge-value">{{ $stopPercentage }}%</strong>
                            </div>
                        </div>

                        <div class="flex-1">
                            <label for="stop_percentage" class="mb-3 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.stop_percentage') }}</label>
                            <input type="range" name="stop_percentage" id="stop_percentage" min="1" max="100" step="1" value="{{ $stopPercentage }}" class="stop-range" style="--range-progress: {{ $stopPercentage }}%;" required>
                            <div class="mt-3 flex items-center justify-between text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">
                                <span>1%</span>
                                <span>50%</span>
                                <span>100%</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label for="stop_message" class="block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.suspension_message') }}</label>
                            <button type="button" id="emoji-picker-button" class="emoji-btn"><i class="fa-regular fa-face-smile"></i> {{ __('admin_pages.premium_emojis') }}</button>
                        </div>
                        <div class="stop-message-wrap">
                            <textarea name="stop_message" id="stop_message" rows="4" maxlength="240" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>{{ $stopMessage }}</textarea>
                            <span id="stop-message-counter" class="stop-message-counter">{{ strlen($stopMessage) }}/240</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-500">{{ __('admin_pages.stop_message_help') }}</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ localized_route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="fas fa-arrow-left text-xs"></i> {{ __('admin_pages.back') }}</a>
                        <button type="submit" class="submit-stop-rule-btn inline-flex items-center justify-center gap-2 rounded-full px-6 py-3 text-sm font-semibold text-white"><i class="fas fa-save text-xs"></i> {{ __('admin_pages.save') }}</button>
                    </div>
                </fieldset>
            </form>
        </section>

        <aside class="space-y-6">
            <section class="admin-surface rounded-[30px] p-5">
                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                    </span>
                    {{ __('admin_pages.simulation') }}
                </p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.client_preview') }}</h3>

                <div class="phone-preview mt-5">
                    <div class="phone-preview__notch"></div>
                    <div class="phone-preview__screen">
                        <div class="phone-alert">
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><i class="fas fa-triangle-exclamation"></i></span>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-amber-900">{{ __('admin_pages.transaction_suspended') }}</p>
                                    <p id="preview-message" class="mt-1 text-sm leading-6 text-amber-700">{{ $stopMessage }}</p>
                                </div>
                            </div>
                            <div class="mt-4 border-t border-amber-100 pt-3">
                                <div class="flex items-center justify-between text-xs font-semibold text-amber-800">
                                    <span>{{ __('admin_pages.transfer_stops_at_prefix') }}</span>
                                    <span id="preview-percentage">{{ $stopPercentage }}%</span>
                                </div>
                                <div class="mt-2 h-1.5 rounded-full bg-amber-100">
                                    <div id="preview-progress-bar" class="h-1.5 rounded-full bg-gradient-to-r from-amber-400 to-orange-500" style="width: {{ $stopPercentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="admin-surface rounded-[30px] p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.admin_security') }}</p>
                        <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.activation_code') }}</h3>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $targetUser && $hasActivationCode ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $targetUser && $hasActivationCode ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                        @if(!$targetUser)
                            {{ __('admin_pages.choose_client') }}
                        @elseif($hasActivationCode)
                            {{ __('admin_pages.activation_code_configured') }}
                        @else
                            {{ __('admin_pages.activation_code_missing') }}
                        @endif
                    </span>
                </div>

                <p class="mt-3 text-sm leading-6 text-slate-500">{{ __('admin_pages.activation_code_settings_help') }}</p>

                @if($targetUser)
                    <div class="mt-4 flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-3.5 py-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700"><i class="fas fa-user-lock text-xs"></i></span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $targetUser->first_name }} {{ $targetUser->last_name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $targetUser->email }}</p>
                        </div>
                    </div>
                @endif

                <form id="activation-code-form" method="POST" action="{{ localized_route('admin.settings.activation-code') }}" class="mt-5 space-y-4">
                    @csrf
                    <input type="hidden" name="target_user_id" value="{{ $targetUser?->id }}">
                    <input type="hidden" name="stop_percentage" id="activation_stop_percentage" value="{{ $stopPercentage }}">
                    <textarea name="stop_message" id="activation_stop_message" class="hidden" aria-hidden="true">{{ $stopMessage }}</textarea>

                    <fieldset class="space-y-4 transition-opacity {{ $targetUser ? '' : 'opacity-45' }}" {{ $targetUser ? '' : 'disabled' }}>
                        <div>
                            <label for="activation_code" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.new_activation_code') }}</label>
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    id="activation_code"
                                    name="activation_code"
                                    value="{{ old('activation_code') }}"
                                    class="admin-field min-w-0 flex-1 rounded-2xl px-4 py-3 font-mono text-sm font-semibold uppercase tracking-[0.2em] text-slate-800"
                                    placeholder="{{ __('admin_pages.activation_code_placeholder') }}"
                                    minlength="6"
                                    maxlength="6"
                                    pattern="(?=.*[A-Z])(?=.*[0-9])[A-Z0-9]{6}"
                                    autocomplete="off"
                                    autocapitalize="characters"
                                    spellcheck="false"
                                    required
                                >
                                <button type="button" id="generate-activation-code" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl border border-blue-200 bg-blue-50 px-3.5 text-xs font-semibold text-blue-700 transition hover:border-blue-300 hover:bg-blue-100">
                                    <i class="fas fa-wand-magic-sparkles text-[11px]"></i>
                                    {{ __('admin_pages.activation_code_generate') }}
                                </button>
                            </div>
                        </div>

                        <p class="rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-3 text-xs leading-5 text-slate-600">
                            <i class="fas fa-circle-info mr-1.5 text-blue-600"></i>
                            {{ __('admin_pages.activation_code_replace_help') }}
                        </p>

                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-700/20 transition hover:bg-blue-800">
                            <i class="fas fa-key text-xs"></i>
                            {{ __('admin_pages.activation_code_update') }}
                        </button>
                    </fieldset>

                    @unless($targetUser)
                        <p class="text-sm leading-6 text-amber-700">{{ __('admin_pages.activation_code_select_client') }}</p>
                    @endunless
                </form>
            </section>

            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('admin_pages.admin_security') }}</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.password') }}</h3>
                <form method="POST" action="{{ localized_route('admin.password.update') }}" class="mt-5 space-y-4">
                    @csrf
                    <div><label for="current_password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.current_password') }}</label><input type="password" id="current_password" name="current_password" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" autocomplete="current-password" required></div>
                    <div><label for="new_password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.new_password') }}</label><input type="password" id="new_password" name="new_password" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" autocomplete="new-password" required></div>
                    <div><label for="new_password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.confirmation') }}</label><input type="password" id="new_password_confirmation" name="new_password_confirmation" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" autocomplete="new-password" required></div>
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:bg-slate-800"><i class="fas fa-shield-alt text-xs"></i> {{ __('admin_pages.update') }}</button>
                </form>
            </section>
        </aside>
    </div>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stopPercentage = document.getElementById('stop_percentage');
            const gaugeValue = document.getElementById('gauge-value');
            const gaugeFill = document.getElementById('gauge-fill');
            const previewPercentage = document.getElementById('preview-percentage');
            const previewProgressBar = document.getElementById('preview-progress-bar');
            const stopMessage = document.getElementById('stop_message');
            const stopMessageCounter = document.getElementById('stop-message-counter');
            const previewMessage = document.getElementById('preview-message');
            const clientSettingsForm = document.getElementById('client-settings-form');
            const targetUserSelect = document.getElementById('target_user_id');
            const emojiButton = document.getElementById('emoji-picker-button');
            const activationCodeInput = document.getElementById('activation_code');
            const generateActivationCodeButton = document.getElementById('generate-activation-code');
            const activationCodeForm = document.getElementById('activation-code-form');
            const activationStopPercentage = document.getElementById('activation_stop_percentage');
            const activationStopMessage = document.getElementById('activation_stop_message');
            const GAUGE_CIRCUMFERENCE = 351.86;
            let picker = null;

            const updateGauge = (value) => {
                stopPercentage.style.setProperty('--range-progress', `${value}%`);
                gaugeValue.textContent = `${value}%`;
                previewPercentage.textContent = `${value}%`;
                previewProgressBar.style.width = `${value}%`;
                gaugeFill.setAttribute('stroke-dashoffset', String(GAUGE_CIRCUMFERENCE * (1 - value / 100)));
            };

            updateGauge(Math.max(0, Math.min(100, Number(stopPercentage?.value || 0))));

            stopPercentage?.addEventListener('input', function () {
                updateGauge(Math.max(0, Math.min(100, Number(this.value || 0))));
            });

            stopMessage?.addEventListener('input', function () {
                previewMessage.textContent = this.value || @js(__('admin_pages.transaction_suspended'));
                stopMessageCounter.textContent = `${this.value.length}/240`;
            });

            targetUserSelect?.addEventListener('change', function () {
                const settingsUrl = new URL(this.dataset.settingsUrl, window.location.origin);

                if (this.value) {
                    settingsUrl.searchParams.set('target_user_id', this.value);
                }

                this.disabled = true;
                clientSettingsForm?.classList.add('pointer-events-none', 'opacity-70');
                window.location.assign(settingsUrl.toString());
            });

            activationCodeInput?.addEventListener('input', function () {
                this.value = this.value.replace(/[^a-z0-9]/gi, '').toUpperCase().slice(0, 6);
            });

            generateActivationCodeButton?.addEventListener('click', function () {
                const letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
                const digits = '23456789';
                const pool = letters + digits;
                const randomIndex = (length) => {
                    const randomValue = new Uint32Array(1);
                    const upperBound = Math.floor(0x100000000 / length) * length;

                    do {
                        window.crypto.getRandomValues(randomValue);
                    } while (randomValue[0] >= upperBound);

                    return randomValue[0] % length;
                };
                const code = [
                    letters[randomIndex(letters.length)],
                    digits[randomIndex(digits.length)],
                    ...Array.from({ length: 4 }, () => pool[randomIndex(pool.length)]),
                ];

                for (let index = code.length - 1; index > 0; index--) {
                    const swapIndex = randomIndex(index + 1);
                    [code[index], code[swapIndex]] = [code[swapIndex], code[index]];
                }

                activationCodeInput.value = code.join('');
                activationCodeInput.dispatchEvent(new Event('input', { bubbles: true }));
                activationCodeInput.focus();
                activationCodeInput.select();
            });

            activationCodeForm?.addEventListener('submit', function () {
                activationStopPercentage.value = stopPercentage.value;
                activationStopMessage.value = stopMessage.value;
            });

            const insertAtCursor = (input, value) => {
                const start = input.selectionStart || input.value.length;
                const end = input.selectionEnd || input.value.length;
                input.setRangeText(value, start, end, 'end');
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.focus();
            };

            emojiButton?.addEventListener('click', async function () {
                try {
                    if (!picker) {
                        const module = await import('https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js');
                        const EmojiButton = module.EmojiButton || module.default || module;
                        picker = new EmojiButton({ position: 'bottom-start', zIndex: 25001 });
                        picker.on('emoji', (selection) => insertAtCursor(stopMessage, selection.emoji));
                    }

                    picker.togglePicker(emojiButton);
                } catch (error) {
                    emojiButton.disabled = true;
                    emojiButton.classList.add('opacity-60', 'cursor-not-allowed');
                }
            });
        });
    </script>
@endpush
