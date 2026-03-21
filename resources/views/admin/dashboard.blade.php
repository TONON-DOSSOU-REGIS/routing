@extends('layouts.premium-dashboard')

@section('title', 'Administration - Valtrix Bank')
@section('dashboard_theme', 'admin')
@section('dashboard_page_title', 'Dashboard administrateur')
@section('dashboard_page_subtitle', 'Un poste de pilotage premium pour suivre les utilisateurs, les transactions, les validations et les actions critiques sans friction.')
@section('dashboard_section_label', 'Control room')
@section('dashboard_search_placeholder', 'Rechercher un client, une transaction, une operation ou un statut...')
@section('dashboard_brand_title', 'Valtrix Admin')
@section('dashboard_brand_subtitle', 'Control center')
@section('sidebar_primary_title', 'Navigation')

@section('sidebar_primary')
    <a href="{{ localized_route('admin.dashboard') }}" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-700 shadow-sm ring-1 ring-slate-200">
            <i class="fas fa-chart-line"></i>
        </span>
        <span>Dashboard</span>
    </a>
    <a href="{{ localized_route('admin.users') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-users"></i>
        </span>
        <span>Utilisateurs</span>
    </a>
    <a href="{{ localized_route('admin.transactions') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-exchange-alt"></i>
        </span>
        <span>Virements</span>
    </a>
    <a href="{{ localized_route('admin.deposit') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-plus-circle"></i>
        </span>
        <span>Depot</span>
    </a>
@endsection

@section('sidebar_secondary_title', 'Operations')
@section('sidebar_secondary')
    <a href="{{ localized_route('admin.settings') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-gear"></i>
        </span>
        <span>Parametres</span>
    </a>
    <a href="{{ localized_route('admin.export.pdf') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-file-pdf"></i>
        </span>
        <span>Export PDF</span>
    </a>
    <a href="{{ localized_route('admin.export.excel') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-file-excel"></i>
        </span>
        <span>Export Excel</span>
    </a>
    <a href="{{ localized_route('home') }}" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span>Retour site</span>
    </a>
    <form method="POST" action="{{ localized_route('logout') }}">
        @csrf
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
                <i class="fas fa-right-from-bracket"></i>
            </span>
            <span>Deconnexion</span>
        </button>
    </form>
@endsection

