@extends('layouts.admin-premium')

@section('title', 'Creer un utilisateur - Valtrix Bank Admin')
@section('admin_nav_active', 'users-create')
@section('dashboard_page_title', 'Creation d utilisateur')
@section('dashboard_page_subtitle', 'Onboardez un nouveau client ou administrateur avec une fiche complete, claire et professionnelle.')
@section('dashboard_section_label', 'User onboarding')

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-users text-xs"></i>
        Retour liste
    </a>
    <a href="{{ localized_route('admin.settings') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-sliders text-xs"></i>
        Parametres
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .admin-section { border: 1px solid rgba(226,232,240,.8); background: rgba(248,250,252,.8); }
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
                <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Nouvelle fiche utilisateur</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Renseignez les informations personnelles, de securite, d adresse et bancaires du compte.</p>
            </div>

            <form method="POST" action="{{ localized_route('admin.users.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                @csrf

                <section class="admin-section rounded-[24px] p-5">
                    <h3 class="text-lg font-semibold text-slate-950">Informations personnelles</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div><label for="first_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Prenom *</label><input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Jean" required></div>
                        <div><label for="last_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Nom *</label><input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Dupont" required></div>
                        <div><label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Email *</label><input type="email" name="email" id="email" value="{{ old('email') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="jean.dupont@email.com" required></div>
                        <div><label for="phone" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Telephone</label><input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="+33 6 12 34 56 78"></div>
                        <div><label for="date_naissance" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Date de naissance</label><input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div>
                        <div><label for="role" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Role *</label><select name="role" id="role" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required><option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Client</option><option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option></select></div>
                        <div class="md:col-span-2"><label for="profile_photo" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Photo du client</label><input type="file" name="profile_photo" id="profile_photo" accept="image/png,image/jpeg,image/webp" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><p class="mt-2 text-sm text-slate-500">Formats acceptes : JPG, PNG, WebP (2 Mo max).</p></div>
                    </div>
                </section>

                <section class="admin-section rounded-[24px] p-5">
                    <h3 class="text-lg font-semibold text-slate-950">Securite et authentification</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div><label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Mot de passe *</label><input type="password" name="password" id="password" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required><div class="mt-3 h-2 rounded-full bg-slate-200"><div id="password-strength-bar" class="h-2 w-0 rounded-full bg-rose-500 transition-all"></div></div></div>
                        <div><label for="password_confirmation" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Confirmation *</label><input type="password" name="password_confirmation" id="password_confirmation" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required></div>
                    </div>
                </section>

                <section class="admin-section rounded-[24px] p-5">
                    <h3 class="text-lg font-semibold text-slate-950">Adresse</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div class="md:col-span-2"><label for="adresse" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Adresse</label><input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="123 Avenue de l Europe"></div>
                        <div><label for="ville" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Ville</label><input type="text" name="ville" id="ville" value="{{ old('ville') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Paris"></div>
                        <div><label for="pays" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Pays</label><select name="pays" id="pays" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">Selectionner un pays</option>@foreach($countries as $country)<option value="{{ $country['name'] }}" {{ old('pays') == $country['name'] ? 'selected' : '' }}>({{ $country['code'] }}) {{ $country['name'] }}</option>@endforeach</select></div>
                    </div>
                </section>

                <section class="admin-section rounded-[24px] p-5">
                    <h3 class="text-lg font-semibold text-slate-950">Piece d identite</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div><label for="type_piece" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Type</label><select name="type_piece" id="type_piece" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">Selectionner</option><option value="CNI" {{ old('type_piece') == 'CNI' ? 'selected' : '' }}>Carte nationale d identite</option><option value="Passeport" {{ old('type_piece') == 'Passeport' ? 'selected' : '' }}>Passeport</option><option value="Permis" {{ old('type_piece') == 'Permis' ? 'selected' : '' }}>Permis de conduire</option></select></div>
                        <div><label for="numero_piece" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Numero</label><input type="text" name="numero_piece" id="numero_piece" value="{{ old('numero_piece') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="12AB34567"></div>
                    </div>
                </section>

                <section class="admin-section rounded-[24px] p-5">
                    <h3 class="text-lg font-semibold text-slate-950">Informations bancaires</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div><label for="iban" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">IBAN</label><input type="text" name="iban" id="iban" value="{{ old('iban') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="FR76 1234 5678 9012 3456 7890 123"></div>
                        <div><label for="bic" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">BIC</label><input type="text" name="bic" id="bic" value="{{ old('bic') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="BNPAFRPP"></div>
                    </div>
                </section>

                <section class="rounded-[24px] bg-blue-50 px-5 py-5 ring-1 ring-blue-200/80">
                    <h3 class="text-lg font-semibold text-blue-900">Code d activation</h3>
                    <p class="mt-2 text-sm leading-6 text-blue-700">Optionnel. Il pourra etre demande pour certains scenarios de virement ou de verification.</p>
                    <div class="mt-4 max-w-xl"><input type="text" name="activation_code" id="activation_code" value="{{ old('activation_code') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Entrez un code d activation securise"></div>
                </section>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="fas fa-arrow-left text-xs"></i> Annuler</a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-user-plus text-xs"></i> Creer l utilisateur</button>
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
                            <p class="text-sm font-semibold text-slate-900">Aucun compte recent</p>
                            <p class="mt-2 text-sm text-slate-500">Les derniers onboardings apparaitront ici.</p>
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
            const phone = document.getElementById('phone');

            password?.addEventListener('input', function () {
                let score = 0;
                if (this.value.length >= 8) score += 25;
                if (/[A-Z]/.test(this.value)) score += 25;
                if (/[0-9]/.test(this.value)) score += 25;
                if (/[^A-Za-z0-9]/.test(this.value)) score += 25;

                strengthBar.style.width = `${score}%`;
                strengthBar.className = `h-2 rounded-full transition-all ${score < 50 ? 'bg-rose-500' : (score < 75 ? 'bg-amber-500' : 'bg-emerald-500')}`;
            });

            phone?.addEventListener('input', function (event) {
                let value = event.target.value.replace(/\D/g, '');
                if (value.startsWith('33')) value = value.replace(/^33/, '0');
                if (value.length > 0) value = value.match(/.{1,2}/g).join(' ');
                event.target.value = value;
            });
        });
    </script>
@endpush
