@extends('layouts.auth-premium')

@php
    $countries = [
        'France' => __('auth.country_france'),
        'Allemagne' => __('auth.country_germany'),
        'Autriche' => __('auth.country_austria'),
        'Belgique' => __('auth.country_belgium'),
        'Bulgarie' => __('auth.country_bulgaria'),
        'Chypre' => __('auth.country_cyprus'),
        'Croatie' => __('auth.country_croatia'),
        'Danemark' => __('auth.country_denmark'),
        'Espagne' => __('auth.country_spain'),
        'Estonie' => __('auth.country_estonia'),
        'Finlande' => __('auth.country_finland'),
        'Grece' => __('auth.country_greece'),
        'Hongrie' => __('auth.country_hungary'),
        'Irlande' => __('auth.country_ireland'),
        'Italie' => __('auth.country_italy'),
        'Lettonie' => __('auth.country_latvia'),
        'Lituanie' => __('auth.country_lithuania'),
        'Luxembourg' => __('auth.country_luxembourg'),
        'Malte' => __('auth.country_malta'),
        'Pays-Bas' => __('auth.country_netherlands'),
        'Pologne' => __('auth.country_poland'),
        'Portugal' => __('auth.country_portugal'),
        'Republique Tcheque' => __('auth.country_czech'),
        'Roumanie' => __('auth.country_romania'),
        'Slovaquie' => __('auth.country_slovakia'),
        'Slovenie' => __('auth.country_slovenia'),
        'Suede' => __('auth.country_sweden'),
        'Suisse' => __('auth.country_switzerland'),
        'Norvege' => __('auth.country_norway'),
        'Islande' => __('auth.country_iceland'),
        'Royaume-Uni' => __('auth.country_uk'),
        'Albanie' => __('auth.country_albania'),
        'Bosnie-Herzegovine' => __('auth.country_bosnia'),
        'Serbie' => __('auth.country_serbia'),
        'Montenegro' => __('auth.country_montenegro'),
        'Macedoine du Nord' => __('auth.country_macedonia'),
        'Kosovo' => __('auth.country_kosovo'),
        'Andorre' => __('auth.country_andorra'),
        'Liechtenstein' => __('auth.country_liechtenstein'),
        'Monaco' => __('auth.country_monaco'),
        'Saint-Marin' => __('auth.country_san_marino'),
        'Vatican' => __('auth.country_vatican'),
        'Canada' => __('auth.country_canada'),
        'Autre' => __('auth.country_other'),
    ];
@endphp

@section('title', __('auth.register_page_title'))
@section('auth_nav_subtitle', 'Premium onboarding')

@section('auth_nav_actions')
    <a href="{{ localized_route('home') }}" class="auth-link-btn inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-house text-xs"></i>
        {{ __('auth.nav_home') }}
    </a>
    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition hover:bg-orange-600">
        <i class="fas fa-right-to-bracket text-xs"></i>
        {{ __('auth.nav_login') }}
    </a>
@endsection