@section('sidebar_footer')
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">Governance</p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold">Couverture active</h3>
            <p class="mt-2 text-sm leading-6 text-white/78">
                {{ $activeUsersRate }}% du parc client est actif. Les files prioritaires et le chat admin restent accessibles depuis ce centre de pilotage.
            </p>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-white/10 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.16em] text-white/60">Alertes</p>
                    <p class="mt-2 text-lg font-semibold">{{ $unreadNotificationsCount }}</p>
                </div>
                <div class="rounded-2xl bg-white/10 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.16em] text-white/60">Chat</p>
                    <p class="mt-2 text-lg font-semibold">{{ $chatUnreadCount }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('topbar_actions')
    <div class="hidden items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 ring-1 ring-slate-200 md:inline-flex">
        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
        Monitoring actif
    </div>
@endsection

@section('dashboard_header_actions')
    <a href="{{ localized_route('admin.deposit') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-plus text-xs"></i>
        Nouveau depot
    </a>
    <a href="{{ localized_route('admin.export.excel') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-file-export text-xs"></i>
        Exporter
    </a>
@endsection

@push('premium_dashboard_head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('dashboard_content')
    @php
        $monthlyTransfersFormatted = \App\Helpers\CurrencyHelper::format($monthlyTransfers, 'EUR');
        $monthlyDepositsFormatted = \App\Helpers\CurrencyHelper::format($monthlyDeposits, 'EUR');
        $totalTransfersFormatted = \App\Helpers\CurrencyHelper::format($totalTransfers, 'EUR');
        $totalDepositsFormatted = \App\Helpers\CurrencyHelper::format($totalDeposits, 'EUR');
    @endphp

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.7fr)_minmax(300px,360px)]">
        <section class="premium-gradient-card premium-grid-glow premium-card-hover relative min-w-0 overflow-hidden rounded-[30px] p-6 sm:p-7">
            <div class="relative z-10">
                <div class="flex min-w-0 flex-col gap-6 lg:items-start 2xl:flex-row 2xl:justify-between">
                    <div class="min-w-0 max-w-2xl">
                        <p class="text-sm uppercase tracking-[0.22em] text-white/65">Vue executive</p>
                        <h2 class="mt-4 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">
                            {{ $totalUsers }} clients supervises
                        </h2>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-white/78">
                            Votre back office premium centralise les flux, les validations et les alertes critiques pour accelerer les decisions operatoires.
                        </p>
                    </div>

                    <div class="grid w-full gap-3 sm:grid-cols-2 2xl:max-w-[340px]">
                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.18em] text-white/60">Alertes admin</p>
                            <p class="mt-2 text-lg font-semibold">{{ $unreadNotificationsCount }}</p>
                            <p class="mt-1 text-xs text-white/70">Notifications non lues dans le centre de controle.</p>
                        </div>
                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.18em] text-white/60">Messages entrants</p>
                            <p class="mt-2 text-lg font-semibold">{{ $chatUnreadCount }}</p>
                            <p class="mt-1 text-xs text-white/70">Conversations client en attente de reponse.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-3">
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60">Virements 30 jours</p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $monthlyTransfersFormatted }}</p>
                    </div>
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60">Depots 30 jours</p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $monthlyDepositsFormatted }}</p>
                    </div>
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60">Succes transactions</p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold">{{ $transactionSuccessRate }}%</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Priorites</p>
                    <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">File critique</h2>
                </div>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                    {{ $pendingUsersCount + $pendingTransactionsCount }} elements
                </span>
            </div>

            <div class="mt-5 space-y-4">
                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Utilisateurs en attente</p>
                            <p class="mt-1 text-sm text-slate-500">Validation admin necessaire pour activer les comptes.</p>
                        </div>
                        <span class="premium-brand-title text-3xl font-semibold text-slate-900">{{ $pendingUsersCount }}</span>
                    </div>
                </div>

                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Transactions a surveiller</p>
                            <p class="mt-1 text-sm text-slate-500">Operations en attente ou mises en hold.</p>
                        </div>
                        <span class="premium-brand-title text-3xl font-semibold text-slate-900">{{ $pendingTransactionsCount }}</span>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($pendingUsers as $pendingUser)
                        <div class="flex flex-col gap-3 rounded-[22px] border border-slate-200 bg-white px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">{{ $pendingUser->name }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400">{{ $pendingUser->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <a href="{{ localized_route('admin.users.edit', ['user' => $pendingUser]) }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-3 py-2 text-xs font-semibold text-white">
                                Ouvrir
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    @empty
                        <div class="rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center">
                            <p class="text-sm font-semibold text-slate-900">Aucune validation urgente</p>
                            <p class="mt-2 text-sm text-slate-500">La file d'attente est vide pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <section class="grid gap-4 md:grid-cols-2 2xl:grid-cols-4">
        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Clients actifs</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                    <i class="fas fa-users"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950">{{ $activeUsers }}</p>
            <p class="mt-2 text-sm text-slate-500">{{ $activeUsersRate }}% de la base utilisateur.</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Transactions</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fas fa-arrow-right-arrow-left"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950">{{ $totalTransactions }}</p>
            <p class="mt-2 text-sm text-slate-500">Activite consolidee sur l'ensemble du systeme.</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Total virements</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-purple-50 text-purple-700">
                    <i class="fas fa-paper-plane"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950">{{ $totalTransfersFormatted }}</p>
            <p class="mt-2 text-sm text-slate-500">Volume cumule des virements emis.</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Total depots</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                    <i class="fas fa-coins"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950">{{ $totalDepositsFormatted }}</p>
            <p class="mt-2 text-sm text-slate-500">Base creditee sur les comptes clients.</p>
        </article>
    </section>

    <div class="grid gap-6 xl:grid-cols-2 2xl:grid-cols-[minmax(0,1.25fr)_minmax(0,1fr)_320px]">
        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6 xl:col-span-2 2xl:col-span-1">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Users health</p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">Repartition des statuts</h2>
                </div>
                <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">En direct</span>
            </div>
            <div class="mt-6 grid gap-6 2xl:grid-cols-[200px_minmax(0,1fr)]">
                <div class="relative h-[240px] sm:h-[280px]">
                    <canvas id="adminStatusChart"></canvas>
                </div>
                <div class="min-w-0 space-y-4">
                    <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <p class="text-sm font-semibold text-slate-900">Actifs</p>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Clients pleinement operationnels sur la plateforme.</p>
                    </div>
                    <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <p class="text-sm font-semibold text-slate-900">Pending</p>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Comptes a approuver, a verifier ou a relancer.</p>
                    </div>
                    <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <p class="text-sm font-semibold text-slate-900">Suspendus</p>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Parc sous surveillance renforcee ou bloque.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Cadence</p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">Volumes 30 jours</h2>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">EUR</span>
            </div>
            <div class="mt-6 h-[240px] sm:h-[280px] xl:h-[320px]">
                <canvas id="adminVolumeChart"></canvas>
            </div>
        </section>

        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6 xl:col-span-2 2xl:col-span-1">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Onboarding</p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">Recents</h2>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">Nouveaux</span>
            </div>

            <div class="mt-6 space-y-3">
                @foreach($recentUsers as $recentUser)
                    <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">{{ $recentUser->name }}</p>
                                <p class="mt-1 truncate text-sm text-slate-500">{{ $recentUser->email }}</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] {{ $recentUser->status === 'active' ? 'bg-emerald-50 text-emerald-700' : ($recentUser->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ $recentUser->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.5fr)_minmax(300px,360px)]">
        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Supervision</p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">Transactions recentes</h2>
                </div>
                <a href="{{ localized_route('admin.transactions') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Voir tout
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse($recentTransactions as $transaction)
                    @php
                        $statusClass = match ($transaction->status) {
                            'success' => 'bg-emerald-50 text-emerald-700',
                            'pending', 'on_hold' => 'bg-amber-50 text-amber-700',
                            'refunded' => 'bg-slate-100 text-slate-700',
                            default => 'bg-rose-50 text-rose-700',
                        };
                    @endphp
                    <div class="flex flex-col gap-3 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900">
                                {{ ucfirst(str_replace('_', ' ', $transaction->type)) }} #{{ $transaction->id }}
                            </p>
                            <p class="mt-1 truncate text-sm text-slate-500">
                                {{ $transaction->user?->name ?? 'Client inconnu' }} - {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 sm:justify-end">
                            <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] {{ $statusClass }}">
                                {{ str_replace('_', ' ', $transaction->status) }}
                            </span>
                            <span class="text-sm font-semibold text-slate-900">
                                {{ \App\Helpers\CurrencyHelper::format($transaction->amount, 'EUR') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-[24px] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center">
                        <p class="text-lg font-semibold text-slate-900">Aucune transaction recente</p>
                        <p class="mt-2 text-sm text-slate-500">Le flux operationnel s'affichera ici des qu'un mouvement sera enregistre.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <div class="min-w-0 space-y-6">
            <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Execution</p>
                        <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">Actions rapides</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">Admin</span>
                </div>

                <div class="mt-5 space-y-3">
                    <a href="{{ localized_route('admin.users') }}" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <i class="fas fa-user-check"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Gerer les utilisateurs</p>
                                <p class="text-sm text-slate-500">{{ $pendingUsersCount }} validation(s) en attente</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="{{ localized_route('admin.deposit') }}" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <i class="fas fa-circle-plus"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Effectuer un depot</p>
                                <p class="text-sm text-slate-500">Injecter un mouvement crediteur en quelques clics.</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="{{ localized_route('admin.settings') }}" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                <i class="fas fa-sliders"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Regler les parametres</p>
                                <p class="text-sm text-slate-500">Piloter les seuils, messages et comportements systeme.</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>
                </div>
            </section>

            <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-3">
                @include('components.market-tracker-fixed', ['compact' => true])
            </section>
        </div>
    </div>
@endsection

@section('dashboard_overlays')
    @include('components.admin-chat-widget-v2')
@endsection

@push('premium_dashboard_scripts')
    @php
        $adminStatusChartLabels = ['Active', 'Pending', 'Suspendus'];
        $adminStatusChartValues = [$activeUsers, $pendingUsersCount, $suspendedUsersCount];
        $adminVolumeChartLabels = ['Depots 30j', 'Virements 30j'];
        $adminVolumeChartValues = [round((float) $monthlyDeposits, 2), round((float) $monthlyTransfers, 2)];
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusCtx = document.getElementById('adminStatusChart');
            const volumeCtx = document.getElementById('adminVolumeChart');

            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($adminStatusChartLabels),
                        datasets: [{
                            data: @json($adminStatusChartValues),
                            backgroundColor: ['#155eef', '#f79009', '#98a2b3'],
                            borderWidth: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10,
                                    padding: 18,
                                },
                            },
                        },
                    },
                });
            }

            if (volumeCtx) {
                new Chart(volumeCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($adminVolumeChartLabels),
                        datasets: [{
                            label: 'Montant',
                            data: @json($adminVolumeChartValues),
                            backgroundColor: ['rgba(21, 94, 239, 0.82)', 'rgba(34, 197, 94, 0.72)'],
                            borderRadius: 16,
                            borderSkipped: false,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return new Intl.NumberFormat('fr-FR', {
                                            style: 'currency',
                                            currency: 'EUR'
                                        }).format(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return new Intl.NumberFormat('fr-FR', {
                                            style: 'currency',
                                            currency: 'EUR',
                                            maximumFractionDigits: 0
                                        }).format(value);
                                    }
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.18)',
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush


