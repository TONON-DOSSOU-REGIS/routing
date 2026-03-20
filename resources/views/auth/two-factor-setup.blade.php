<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.2fa_setup_title') }}</title>
    @include('partials.favicon')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50">
    <div class="max-w-3xl mx-auto p-6">
        <div class="bg-white shadow rounded-2xl p-6">
            <h1 class="text-2xl font-bold text-slate-900">{{ __('auth.2fa_setup_heading') }}</h1>
            <p class="text-slate-600 mt-2">{{ __('auth.2fa_setup_description') }}</p>

            @if (session('status'))
                <div class="mt-4 rounded-lg bg-emerald-50 text-emerald-700 px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-lg bg-red-50 text-red-700 px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-xl border border-slate-200 p-4">
                    <h2 class="font-semibold text-slate-900">{{ __('auth.2fa_secret_title') }}</h2>
                    <p class="text-sm text-slate-600 mt-1">{{ __('auth.2fa_secret_hint') }}</p>
                    <div class="mt-3 font-mono text-lg bg-slate-100 p-3 rounded-lg break-all">{{ $user->two_factor_secret }}</div>

                    <div class="mt-4">
                        <label class="text-sm text-slate-700">{{ __('auth.2fa_otpauth_label') }}</label>
                        <input type="text" readonly class="w-full mt-1 p-2 text-sm rounded-lg border border-slate-200 bg-slate-50" value="{{ $otpauth }}">
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 p-4">
                    <h2 class="font-semibold text-slate-900">{{ __('auth.2fa_enable_title') }}</h2>
                    <p class="text-sm text-slate-600 mt-1">{{ __('auth.2fa_enable_hint') }}</p>

                    <form method="POST" action="{{ localized_route('twofactor.enable', ['locale' => app()->getLocale()]) }}" class="mt-4 space-y-3">
                        @csrf
                        <input type="text" name="code" inputmode="numeric" maxlength="6" class="w-full p-3 rounded-lg border border-slate-200" placeholder="{{ __('auth.2fa_code_placeholder') }}">
                        <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 font-semibold hover:bg-blue-700">
                            {{ __('auth.2fa_enable_button') }}
                        </button>
                    </form>
                </div>
            </div>

            @if (!empty($backupCodes))
                <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <h2 class="font-semibold text-amber-900">{{ __('auth.2fa_backup_title') }}</h2>
                    <p class="text-sm text-amber-800 mt-1">{{ __('auth.2fa_backup_hint') }}</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-4 font-mono text-sm">
                        @foreach ($backupCodes as $code)
                            <div class="bg-white border border-amber-200 rounded-md px-2 py-1 text-center">{{ $code }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-6 rounded-xl border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-900">{{ __('auth.2fa_disable_title') }}</h2>
                <p class="text-sm text-slate-600 mt-1">{{ __('auth.2fa_disable_hint') }}</p>
                <form method="POST" action="{{ localized_route('twofactor.disable', ['locale' => app()->getLocale()]) }}" class="mt-4 space-y-3">
                    @csrf
                    <input type="password" name="password" class="w-full p-3 rounded-lg border border-slate-200" placeholder="{{ __('auth.2fa_password_placeholder') }}">
                    <button type="submit" class="w-full bg-slate-800 text-white rounded-lg py-2.5 font-semibold hover:bg-slate-900">
                        {{ __('auth.2fa_disable_button') }}
                    </button>
                </form>
            </div>

            <div class="mt-6">
                <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:underline">
                    {{ __('auth.2fa_back_dashboard') }}
                </a>
            </div>
        </div>
    </div>
</body>
</html>
