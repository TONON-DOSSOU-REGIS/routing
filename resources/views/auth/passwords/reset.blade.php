@extends('layouts.auth-premium')

@section('title', __('auth.reset_password_title'))
@section('auth_nav_subtitle', 'Secure password reset')

@section('auth_nav_actions')
    <a href="{{ localized_route('home') }}" class="auth-link-btn inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-house text-xs"></i>
        {{ __('auth.nav_home') }}
    </a>
    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition hover:bg-orange-600">
        <i class="fas fa-right-to-bracket text-xs"></i>
        {{ __('auth.nav_login') }}
    </a>
@endsection

@section('auth_hero')
    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/70 ring-1 ring-white/10">
        <span class="h-2.5 w-2.5 rounded-full bg-orange-400"></span>
        Reset
    </span>

    <h1 class="auth-heading mt-6 text-4xl font-semibold tracking-[-0.05em] text-white sm:text-5xl">
        {{ __('auth.reset_password_title') }}
    </h1>
    <p class="mt-4 max-w-2xl text-base leading-7 text-white/76 sm:text-lg">
        {{ __('auth.reset_password_subtitle') }}
    </p>

    <div class="mt-10 space-y-3">
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-lock text-sm"></i></span>
            <span class="text-sm font-semibold">{{ __('auth.new_password') }}</span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-shield-halved text-sm"></i></span>
            <span class="text-sm font-semibold">{{ __('auth.login_feature_security') }}</span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-arrow-left text-sm"></i></span>
            <span class="text-sm font-semibold">{{ __('auth.back_to_login') }}</span>
        </div>
    </div>
@endsection

@section('auth_panel')
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Reset</p>
            <h2 class="auth-heading mt-2 text-3xl font-semibold tracking-[-0.04em] text-slate-950">{{ __('auth.reset_password_title') }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('auth.reset_password_subtitle') }}</p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-700 ring-1 ring-orange-200/80">
            <i class="fas fa-key text-[11px]"></i>
            New credentials
        </span>
    </div>

    @if ($errors->any())
        <div class="mt-6 rounded-[24px] border border-rose-200 bg-rose-50 px-4 py-4">
            <ul class="space-y-1 text-sm text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update', ['locale' => app()->getLocale()]) }}" class="mt-6 space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.email') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-envelope text-sm"></i>
                </span>
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    autocomplete="email"
                    value="{{ $email ?? old('email') }}"
                    placeholder="{{ __('auth.email_placeholder') }}"
                    class="auth-input w-full rounded-2xl py-3.5 pl-11 pr-4 text-sm text-slate-700"
                >
            </div>
        </div>

        <div>
            <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.new_password') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-lock text-sm"></i>
                </span>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('auth.password_placeholder') }}"
                    class="auth-input w-full rounded-2xl py-3.5 pl-11 pr-12 text-sm text-slate-700"
                >
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-4 text-slate-400 transition hover:text-slate-700">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>

        <div>
            <label for="password-confirm" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.confirm_new_password') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-lock text-sm"></i>
                </span>
                <input
                    id="password-confirm"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('auth.password_placeholder') }}"
                    class="auth-input w-full rounded-2xl py-3.5 pl-11 pr-12 text-sm text-slate-700"
                >
                <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-0 px-4 text-slate-400 transition hover:text-slate-700">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="auth-submit inline-flex w-full items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-semibold text-white">
            <i class="fas fa-key text-xs"></i>
            {{ __('auth.reset_password') }}
        </button>
    </form>

    <div class="mt-6 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
        <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-orange-700 transition hover:text-orange-800">
            <i class="fas fa-arrow-left text-[11px]"></i>
            {{ __('auth.back_to_login') }}
        </a>
    </div>
@endsection

@push('auth_premium_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleVisibility = (buttonId, inputId) => {
                const button = document.getElementById(buttonId);
                const input = document.getElementById(inputId);

                button?.addEventListener('click', function () {
                    if (!input) {
                        return;
                    }

                    const icon = button.querySelector('i');
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    icon?.classList.toggle('fa-eye', !isPassword);
                    icon?.classList.toggle('fa-eye-slash', isPassword);
                });
            };

            toggleVisibility('togglePassword', 'password');
            toggleVisibility('togglePasswordConfirmation', 'password-confirm');
        });
    </script>
@endpush
