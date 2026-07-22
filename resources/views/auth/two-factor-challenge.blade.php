@extends('layouts.auth-premium')

@section('title', __('auth.2fa_challenge_heading'))
@section('auth_nav_subtitle', __('auth.2fa_challenge_heading'))

@php
    $emailParts = explode('@', (string) $email, 2);
    $localPart = $emailParts[0] ?? '';
    $maskedLocal = $localPart === ''
        ? '***'
        : substr($localPart, 0, min(2, strlen($localPart))) . str_repeat('*', max(strlen($localPart) - 2, 0));
    $maskedEmail = isset($emailParts[1]) ? $maskedLocal . '@' . $emailParts[1] : $email;
@endphp

@push('auth_premium_head')
    <style>
        .two-factor-orbit {
            position: relative;
            display: grid;
            width: min(17rem, 58vw);
            aspect-ratio: 1;
            place-items: center;
            margin-inline: auto;
        }

        .two-factor-orbit::before,
        .two-factor-orbit::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(125, 211, 252, .22);
            border-radius: 999px;
            animation: twoFactorSpin 14s linear infinite;
        }

        .two-factor-orbit::before { inset: 0; border-top-color: rgba(103, 232, 249, .9); }
        .two-factor-orbit::after { inset: 1.8rem; border-right-color: rgba(251, 146, 60, .9); animation-direction: reverse; animation-duration: 9s; }

        .two-factor-core {
            position: relative;
            z-index: 1;
            display: grid;
            width: 8.5rem;
            aspect-ratio: 1;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 2.5rem;
            background: linear-gradient(145deg, rgba(255, 255, 255, .16), rgba(255, 255, 255, .05));
            box-shadow: 0 30px 70px rgba(0, 0, 0, .28), inset 0 1px 0 rgba(255, 255, 255, .2);
            backdrop-filter: blur(16px);
        }

        .two-factor-core::after {
            content: "";
            position: absolute;
            inset: -.75rem;
            border-radius: 3rem;
            background: radial-gradient(circle, rgba(34, 211, 238, .2), transparent 68%);
            animation: twoFactorPulse 2.4s ease-in-out infinite;
            z-index: -1;
        }

        .two-factor-code-input { font-variant-numeric: tabular-nums; }

        @keyframes twoFactorSpin { to { transform: rotate(360deg); } }
        @keyframes twoFactorPulse { 50% { transform: scale(1.12); opacity: .55; } }

        @media (prefers-reduced-motion: reduce) {
            .two-factor-orbit::before,
            .two-factor-orbit::after,
            .two-factor-core::after { animation: none; }
        }
    </style>
@endpush

@section('auth_nav_actions')
    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="auth-link-btn inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-arrow-left text-xs"></i>
        {{ __('auth.back_to_login') }}
    </a>
    <span class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-950/20">
        <i class="fas fa-shield-halved text-xs"></i>
        2FA
    </span>
@endsection

@section('auth_hero')
    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/70 ring-1 ring-white/10">
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-300 shadow-[0_0_16px_rgba(110,231,183,.8)]"></span>
        {{ __('auth_ui.secure_access') }} · 2FA
    </span>

    <h1 class="auth-heading mt-6 text-4xl font-semibold tracking-[-0.05em] text-white sm:text-5xl">
        {{ __('auth.2fa_challenge_heading') }}
    </h1>
    <p class="mt-4 max-w-2xl text-base leading-7 text-white/76 sm:text-lg">
        {{ __('auth.2fa_challenge_description') }}
    </p>

    <div class="two-factor-orbit mt-7" aria-hidden="true">
        <div class="two-factor-core">
            <i class="fas fa-fingerprint text-5xl text-cyan-200"></i>
        </div>
    </div>

    <div class="mt-7 grid gap-3 sm:grid-cols-3">
        <div class="auth-stat-card">
            <p>{{ __('auth.2fa_code_label') }}</p>
            <div class="mt-3 text-2xl font-semibold text-white">6</div>
            <p class="mt-2 text-sm leading-6 text-white/74">{{ __('auth.2fa_code_placeholder') }}</p>
        </div>
        <div class="auth-stat-card">
            <p>{{ __('auth_ui.bank_level') }}</p>
            <div class="mt-3 text-lg font-semibold text-emerald-300">AES-256</div>
            <p class="mt-2 text-sm leading-6 text-white/74">{{ __('auth_ui.secure_space') }}</p>
        </div>
        <div class="auth-stat-card">
            <p>{{ __('auth.2fa_backup_label') }}</p>
            <div class="mt-3 text-lg font-semibold text-white">24/7</div>
            <p class="mt-2 text-sm leading-6 text-white/74">{{ __('auth.2fa_backup_placeholder') }}</p>
        </div>
    </div>
@endsection

@section('auth_panel')
    <div class="auth-panel-header flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ __('auth_ui.secure_access') }}</p>
            <h2 class="auth-heading mt-2 text-3xl font-semibold tracking-[-0.04em] text-slate-950">{{ __('auth.2fa_challenge_heading') }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('auth.2fa_challenge_description') }}</p>
        </div>
        <span class="inline-flex shrink-0 items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200/80">
            <i class="fas fa-shield-check text-[11px]"></i>
            {{ __('auth_ui.bank_level') }}
        </span>
    </div>

    <div class="mt-6 rounded-[24px] bg-gradient-to-br from-slate-950 to-blue-950 px-5 py-5 text-white shadow-xl shadow-blue-950/15">
        <div class="flex items-center gap-4">
            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-white/10 text-cyan-200 ring-1 ring-white/10">
                <i class="fas fa-user-shield"></i>
            </span>
            <div class="min-w-0">
                <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-white/50">{{ __('auth.2fa_otpauth_label') }}</p>
                <p class="mt-1 truncate text-sm font-semibold text-white">{{ $maskedEmail }}</p>
            </div>
            <span class="ml-auto h-2.5 w-2.5 shrink-0 rounded-full bg-emerald-400 shadow-[0_0_14px_rgba(74,222,128,.8)]"></span>
        </div>
    </div>

    @if ($errors->any())
        <div class="mt-5 rounded-[24px] border border-rose-200 bg-rose-50 px-4 py-4">
            <div class="flex items-start gap-3 text-sm text-rose-700">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-2xl bg-rose-100 text-rose-600"><i class="fas fa-triangle-exclamation"></i></span>
                <p class="pt-2 font-medium">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ localized_route('twofactor.verify', ['locale' => app()->getLocale()]) }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <label for="code" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.2fa_code_label') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-blue-600"><i class="fas fa-mobile-screen-button text-sm"></i></span>
                <input id="code" type="text" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" spellcheck="false" value="{{ old('code') }}" class="auth-input two-factor-code-input w-full rounded-2xl py-4 pl-12 pr-4 text-center text-xl font-bold tracking-[0.38em] text-slate-900" placeholder="000000" autofocus>
            </div>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('auth.2fa_challenge_description') }}</p>
        </div>

        <div class="relative py-1 text-center">
            <span class="relative z-10 bg-white px-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('auth.or') }}</span>
            <span class="absolute inset-x-0 top-1/2 h-px bg-slate-200"></span>
        </div>

        <div>
            <label for="recovery_code" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.2fa_backup_label') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-orange-600"><i class="fas fa-key text-sm"></i></span>
                <input id="recovery_code" type="text" name="recovery_code" autocomplete="off" spellcheck="false" value="{{ old('recovery_code') }}" class="auth-input w-full rounded-2xl py-3.5 pl-12 pr-4 text-sm font-semibold tracking-[0.12em] text-slate-900" placeholder="{{ __('auth.2fa_backup_placeholder') }}">
            </div>
        </div>

        <button type="submit" class="auth-submit inline-flex w-full items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-semibold text-white">
            <i class="fas fa-shield-halved text-xs"></i>
            {{ __('auth.2fa_verify_button') }}
        </button>
    </form>

    <div class="mt-6 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
        <div class="flex items-start gap-3">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-white text-emerald-600 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-lock"></i></span>
            <div>
                <p class="text-sm font-semibold text-slate-900">{{ __('auth_ui.secure_space') }}</p>
                <p class="mt-1 text-sm leading-6 text-slate-500">{{ __('auth.2fa_setup_heading') }}</p>
            </div>
        </div>
    </div>
@endsection

@push('auth_premium_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const codeInput = document.getElementById('code');
            codeInput?.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 6);
            });
        });
    </script>
@endpush