@section('auth_hero')
    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/70 ring-1 ring-white/10">
        <span class="h-2.5 w-2.5 rounded-full bg-orange-400"></span>
        Premium onboarding
    </span>

    <h1 class="auth-heading mt-6 text-4xl font-semibold tracking-[-0.05em] text-white sm:text-5xl">
        {{ __('auth.register_hero_title_1') }}
        <span class="text-orange-300">{{ __('auth.register_hero_title_2') }}</span>
        {{ __('auth.register_hero_title_3') }}
        <span class="text-orange-300">{{ __('auth.register_hero_title_4') }}</span>
    </h1>
    <p class="mt-4 max-w-2xl text-base leading-7 text-white/76 sm:text-lg">
        {{ __('auth.register_hero_description_1') }}
        <span class="text-orange-200">{{ __('auth.register_hero_description_2') }}</span>
        {{ __('auth.register_hero_description_3') }}
        <span class="text-orange-200">{{ __('auth.register_hero_description_4') }}</span>.
    </p>

    <div class="mt-8 grid gap-3 sm:grid-cols-3">
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-bolt text-sm"></i></span>
            <span class="text-sm font-semibold">{{ __('auth.register_feature_fast') }} {{ __('auth.register_feature_fast_bold') }}</span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-shield-halved text-sm"></i></span>
            <span class="text-sm font-semibold">{{ __('auth.register_feature_security') }} {{ __('auth.register_feature_security_bold') }}</span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-bell text-sm"></i></span>
            <span class="text-sm font-semibold">{{ __('auth.register_feature_notifications') }} {{ __('auth.register_feature_notifications_bold') }}</span>
        </div>
    </div>

    <div class="mt-10 grid gap-3 sm:grid-cols-3">
        <div class="auth-stat-card">
            <p>Identite</p>
            <div class="mt-3 text-lg font-semibold text-white">Complete</div>
            <p class="mt-2 text-sm leading-6 text-white/74">Ajoutez vos informations personnelles et de verification dans un seul flux premium.</p>
        </div>
        <div class="auth-stat-card">
            <p>Validation</p>
            <div class="mt-3 text-lg font-semibold text-white">Admin review</div>
            <p class="mt-2 text-sm leading-6 text-white/74">Votre dossier sera controle avant activation pour garder un environnement bancaire propre.</p>
        </div>
        <div class="auth-stat-card">
            <p>Activation</p>
            <div class="mt-3 text-lg font-semibold text-white">Secure</div>
            <p class="mt-2 text-sm leading-6 text-white/74">Les notifications et le suivi premium prennent le relais des que votre compte est valide.</p>
        </div>
    </div>
@endsection

