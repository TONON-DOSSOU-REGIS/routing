@extends('layouts.admin-premium')

@php
    $creditCard = $user->creditCard;
    $photoUrl = $user->profile_photo_url;
    $initials = strtoupper(substr((string) $user->first_name, 0, 1) . substr((string) $user->last_name, 0, 1));
    $status = old('status', $user->status);
    $role = old('role', $user->role);
    $statusMeta = $status === 'suspended'
        ? ['label' => 'Suspendu', 'icon' => 'fa-ban', 'class' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80']
        : ['label' => 'Actif', 'icon' => 'fa-circle-check', 'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80'];
    $roleMeta = $role === 'admin'
        ? ['label' => 'Administrateur', 'icon' => 'fa-user-shield', 'class' => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200/80']
        : ['label' => 'Client', 'icon' => 'fa-user', 'class' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200/80'];
    $balanceFormatted = \App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR');
    $balanceInput = old('balance', number_format((float) $user->balance, 2, ',', ''));
    $idType = match ((string) old('type_piece', $user->id_type)) {
        'passport', 'Passeport' => 'Passport',
        default => old('type_piece', $user->id_type),
    };
@endphp

@section('title', 'Modifier un utilisateur - Zuider Bank S.A Admin')
@section('admin_nav_active', 'users')
@section('dashboard_page_title', 'Édition utilisateur')
@section('dashboard_page_subtitle', 'Une fiche client premium, plus claire et plus professionnelle, alignee sur le reste de l admin.')
@section('dashboard_section_label', 'Gestion des utilisateurs')

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.users') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-users text-xs"></i> Retour à la liste</a>
    <a href="{{ localized_route('admin.users.create') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50"><i class="fas fa-user-plus text-xs"></i> Nouvel utilisateur</a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field{background:rgba(248,250,252,.92);border:1px solid rgba(148,163,184,.24);box-shadow:inset 0 1px 0 rgba(255,255,255,.72);transition:border-color .18s,box-shadow .18s,background-color .18s}.admin-field:focus{background:rgba(255,255,255,.98);border-color:rgba(21,94,239,.36);box-shadow:0 0 0 4px rgba(21,94,239,.08);outline:none}.admin-surface{border:1px solid rgba(148,163,184,.18);background:linear-gradient(180deg,rgba(255,255,255,.95),rgba(248,250,252,.88));box-shadow:0 18px 36px rgba(15,23,42,.06)}.admin-section{border:1px solid rgba(226,232,240,.85);background:rgba(248,250,252,.78)}.admin-chip{display:inline-flex;align-items:center;gap:.5rem;border-radius:9999px;padding:.6rem .95rem;font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
        .admin-side-card{position:relative;min-width:0;border:1px solid rgba(148,163,184,.18);background:linear-gradient(180deg,rgba(255,255,255,.98),rgba(248,250,252,.92));box-shadow:0 18px 36px rgba(15,23,42,.06)}
        .admin-side-card::before{content:"";position:absolute;inset:0;border-radius:inherit;background:radial-gradient(circle at top right,rgba(21,94,239,.08),transparent 40%);pointer-events:none}
        .admin-side-card>*{position:relative;z-index:1}
        .admin-side-icon{display:inline-flex;height:3rem;width:3rem;flex-shrink:0;align-items:center;justify-content:center;border-radius:1rem;box-shadow:inset 0 1px 0 rgba(255,255,255,.78)}
        .admin-side-row{display:flex;flex-direction:column;gap:.35rem;padding:.75rem 0}
        .admin-side-row:first-child{padding-top:0}
        .admin-side-row:last-child{padding-bottom:0}
        .admin-side-value{word-break:break-word}
        @media (min-width:640px){.admin-side-row{flex-direction:row;align-items:center;justify-content:space-between;gap:.75rem}}
        @media (max-width:639px){.admin-side-card{padding:1rem}.admin-side-title{font-size:1.35rem;line-height:1.2}.admin-mobile-center{align-items:center;text-align:center}.admin-mobile-full{width:100%}}
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 flex flex-col gap-6 2xl:flex-row 2xl:items-end 2xl:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-[88px] w-[88px] items-center justify-center overflow-hidden rounded-[28px] bg-white/15 text-2xl font-semibold text-white">@if($photoUrl)<img src="{{ $photoUrl }}" alt="Photo de {{ $user->name }}" class="h-full w-full object-cover">@else{{ $initials }}@endif</div>
                <div class="max-w-3xl">
                    <p class="text-sm uppercase tracking-[0.22em] text-white/65">Profil client</p>
                    <h2 class="mt-3 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">{{ $user->name }}</h2>
                    <p class="mt-3 text-sm leading-6 text-white/80 sm:text-base">Mettez à jour les informations, les accès, le solde, les coordonnées bancaires et la carte virtuelle dans un environnement plus premium.</p>
                    <div class="mt-4 flex flex-wrap gap-2"><span class="admin-chip bg-white/14 text-white">ID #{{ $user->id }}</span><span class="admin-chip {{ $statusMeta['class'] }}"><i class="fas {{ $statusMeta['icon'] }}"></i>{{ $statusMeta['label'] }}</span><span class="admin-chip {{ $roleMeta['class'] }}"><i class="fas {{ $roleMeta['icon'] }}"></i>{{ $roleMeta['label'] }}</span></div>
                </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 2xl:min-w-[560px]">
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Solde actuel</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $balanceFormatted }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Opérations</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $user->transactions_count ?? 0 }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">En attente</p><p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $user->pending_transactions_count ?? 0 }}</p></div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Membre depuis</p><p class="mt-2 text-lg font-semibold">{{ optional($user->created_at)->format('d/m/Y') ?: 'N/A' }}</p></div>
            </div>
        </div>
    </section>

    @if(session('status'))<div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4"><p class="text-sm font-semibold text-rose-800">Erreurs de validation</p><ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <form method="POST" action="{{ localized_route('admin.users.update', $user) }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.55fr)_380px]">
            <section class="admin-surface rounded-[30px] p-5 sm:p-6">
                <div class="border-b border-slate-200/70 pb-5"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Édition</p><h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Fiche utilisateur premium</h3><p class="mt-2 text-sm leading-6 text-slate-500">Conservez une fiche complète et exploitable pour l'équipe admin.</p></div>
                <div class="mt-6 space-y-6">
                    <section class="admin-section rounded-[24px] p-5"><h4 class="text-lg font-semibold text-slate-950">Informations personnelles</h4><div class="mt-5 grid gap-4 md:grid-cols-2"><div><label for="first_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Prénom *</label><input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required></div><div><label for="last_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Nom *</label><input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required></div><div><label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Email *</label><input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required></div><div><label for="phone" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Téléphone</label><input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="+33612345678" autocomplete="tel" inputmode="tel"><p class="mt-2 text-sm text-slate-500">Format international uniquement : + indicatif pays + numero.</p></div><div><label for="date_naissance" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Date de naissance</label><input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', optional($user->date_of_birth)->format('Y-m-d')) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="role" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Rôle *</label><select name="role" id="role" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required><option value="user" @selected($role === 'user')>Client</option><option value="admin" @selected($role === 'admin')>Administrateur</option></select></div><div class="md:col-span-2"><label for="profile_photo" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Photo du client</label><input type="file" name="profile_photo" id="profile_photo" accept="image/png,image/jpeg,image/webp" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><p class="mt-2 text-sm text-slate-500">Formats acceptes : JPG, PNG, WebP (2 Mo max).</p></div></div></section>
                    <section class="admin-section rounded-[24px] p-5"><h4 class="text-lg font-semibold text-slate-950">Adresse et verification</h4><div class="mt-5 grid gap-4 md:grid-cols-2"><div class="md:col-span-2"><label for="adresse" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Adresse</label><input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->address) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="ville" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Ville</label><input type="text" name="ville" id="ville" value="{{ old('ville', $user->city) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="pays" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Pays</label><select name="pays" id="pays" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">Selectionner un pays</option>@foreach($countries as $country)<option value="{{ $country['name'] }}" @selected(old('pays', $user->country) === $country['name'])>({{ $country['code'] }}) {{ $country['name'] }}</option>@endforeach</select></div><div><label for="type_piece" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Type de pièce</label><select name="type_piece" id="type_piece" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="">Selectionner</option><option value="CNI" @selected($idType === 'CNI')>Carte nationale d identite</option><option value="Passport" @selected($idType === 'Passport')>Passeport</option><option value="Permis" @selected($idType === 'Permis')>Permis de conduire</option></select></div><div><label for="numero_piece" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Numero de piece</label><input type="text" name="numero_piece" id="numero_piece" value="{{ old('numero_piece', $user->id_number) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div></div></section>
                    <section class="admin-section rounded-[24px] p-5"><h4 class="text-lg font-semibold text-slate-950">Banque et carte virtuelle</h4><div class="mt-5 grid gap-4 md:grid-cols-2"><div><label for="iban" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">IBAN</label><input type="text" name="iban" id="iban" value="{{ old('iban', $user->iban) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="bic" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">BIC</label><input type="text" name="bic" id="bic" value="{{ old('bic', $user->bic) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div class="md:col-span-2"><label for="activation_code" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Code d activation</label><input type="text" name="activation_code" id="activation_code" value="{{ old('activation_code', $user->activation_code) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="card_holder_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Titulaire</label><input type="text" name="card_holder_name" id="card_holder_name" value="{{ old('card_holder_name', optional($creditCard)->card_holder_name) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="card_number" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Numero de carte</label><input type="text" name="card_number" id="card_number" value="{{ old('card_number', optional($creditCard)->card_number) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="card_type" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Type</label><input type="text" name="card_type" id="card_type" value="{{ old('card_type', optional($creditCard)->card_type) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div><label for="expiry_date" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Expiration</label><input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', optional(optional($creditCard)->expiry_date)->format('Y-m-d')) }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"></div><div class="md:col-span-2"><label class="flex items-center justify-between rounded-[22px] bg-white px-4 py-4 ring-1 ring-slate-200/80"><span><span class="block text-sm font-semibold text-slate-900">Carte visible pour le client</span><span class="mt-1 block text-sm text-slate-500">Autoriser l'affichage dans l'espace client.</span></span><span class="flex items-center gap-3"><input type="checkbox" name="card_visible_to_user" id="card_visible_to_user" value="1" class="peer sr-only" @checked((bool) old('card_visible_to_user', (bool) optional($creditCard)->is_visible_to_user))><span class="relative inline-flex h-6 w-11 items-center rounded-full bg-slate-300 transition peer-checked:bg-blue-700 after:h-4 after:w-4 after:translate-x-1 after:rounded-full after:bg-white after:shadow after:transition peer-checked:after:translate-x-6"></span></span></label></div></div></section>
                </div>
            </section>

            <aside class="space-y-4 sm:space-y-6">
                <section class="admin-side-card w-full rounded-[28px] p-4 sm:rounded-[30px] sm:p-5">
                    <div class="flex items-start gap-3">
                        <span class="admin-side-icon bg-sky-50 text-sky-600"><i class="fas fa-address-card"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Vue rapide</p>
                            <h3 class="admin-side-title mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Identite client</h3>
                        </div>
                    </div>
                    <div class="mt-5 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                        <p class="admin-side-value mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                        <div class="mt-4 text-sm text-slate-600">
                            <div class="admin-side-row"><span>Téléphone</span><span class="admin-side-value font-semibold text-slate-900">{{ $user->phone ?: 'Non renseigné' }}</span></div>
                            <div class="admin-side-row"><span>Ville</span><span class="admin-side-value font-semibold text-slate-900">{{ $user->city ?: 'N/A' }}</span></div>
                            <div class="admin-side-row"><span>Pays</span><span class="admin-side-value font-semibold text-slate-900">{{ $user->country ?: 'N/A' }}</span></div>
                        </div>
                    </div>
                </section>
                <section class="admin-side-card w-full rounded-[28px] p-4 sm:rounded-[30px] sm:p-5">
                    <div class="flex items-start gap-3">
                        <span class="admin-side-icon bg-emerald-50 text-emerald-600"><i class="fas fa-wallet"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Compte</p>
                            <h3 class="admin-side-title mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Accès et solde</h3>
                        </div>
                    </div>
                    <div class="mt-5 space-y-4">
                        <div>
                            <label for="status" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Statut</label>
                            <select name="status" id="status" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700"><option value="active" @selected($status === 'active')>Actif</option><option value="suspended" @selected($status === 'suspended')>Suspendu</option></select>
                        </div>
                        <div class="rounded-[24px] bg-emerald-50 px-4 py-4 ring-1 ring-emerald-200/80">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700">Solde actuel</p>
                            <p id="liveBalanceDisplay" class="admin-side-value premium-brand-title mt-3 text-3xl font-semibold text-emerald-700">{{ $balanceFormatted }}</p>
                        </div>
                        <div>
                            <label for="balance" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Nouveau solde *</label>
                            <input type="text" name="balance" id="balance" value="{{ $balanceInput }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>
                            <p class="mt-2 text-sm text-slate-500">La valeur sera normalisee avant enregistrement.</p>
                        </div>
                    </div>
                </section>
                <section class="admin-side-card w-full rounded-[28px] p-4 sm:rounded-[30px] sm:p-5">
                    <div class="flex items-start gap-3">
                        <span class="admin-side-icon bg-indigo-50 text-indigo-600"><i class="fas fa-bolt"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Actions</p>
                            <h3 class="admin-side-title mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Validation</h3>
                        </div>
                    </div>
                    <div class="mt-5 space-y-3">
                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800"><i class="fas fa-save text-xs"></i> Enregistrer les modifications</button>
                        <a href="{{ localized_route('admin.users') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"><i class="fas fa-arrow-left text-xs"></i> Annuler</a>
                    </div>
                </section>
            </aside>
        </div>
    </form>

    <section class="admin-surface rounded-[30px] p-5 sm:p-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl"><p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Sécurité</p><h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Reinitialisation du mot de passe</h3><p class="mt-2 text-sm leading-6 text-slate-500">Générez un nouveau mot de passe aléatoire et envoyez-le directement par e-mail. Cette action est irréversible.</p></div>
            <form method="POST" action="{{ localized_route('admin.users.reset-password', $user) }}" class="w-full lg:w-auto">@csrf<button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-rose-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 transition hover:bg-rose-700 lg:w-auto" onclick="return confirm('Confirmer la réinitialisation du mot de passe de cet utilisateur ? Un e-mail sera envoyé avec le nouveau mot de passe.')"><i class="fas fa-key text-xs"></i> Réinitialiser le mot de passe</button></form>
        </div>
    </section>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const balanceInput = document.getElementById('balance');
            const balanceDisplay = document.getElementById('liveBalanceDisplay');
            const currencyCode = @json($user->default_currency ?? 'EUR');

            function updateBalancePreview() {
                if (!balanceInput || !balanceDisplay) return;
                const raw = balanceInput.value.replace(/\s+/g, '').replace(',', '.');
                const numeric = Number.parseFloat(raw);
                if (Number.isNaN(numeric)) return;
                balanceDisplay.textContent = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: currencyCode, minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(numeric);
            }

            balanceInput?.addEventListener('input', updateBalancePreview);
            balanceInput?.addEventListener('blur', function () {
                const raw = this.value.replace(/\s+/g, '').replace(',', '.');
                const numeric = Number.parseFloat(raw);
                if (!Number.isNaN(numeric)) {
                    this.value = numeric.toFixed(2).replace('.', ',');
                    updateBalancePreview();
                }
            });
        });
    </script>
@endpush
