@extends('layouts.admin-premium')

@section('title', __('admin_pages.create_user_title'))
@section('admin_nav_active', 'users-create')
@section('dashboard_page_title', __('admin_pages.create_user_heading'))
@section('dashboard_page_subtitle', __('admin_pages.create_user_subtitle'))
@section('dashboard_section_label', __('admin_pages.accounts_management'))

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-users text-xs"></i>
        {{ __('admin_pages.back_to_list') }}
    </a>
    <a href="{{ localized_route('admin.settings') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-sliders text-xs"></i>
        {{ __('admin_pages.settings') }}
    </a>
@endsection

@push('premium_dashboard_head')
    @vite('resources/js/admin-user-create.js')
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .admin-section { border: 1px solid rgba(226,232,240,.8); background: rgba(248,250,252,.8); }
        .admin-phone .iti { width: 100%; }
        .admin-phone .iti__selected-country { padding-left: 1rem; }
        .admin-phone .iti__tel-input { padding-left: 6.25rem !important; }
        .admin-phone .iti__dropdown-content { border: 1px solid rgba(148,163,184,.25); border-radius: 18px; box-shadow: 0 20px 50px rgba(15,23,42,.16); overflow: hidden; }
        .admin-phone .iti__search-input { margin: .75rem; width: calc(100% - 1.5rem); border: 1px solid rgba(148,163,184,.35); border-radius: 12px; padding: .7rem .85rem; }
        .admin-phone .iti__country-list { scrollbar-width: thin; }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Parc total</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $totalUsers }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Clients actifs</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $activeUsers }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Pending</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $pendingUsersCount }}</p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Alertes admin</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $unreadNotificationsCount }}</p></div>
        </div>
    </section>

    @if(session('status'))
        <div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4">
            <p class="text-sm font-semibold text-rose-800">Erreurs de validation</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.6fr)_380px]">
        <section class="admin-surface rounded-[30px] p-5 sm:p-6">
            <div class="border-b border-slate-200/70 pb-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Onboarding</p>
                <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">{{ __('admin_pages.new_user_record') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">{{ __('admin_pages.create_form_intro') }}</p>
            </div>

            <form method="POST" action="{{ localized_route('admin.users.store') }}" class="mt-6 space-y-6">
                @csrf

                <section class="admin-section rounded-[24px] p-5">
                    <div class="flex items-start gap-3">
                        <span class="grid size-10 shrink-0 place-items-center rounded-2xl bg-blue-100 text-blue-700"><i class="fas fa-user"></i></span>
                        <div><h3 class="text-lg font-semibold text-slate-950">Informations essentielles</h3><p class="mt-1 text-sm text-slate-500">Les données indispensables pour ouvrir et sécuriser le compte.</p></div>
                    </div>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div><label for="first_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.first_name') }} *</label><input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Jean" required></div>
                        <div><label for="last_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Nom *</label><input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Dupont" required></div>
                        <div><label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Email *</label><input type="email" name="email" id="email" value="{{ old('email') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="jean.dupont@email.com" required></div>
                        <div><label for="role" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.role') }} *</label><select name="role" id="role" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required><option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>{{ __('admin_pages.client') }}</option><option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>{{ __('admin_pages.administrator') }}</option></select></div>
                        <div class="admin-phone"><label for="phone" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.phone') }}</label><input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" autocomplete="tel" inputmode="tel" aria-describedby="phone-help" data-invalid-message="Saisissez un numéro international valide."><p id="phone-help" class="mt-2 text-sm text-slate-500">Choisissez l’indicatif : le numéro sera enregistré au format international.</p></div>
                        <div><label for="pays" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Pays *</label><select name="pays" id="pays" data-selected="{{ old('pays') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required><option value="">Sélectionner un pays</option>@foreach($countries as $country)<option value="{{ $country['name'] }}" {{ old('pays') == $country['name'] ? 'selected' : '' }}>{{ $country['name'] }}</option>@endforeach</select><p class="mt-2 text-sm text-slate-500">Tous les pays sont disponibles dans la liste.</p></div>
                        <div class="md:col-span-2 md:max-w-[calc(50%-0.5rem)]"><label for="date_naissance" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.birth_date') }} <span class="normal-case tracking-normal text-slate-400">(facultatif)</span></label><input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" max="{{ now()->subDay()->format('Y-m-d') }}" autocomplete="bday" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div>
                    </div>
                </section>

                <section class="admin-section rounded-[24px] p-5">
                    <div class="flex items-start gap-3">
                        <span class="grid size-10 shrink-0 place-items-center rounded-2xl bg-emerald-100 text-emerald-700"><i class="fas fa-shield-halved"></i></span>
                        <div><h3 class="text-lg font-semibold text-slate-950">{{ __('admin_pages.security_auth') }}</h3><p class="mt-1 text-sm text-slate-500">Définissez le premier accès sécurisé du client.</p></div>
                    </div>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div><label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">{{ __('admin_pages.password_required') }} *</label><div class="relative"><input type="password" name="password" id="password" class="admin-field w-full rounded-2xl py-3 pl-4 pr-12 text-sm text-slate-700" required><button type="button" data-password-toggle="password" aria-label="Afficher le mot de passe" aria-pressed="false" class="absolute inset-y-0 right-0 grid w-12 place-items-center rounded-r-2xl text-slate-400 transition hover:text-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-600"><i class="fas fa-eye" aria-hidden="true"></i></button></div><div class="mt-3 h-2 rounded-full bg-slate-200"><div id="password-strength-bar" class="h-2 w-0 rounded-full bg-rose-500 transition-all"></div></div></div>
                        <div><label for="password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Confirmation *</label><div class="relative"><input type="password" name="password_confirmation" id="password_confirmation" class="admin-field w-full rounded-2xl py-3 pl-4 pr-12 text-sm text-slate-700" required><button type="button" data-password-toggle="password_confirmation" aria-label="Afficher la confirmation du mot de passe" aria-pressed="false" class="absolute inset-y-0 right-0 grid w-12 place-items-center rounded-r-2xl text-slate-400 transition hover:text-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-600"><i class="fas fa-eye" aria-hidden="true"></i></button></div></div>
                    </div>
                </section>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="fas fa-arrow-left text-xs"></i> Annuler</a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-user-plus text-xs"></i> {{ __('admin_pages.create_user_button') }}</button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Recents</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Derniers comptes</h3>
                <div class="mt-5 space-y-3">
                    @forelse($recentUsers as $recentUser)
                        <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                            <p class="text-sm font-semibold text-slate-900">{{ $recentUser->first_name }} {{ $recentUser->last_name }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $recentUser->email }}</p>
                            <p class="mt-2 text-xs uppercase tracking-[0.16em] text-slate-400">{{ $recentUser->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @empty
                        <div class="rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center">
                            <p class="text-sm font-semibold text-slate-900">{{ __('admin_pages.no_recent_account') }}</p>
                            <p class="mt-2 text-sm text-slate-500">{{ __('admin_pages.recent_accounts_empty_help') }}</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </aside>
    </div>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const password = document.getElementById('password');
            const strengthBar = document.getElementById('password-strength-bar');
            document.querySelectorAll('[data-password-toggle]').forEach(function (toggle) {
                const input = document.getElementById(toggle.dataset.passwordToggle);
                const icon = toggle.querySelector('i');

                toggle.addEventListener('click', function () {
                    const shouldShow = input.type === 'password';
                    input.type = shouldShow ? 'text' : 'password';
                    toggle.setAttribute('aria-pressed', String(shouldShow));
                    toggle.setAttribute('aria-label', shouldShow ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                    icon.classList.toggle('fa-eye', !shouldShow);
                    icon.classList.toggle('fa-eye-slash', shouldShow);
                });
            });

            password?.addEventListener('input', function () {
                let score = 0;
                if (this.value.length >= 8) score += 25;
                if (/[A-Z]/.test(this.value)) score += 25;
                if (/[0-9]/.test(this.value)) score += 25;
                if (/[^A-Za-z0-9]/.test(this.value)) score += 25;

                strengthBar.style.width = `${score}%`;
                strengthBar.className = `h-2 rounded-full transition-all ${score < 50 ? 'bg-rose-500' : (score < 75 ? 'bg-amber-500' : 'bg-emerald-500')}`;
            });
        });
    </script>
@endpush
