@extends('layouts.admin-premium')

@php
    $filteredTransactionsVolumeFormatted = \App\Helpers\CurrencyHelper::format($filteredTransactionsVolume ?? 0, 'EUR');
    $activeFiltersCount = collect([
        request('search'),
        request('type'),
        request('status'),
        request('user_id'),
        request('date_from'),
        request('date_to'),
    ])->filter(fn ($value) => filled($value))->count();
@endphp

@section('title', 'Pilotage des transactions - Zuider Bank S.A Admin')
@section('admin_nav_active', 'transactions')
@section('dashboard_page_title', 'Gestion des transactions')
@section('dashboard_page_subtitle', 'Supervisez les virements, dépôts, retraits et remboursements depuis une interface premium alignée sur le centre de contrôle admin.')
@section('dashboard_section_label', 'Pilotage des transactions')

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.export.pdf') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800 sm:w-auto">
        <i class="fas fa-file-pdf text-xs"></i>
        Export PDF
    </a>
    <a href="{{ localized_route('admin.deposit') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 sm:w-auto">
        <i class="fas fa-plus-circle text-xs"></i>
        Dépôt
    </a>
@endsection

@push('premium_dashboard_head')
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .admin-row { transition: background-color .18s ease; }
        .admin-row:hover { background: rgba(248, 250, 252, 0.95); }
        .admin-amount { display: block; max-width: 100%; font-size: clamp(1.35rem, 1rem + .85vw, 2.3rem); line-height: 1.08; overflow-wrap: anywhere; word-break: break-word; }
        .admin-mobile-card { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.92)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .admin-mobile-row { display: flex; flex-direction: column; gap: .35rem; padding: .7rem 0; }
        .admin-mobile-row:first-child { padding-top: 0; }
        .admin-mobile-row:last-child { padding-bottom: 0; }
        .admin-mobile-value { max-width: 100%; overflow-wrap: anywhere; word-break: break-word; }
        @media (min-width: 640px) { .admin-mobile-row { flex-direction: row; align-items: center; justify-content: space-between; gap: .75rem; } }
    </style>
@endpush