@section('auth_panel')
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Onboarding</p>
            <h2 class="auth-heading mt-2 text-3xl font-semibold tracking-[-0.04em] text-slate-950">{{ __('auth.register_title') }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                {{ __('auth.already_account') }}
                <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="font-semibold text-orange-700 transition hover:text-orange-800">
                    {{ __('auth.login_link') }}
                </a>
            </p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-700 ring-1 ring-orange-200/80">
            <i class="fas fa-user-plus text-[11px]"></i>
            New client
        </span>
    </div>

    @if ($errors->any())
        <div class="mt-6 rounded-[24px] border border-rose-200 bg-rose-50 px-4 py-4">
            <p class="text-sm font-semibold text-rose-800">{{ __('auth.register_error_title') }}</p>
            <ul class="mt-2 space-y-1 text-sm text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="mt-6 space-y-6" method="POST" action="{{ localized_route('register', ['locale' => app()->getLocale()]) }}">
        @csrf

        <section class="rounded-[28px] bg-slate-50 px-5 py-5 ring-1 ring-slate-200/70">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Identite</p>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="first_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.first_name') }}</label>
                    <input id="first_name" name="first_name" type="text" required value="{{ old('first_name') }}" placeholder="{{ __('auth.first_name_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div>
                    <label for="last_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.last_name') }}</label>
                    <input id="last_name" name="last_name" type="text" required value="{{ old('last_name') }}" placeholder="{{ __('auth.last_name_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div>
                    <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.email_address') }}</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="{{ __('auth.email_address_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div>
                    <label for="phone" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.phone') }}</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="{{ __('auth.phone_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.address') }}</label>
                    <input id="address" name="address" type="text" value="{{ old('address') }}" placeholder="{{ __('auth.address_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div>
                    <label for="country" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.country') }}</label>
                    <select id="country" name="country" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                        <option value="">{{ __('auth.country_select') }}</option>
                        @foreach($countries as $value => $label)
                            <option value="{{ $value }}" {{ old('country') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="city" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.city') }}</label>
                    <input id="city" name="city" type="text" value="{{ old('city') }}" placeholder="{{ __('auth.city_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div>
                    <label for="date_of_birth" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.date_of_birth') }}</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" required value="{{ old('date_of_birth') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div>
                    <label for="id_type" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.id_type') }}</label>
                    <select id="id_type" name="id_type" required class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                        <option value="">{{ __('auth.id_type_select') }}</option>
                        <option value="CNI" {{ old('id_type') === 'CNI' ? 'selected' : '' }}>{{ __('auth.id_type_cni') }}</option>
                        <option value="Passport" {{ old('id_type') === 'Passport' ? 'selected' : '' }}>{{ __('auth.id_type_passport') }}</option>
                        <option value="Permis" {{ old('id_type') === 'Permis' ? 'selected' : '' }}>{{ __('auth.id_type_license') }}</option>
                    </select>
                </div>
                <div>
                    <label for="id_number" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.id_number') }}</label>
                    <input id="id_number" name="id_number" type="text" required value="{{ old('id_number') }}" placeholder="{{ __('auth.id_number_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
            </div>
        </section>

        <section class="rounded-[28px] bg-slate-50 px-5 py-5 ring-1 ring-slate-200/70">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Coordonnees bancaires</p>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="iban" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.iban') }}</label>
                    <input id="iban" name="iban" type="text" value="{{ old('iban') }}" placeholder="{{ __('auth.iban_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
                <div>
                    <label for="bic" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">BIC</label>
                    <input id="bic" name="bic" type="text" value="{{ old('bic') }}" placeholder="DEUTDEFFXXX" class="auth-input w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                </div>
            </div>
        </section>

        <section class="rounded-[28px] bg-slate-50 px-5 py-5 ring-1 ring-slate-200/70">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Securite</p>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.password_field') }}</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required placeholder="{{ __('auth.password_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 pr-12 text-sm text-slate-700">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-4 text-slate-400 transition hover:text-slate-700">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="mt-3">
                        <div class="mb-2 flex items-center justify-between text-xs font-medium text-slate-500">
                            <span>{{ __('auth.password_strength') }}</span>
                            <span id="password-strength-label">0%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-200">
                            <div id="password-strength-bar" class="h-2 w-0 rounded-full bg-rose-500 transition-all duration-300"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('auth.confirm_password') }}</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="{{ __('auth.password_placeholder') }}" class="auth-input w-full rounded-2xl px-4 py-3 pr-12 text-sm text-slate-700">
                        <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-0 px-4 text-slate-400 transition hover:text-slate-700">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <label for="terms" class="inline-flex items-start gap-3 rounded-[24px] bg-slate-50 px-4 py-4 text-sm text-slate-600 ring-1 ring-slate-200/70">
            <input id="terms" name="terms" type="checkbox" value="1" {{ old('terms') ? 'checked' : '' }} required class="mt-1 h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500">
            <span>
                {{ __('auth.terms_accept') }}
                <a href="{{ localized_route('support.mentions-legales') }}" class="font-semibold text-orange-700 transition hover:text-orange-800">{{ __('auth.terms_link') }}</a>
                {{ __('auth.terms_and') }}
                <a href="{{ localized_route('support.securite') }}" class="font-semibold text-orange-700 transition hover:text-orange-800">{{ __('auth.privacy_link') }}</a>
            </span>
        </label>

        <button type="submit" class="auth-submit inline-flex w-full items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-semibold text-white">
            <i class="fas fa-user-plus text-xs"></i>
            {{ __('auth.register_button') }}
        </button>
    </form>
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
            toggleVisibility('togglePasswordConfirmation', 'password_confirmation');

            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthLabel = document.getElementById('password-strength-label');

            passwordInput?.addEventListener('input', function () {
                const password = passwordInput.value;
                let strength = 0;

                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;

                strengthBar.style.width = `${strength}%`;
                strengthLabel.textContent = `${strength}%`;

                if (strength < 50) {
                    strengthBar.className = 'h-2 rounded-full bg-rose-500 transition-all duration-300';
                } else if (strength < 75) {
                    strengthBar.className = 'h-2 rounded-full bg-amber-500 transition-all duration-300';
                } else {
                    strengthBar.className = 'h-2 rounded-full bg-emerald-500 transition-all duration-300';
                }
            });
        });
    </script>
@endpush