@section('dashboard_content')
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                <p class="text-xs uppercase tracking-[0.18em] text-white/60">Transactions affichees</p>
                <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $filteredTransactionsCount }}</p>
                <p class="mt-2 text-xs text-white/72">{{ $transactionsTodayCount }} aujourd'hui dans la vue courante.</p>
            </div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                <p class="text-xs uppercase tracking-[0.18em] text-white/60">Volume filtre</p>
                <p class="admin-amount premium-kpi-number mt-2 font-semibold">{{ $filteredTransactionsVolumeFormatted }}</p>
                <p class="mt-2 text-xs text-white/72">Montant cumulé pour les résultats visibles.</p>
            </div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                <p class="text-xs uppercase tracking-[0.18em] text-white/60">A surveiller</p>
                <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $filteredReviewCount }}</p>
                <p class="mt-2 text-xs text-white/72">{{ $filteredRefundedCount }} déjà remboursées.</p>
            </div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                <p class="text-xs uppercase tracking-[0.18em] text-white/60">Taux de succès</p>
                <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $filteredSuccessRate }}%</p>
                <p class="mt-2 text-xs text-white/72">{{ $filteredSuccessCount }} opération(s) réussie(s).</p>
            </div>
        </div>
    </section>

    @if(session('status'))
        <div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4">
            <p class="text-sm font-semibold text-rose-800">Action impossible</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.65fr)_360px]">
        <section class="space-y-6">
            <section class="admin-surface rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-4 border-b border-slate-200/70 pb-5 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Filtrage intelligent</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Explorer les flux</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            {{ $activeFiltersCount }} filtre(s) actif(s). Ajustez la recherche pour cibler un utilisateur, un statut ou une période.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($activeFiltersCount > 0)
                            <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-xs font-semibold text-blue-700 ring-1 ring-blue-200/80">
                                <i class="fas fa-sliders text-[11px]"></i>
                                Vue filtrée
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-600">
                            <i class="fas fa-clock text-[11px]"></i>
                            Mise à jour en temps réel
                        </span>
                    </div>
                </div>

                <form method="GET" action="{{ localized_route('admin.transactions') }}" class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="xl:col-span-2">
                        <label for="search" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Recherche</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="ID, client, email ou bénéficiaire..." class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                    </div>
                    <div>
                        <label for="type" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Type</label>
                        <select name="type" id="type" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                            <option value="">Tous les types</option>
                            <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Virement</option>
                            <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Dépôt</option>
                            <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>Retrait</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Statut</label>
                        <select name="status" id="status" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                            <option value="">Tous les statuts</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Réussi</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>En hold</option>
                            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Rembourse</option>
                        </select>
                    </div>
                    <div class="xl:col-span-2">
                        <label for="user_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Utilisateur</label>
                        <select name="user_id" id="user_id" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                            <option value="">Tous les utilisateurs</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (string) request('user_id') === (string) $user->id ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Date de début</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                    </div>
                    <div>
                        <label for="date_to" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Date de fin</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700">
                    </div>
                    <div class="xl:col-span-4 flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                        <a href="{{ localized_route('admin.transactions') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="fas fa-rotate-left text-xs"></i>
                            Réinitialiser
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
                            <i class="fas fa-search text-xs"></i>
                            Appliquer les filtres
                        </button>
                    </div>
                </form>
            </section>

            <section class="admin-surface rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-4 border-b border-slate-200/70 pb-5 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Opérations</p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Journal des transactions</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Affichage de {{ $transactions->count() }} ligne(s) sur {{ $transactions->total() }} resultat(s).
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200/80">
                            <i class="fas fa-check text-[11px]"></i>
                            {{ $filteredSuccessCount }} succès
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-4 py-2 text-xs font-semibold text-amber-700 ring-1 ring-amber-200/80">
                            <i class="fas fa-triangle-exclamation text-[11px]"></i>
                            {{ $filteredReviewCount }} à revoir
                        </span>
                    </div>
                </div>

                <div class="mt-6 space-y-3 lg:hidden">
                    @forelse($transactions as $transaction)
                        @php
                            $typeConfig = match ($transaction->type) {
                                'deposit' => ['label' => 'Dépôt', 'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80', 'icon' => 'fa-plus-circle'],
                                'withdrawal' => ['label' => 'Retrait', 'class' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200/80', 'icon' => 'fa-minus-circle'],
                                default => ['label' => 'Virement', 'class' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/80', 'icon' => 'fa-right-left'],
                            };
                            $statusConfig = match ($transaction->status) {
                                'success' => ['label' => 'Réussi', 'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80', 'icon' => 'fa-circle-check'],
                                'pending' => ['label' => 'En attente', 'class' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80', 'icon' => 'fa-clock'],
                                'on_hold' => ['label' => 'En hold', 'class' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200/80', 'icon' => 'fa-pause-circle'],
                                'refunded' => ['label' => 'Rembourse', 'class' => 'bg-violet-50 text-violet-700 ring-1 ring-violet-200/80', 'icon' => 'fa-rotate-left'],
                                default => ['label' => ucfirst(str_replace('_', ' ', $transaction->status)), 'class' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200/80', 'icon' => 'fa-circle'],
                            };
                        @endphp
                        <article class="admin-mobile-card rounded-[24px] p-4">
                            <div class="flex flex-col gap-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-slate-900">#{{ $transaction->id }}</p>
                                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[11px] font-semibold {{ $typeConfig['class'] }}">
                                                <i class="fas {{ $typeConfig['icon'] }} text-[10px]"></i>
                                                {{ $typeConfig['label'] }}
                                            </span>
                                        </div>
                                        <p class="admin-mobile-value mt-2 text-sm text-slate-500">{{ $transaction->reason ?: 'Aucun motif renseigné' }}</p>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <p class="text-base font-semibold text-slate-900">{{ \App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR') }}</p>
                                        <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">{{ $transaction->user->default_currency ?? 'EUR' }}</p>
                                    </div>
                                </div>

                                <div class="rounded-[20px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                                    <div class="admin-mobile-row text-sm text-slate-600">
                                        <span>Utilisateur</span>
                                        <div class="admin-mobile-value">
                                            <p class="font-semibold text-slate-900">{{ $transaction->user?->first_name }} {{ $transaction->user?->last_name }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $transaction->user?->email }}</p>
                                        </div>
                                    </div>
                                    <div class="admin-mobile-row text-sm text-slate-600">
                                        <span>Bénéficiaire</span>
                                        <div class="admin-mobile-value">
                                            @if($transaction->recipient_name)
                                                <p class="font-semibold text-slate-900">{{ $transaction->recipient_name }}</p>
                                                <p class="mt-1 text-sm text-slate-500">{{ $transaction->bank_name ?: 'Banque non renseignée' }}</p>
                                            @else
                                                <span class="text-sm text-slate-400">Aucun bénéficiaire</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="admin-mobile-row text-sm text-slate-600">
                                        <span>Statut</span>
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $statusConfig['class'] }}">
                                            <i class="fas {{ $statusConfig['icon'] }} text-[10px]"></i>
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </div>
                                    <div class="admin-mobile-row text-sm text-slate-600">
                                        <span>Date</span>
                                        <div class="admin-mobile-value">
                                            <p class="font-semibold text-slate-900">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ $transaction->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    @if($transaction->status === 'success' && $transaction->type === 'transfer')
                                        <button
                                            type="button"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-50 px-4 py-3 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200/80 transition hover:bg-emerald-100"
                                            onclick="openRefundModal({{ $transaction->id }}, @js(($transaction->user?->first_name ?? '') . ' ' . ($transaction->user?->last_name ?? '')), {{ (float) $transaction->amount }}, @js($transaction->user->default_currency ?? 'EUR'))"
                                        >
                                            <i class="fas fa-rotate-left text-[11px]"></i>
                                            Rembourser
                                        </button>
                                    @elseif($transaction->status === 'refunded')
                                        <span class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-violet-50 px-4 py-3 text-xs font-semibold text-violet-700 ring-1 ring-violet-200/80">
                                            <i class="fas fa-check text-[11px]"></i>
                                            {{ $transaction->refunded_at ? 'Le ' . $transaction->refunded_at->format('d/m/Y') : 'Traitee' }}
                                        </span>
                                    @else
                                        <span class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-100 px-4 py-3 text-xs font-semibold text-slate-500">
                                            <i class="fas fa-minus text-[11px]"></i>
                                            Aucun
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[24px] border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center">
                            <p class="text-lg font-semibold text-slate-900">Aucune transaction trouvee</p>
                            <p class="mt-2 text-sm text-slate-500">Essayez d ajuster les filtres pour elargir la recherche.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 hidden overflow-hidden rounded-[24px] border border-slate-200 lg:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1120px] w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50/90">
                                <tr>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Transaction</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Utilisateur</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Montant</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Bénéficiaire</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Statut</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Date</th>
                                    <th class="px-4 py-4 text-left font-semibold uppercase tracking-[0.16em] text-slate-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @forelse($transactions as $transaction)
                                    @php
                                        $typeConfig = match ($transaction->type) {
                                            'deposit' => ['label' => 'Dépôt', 'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80', 'icon' => 'fa-plus-circle'],
                                            'withdrawal' => ['label' => 'Retrait', 'class' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200/80', 'icon' => 'fa-minus-circle'],
                                            default => ['label' => 'Virement', 'class' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/80', 'icon' => 'fa-right-left'],
                                        };
                                        $statusConfig = match ($transaction->status) {
                                            'success' => ['label' => 'Réussi', 'class' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80', 'icon' => 'fa-circle-check'],
                                            'pending' => ['label' => 'En attente', 'class' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80', 'icon' => 'fa-clock'],
                                            'on_hold' => ['label' => 'En hold', 'class' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200/80', 'icon' => 'fa-pause-circle'],
                                            'refunded' => ['label' => 'Rembourse', 'class' => 'bg-violet-50 text-violet-700 ring-1 ring-violet-200/80', 'icon' => 'fa-rotate-left'],
                                            default => ['label' => ucfirst(str_replace('_', ' ', $transaction->status)), 'class' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200/80', 'icon' => 'fa-circle'],
                                        };
                                    @endphp
                                    <tr class="admin-row">
                                        <td class="px-4 py-4">
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-semibold text-slate-900">#{{ $transaction->id }}</p>
                                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[11px] font-semibold {{ $typeConfig['class'] }}">
                                                        <i class="fas {{ $typeConfig['icon'] }} text-[10px]"></i>
                                                        {{ $typeConfig['label'] }}
                                                    </span>
                                                </div>
                                                <p class="mt-2 text-sm text-slate-500">{{ $transaction->reason ?: 'Aucun motif renseigné' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-semibold text-slate-900">{{ $transaction->user?->first_name }} {{ $transaction->user?->last_name }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $transaction->user?->email }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-semibold text-slate-900">{{ \App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR') }}</p>
                                            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ $transaction->user->default_currency ?? 'EUR' }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($transaction->recipient_name)
                                                <p class="font-semibold text-slate-900">{{ $transaction->recipient_name }}</p>
                                                <p class="mt-1 text-sm text-slate-500">{{ $transaction->bank_name ?: 'Banque non renseignée' }}</p>
                                            @else
                                                <span class="text-sm text-slate-400">Aucun bénéficiaire</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $statusConfig['class'] }}">
                                                <i class="fas {{ $statusConfig['icon'] }} text-[10px]"></i>
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-slate-600">
                                            <p>{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ $transaction->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                @if($transaction->status === 'success' && $transaction->type === 'transfer')
                                                    <button
                                                        type="button"
                                                        class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200/80 transition hover:bg-emerald-100"
                                                        onclick="openRefundModal({{ $transaction->id }}, @js(($transaction->user?->first_name ?? '') . ' ' . ($transaction->user?->last_name ?? '')), {{ (float) $transaction->amount }}, @js($transaction->user->default_currency ?? 'EUR'))"
                                                    >
                                                        <i class="fas fa-rotate-left text-[11px]"></i>
                                                        Rembourser
                                                    </button>
                                                @elseif($transaction->status === 'refunded')
                                                    <span class="inline-flex items-center gap-2 rounded-full bg-violet-50 px-3 py-2 text-xs font-semibold text-violet-700 ring-1 ring-violet-200/80">
                                                        <i class="fas fa-check text-[11px]"></i>
                                                        {{ $transaction->refunded_at ? 'Le ' . $transaction->refunded_at->format('d/m/Y') : 'Traitee' }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-500">
                                                        <i class="fas fa-minus text-[11px]"></i>
                                                        Aucun
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-12 text-center">
                                            <p class="text-lg font-semibold text-slate-900">Aucune transaction trouvee</p>
                                            <p class="mt-2 text-sm text-slate-500">Essayez d ajuster les filtres pour elargir la recherche.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($transactions->hasPages())
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-slate-500">Affichage de {{ $transactions->firstItem() }} a {{ $transactions->lastItem() }} sur {{ $transactions->total() }} transactions</p>
                        <div class="overflow-x-auto pb-1">{{ $transactions->links('vendor.pagination.tailwind') }}</div>
                    </div>
                @endif
            </section>
        </section>

        <aside class="space-y-6">
            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Surveillance</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Dernieres opérations</h3>
                <div class="mt-5 space-y-3">
                    @forelse($recentTransactions as $transaction)
                        <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-900">#{{ $transaction->id }} - {{ $transaction->user?->first_name }} {{ $transaction->user?->last_name }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }} | {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}</p>
                                    <p class="mt-2 text-sm text-slate-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="admin-mobile-value text-sm font-semibold text-slate-900 sm:text-right">{{ \App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center">
                            <p class="text-sm font-semibold text-slate-900">Aucune donnee recente</p>
                            <p class="mt-2 text-sm text-slate-500">Les transactions les plus recentes apparaitront ici.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Actions critiques</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Cadre de remboursement</h3>
                <div class="mt-5 space-y-4 text-sm leading-6 text-slate-500">
                    <p>Les remboursements restent limites aux virements réussis. Une trace horodatee est conservee avec le motif et l administrateur responsable.</p>
                    <div class="rounded-[22px] bg-amber-50 px-4 py-4 ring-1 ring-amber-200/80">
                        <p class="font-semibold text-amber-900">Point d attention</p>
                        <p class="mt-2 text-amber-700">Verifiez toujours le motif et l impact solde avant de confirmer une annulation ou un remboursement.</p>
                    </div>
                </div>
            </section>
        </aside>
    </div>

    <div id="refundModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-950/45 px-4 backdrop-blur-sm">
        <div class="admin-surface w-full max-w-lg rounded-[30px] p-6 sm:p-7">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Confirmation</p>
                    <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Rembourser la transaction</h3>
                </div>
                <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 transition hover:bg-slate-200 hover:text-slate-700" onclick="closeRefundModal()">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="mt-5 rounded-[24px] bg-blue-50 px-4 py-4 ring-1 ring-blue-200/80">
                <p class="text-sm font-semibold text-blue-900">Client concerne</p>
                <p id="modalUserName" class="mt-2 text-sm text-blue-700"></p>
                <p id="modalAmount" class="mt-2 text-sm font-semibold text-blue-900"></p>
            </div>

            <form id="refundForm" method="POST" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label for="refund_reason" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Motif du remboursement</label>
                    <textarea id="refund_reason" name="refund_reason" rows="4" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Erreur de saisie, double opération, demande client..."></textarea>
                </div>

                <div class="rounded-[24px] bg-amber-50 px-4 py-4 ring-1 ring-amber-200/80">
                    <p class="text-sm font-semibold text-amber-900">Impact immediat</p>
                    <p class="mt-2 text-sm text-amber-700">Le montant sera recredite sur le compte du client et la transaction passera au statut rembourse.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50" onclick="closeRefundModal()">
                        <i class="fas fa-arrow-left text-xs"></i>
                        Annuler
                    </button>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-700">
                        <i class="fas fa-check text-xs"></i>
                        Confirmer le remboursement
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('premium_dashboard_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const refundModal = document.getElementById('refundModal');
            const refundBaseUrl = @json(url(app()->getLocale() . '/admin/transactions'));

            window.openRefundModal = function (transactionId, userName, amount, currency) {
                const locale = document.documentElement.lang || '{{ app()->getLocale() }}';
                const formattedAmount = new Intl.NumberFormat(locale, {
                    style: 'currency',
                    currency: currency || 'EUR',
                    minimumFractionDigits: 2,
                }).format(amount);

                document.getElementById('modalUserName').textContent = userName.trim();
                document.getElementById('modalAmount').textContent = formattedAmount;
                document.getElementById('refundForm').action = `${refundBaseUrl}/${transactionId}/refund`;
                refundModal.classList.remove('hidden');
                refundModal.classList.add('flex');
            };

            window.closeRefundModal = function () {
                refundModal.classList.add('hidden');
                refundModal.classList.remove('flex');
            };

            refundModal?.addEventListener('click', function (event) {
                if (event.target === refundModal) {
                    window.closeRefundModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && refundModal && !refundModal.classList.contains('hidden')) {
                    window.closeRefundModal();
                }
            });
        });
    </script>
@endpush
