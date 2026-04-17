<?php $__env->startSection('title', 'Administration - Valtrix Bank'); ?>
<?php $__env->startSection('dashboard_theme', 'admin'); ?>
<?php $__env->startSection('dashboard_page_title', 'Tableau de bord administrateur'); ?>
<?php $__env->startSection('dashboard_page_subtitle', 'Un poste de pilotage premium pour suivre les utilisateurs, les transactions, les validations et les actions critiques sans friction.'); ?>
<?php $__env->startSection('dashboard_section_label', 'Pilotage admin'); ?>
<?php $__env->startSection('dashboard_search_placeholder', 'Rechercher un client, une transaction, une opération ou un statut...'); ?>
<?php $__env->startSection('dashboard_brand_title', 'Valtrix Admin'); ?>
<?php $__env->startSection('dashboard_brand_subtitle', 'Centre de contrôle'); ?>
<?php $__env->startSection('sidebar_primary_title', 'Navigation'); ?>

<?php $__env->startSection('sidebar_primary'); ?>
    <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-700 shadow-sm ring-1 ring-slate-200">
            <i class="fas fa-chart-line"></i>
        </span>
        <span>Tableau de bord</span>
    </a>
    <a href="<?php echo e(localized_route('admin.users')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-users"></i>
        </span>
        <span>Utilisateurs</span>
    </a>
    <a href="<?php echo e(localized_route('admin.transactions')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-exchange-alt"></i>
        </span>
        <span>Virements</span>
    </a>
    <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-plus-circle"></i>
        </span>
        <span>Dépôt</span>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_secondary_title', 'Opérations'); ?>
<?php $__env->startSection('sidebar_secondary'); ?>
    <a href="<?php echo e(localized_route('admin.settings')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-gear"></i>
        </span>
        <span>Paramètres</span>
    </a>
    <a href="<?php echo e(localized_route('admin.export.pdf')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-file-pdf"></i>
        </span>
        <span>Export PDF</span>
    </a>
    <a href="<?php echo e(localized_route('admin.export.excel')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-file-excel"></i>
        </span>
        <span>Export Excel</span>
    </a>
    <a href="<?php echo e(localized_route('home')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span>Retour au site</span>
    </a>
    <form method="POST" action="<?php echo e(localized_route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
                <i class="fas fa-right-from-bracket"></i>
            </span>
            <span>Déconnexion</span>
        </button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_footer'); ?>
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">Governance</p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold">Couverture active</h3>
            <p class="mt-2 text-sm leading-6 text-white/78">
                <?php echo e($activeUsersRate); ?>% du parc client est actif. Les files prioritaires et le chat admin restent accèssibles depuis ce centre de pilotage.
            </p>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-white/10 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.16em] text-white/60">Alertes</p>
                    <p class="mt-2 text-lg font-semibold"><?php echo e($unreadNotificationsCount); ?></p>
                </div>
                <div class="rounded-2xl bg-white/10 px-4 py-3">
                    <p class="text-xs uppercase tracking-[0.16em] text-white/60">Chat</p>
                    <p class="mt-2 text-lg font-semibold"><?php echo e($chatUnreadCount); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <div class="hidden items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 ring-1 ring-slate-200 md:inline-flex">
        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
        Supervision active
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_header_actions'); ?>
    <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-plus text-xs"></i>
        Nouveau dépôt
    </a>
    <a href="<?php echo e(localized_route('admin.export.excel')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-file-export text-xs"></i>
        Exporter
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('premium_dashboard_head'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('dashboard_content'); ?>
    <?php
        $monthlyTransfersFormatted = \App\Helpers\CurrencyHelper::format($monthlyTransfers, 'EUR');
        $monthlyDepositsFormatted = \App\Helpers\CurrencyHelper::format($monthlyDeposits, 'EUR');
        $totalTransfersFormatted = \App\Helpers\CurrencyHelper::format($totalTransfers, 'EUR');
        $totalDepositsFormatted = \App\Helpers\CurrencyHelper::format($totalDeposits, 'EUR');
    ?>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.7fr)_minmax(300px,360px)]">
        <section class="premium-gradient-card premium-grid-glow premium-card-hover relative min-w-0 overflow-hidden rounded-[30px] p-6 sm:p-7">
            <div class="relative z-10">
                <div class="flex min-w-0 flex-col gap-6 lg:items-start 2xl:flex-row 2xl:justify-between">
                    <div class="min-w-0 max-w-2xl">
                        <p class="text-sm uppercase tracking-[0.22em] text-white/65">Vue exécutive</p>
                        <h2 class="mt-4 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">
                            <?php echo e($totalUsers); ?> clients supervisés
                        </h2>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-white/78">
                            Votre back office premium centralise les flux, les validations et les alertes critiques pour accélérer les décisions opérationnelles.
                        </p>
                    </div>

                    <div class="grid w-full gap-3 sm:grid-cols-2 2xl:max-w-[340px]">
                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.18em] text-white/60">Alertes admin</p>
                            <p class="mt-2 text-lg font-semibold"><?php echo e($unreadNotificationsCount); ?></p>
                            <p class="mt-1 text-xs text-white/70">Notifications non lues dans le centre de contrôle.</p>
                        </div>
                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.18em] text-white/60">Messages entrants</p>
                            <p class="mt-2 text-lg font-semibold"><?php echo e($chatUnreadCount); ?></p>
                            <p class="mt-1 text-xs text-white/70">Conversations client en attente de réponse.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-3">
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60">Virements 30 jours</p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($monthlyTransfersFormatted); ?></p>
                    </div>
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60">Dépôts 30 jours</p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($monthlyDepositsFormatted); ?></p>
                    </div>
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60">Succès transactions</p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($transactionSuccessRate); ?>%</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Priorités</p>
                    <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">File critique</h2>
                </div>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                    <?php echo e($pendingUsersCount + $pendingTransactionsCount); ?> éléments
                </span>
            </div>

            <div class="mt-5 space-y-4">
                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Utilisateurs en attente</p>
                            <p class="mt-1 text-sm text-slate-500">Validation admin nécessaire pour activer les comptes.</p>
                        </div>
                        <span class="premium-brand-title text-3xl font-semibold text-slate-900"><?php echo e($pendingUsersCount); ?></span>
                    </div>
                </div>

                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Transactions à surveiller</p>
                            <p class="mt-1 text-sm text-slate-500">Opérations en attente ou mises en attente.</p>
                        </div>
                        <span class="premium-brand-title text-3xl font-semibold text-slate-900"><?php echo e($pendingTransactionsCount); ?></span>
                    </div>
                </div>

                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $pendingUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pendingUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex flex-col gap-3 rounded-[22px] border border-slate-200 bg-white px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900"><?php echo e($pendingUser->name); ?></p>
                                <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e($pendingUser->created_at->format('d/m/Y H:i')); ?></p>
                            </div>
                            <a href="<?php echo e(localized_route('admin.users.edit', ['user' => $pendingUser])); ?>" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-3 py-2 text-xs font-semibold text-white">
                                Ouvrir
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center">
                            <p class="text-sm font-semibold text-slate-900">Aucune validation urgente</p>
                            <p class="mt-2 text-sm text-slate-500">La file d'attente est vide pour le moment.</p>
                        </div>
                    <?php endif; ?>
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
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($activeUsers); ?></p>
            <p class="mt-2 text-sm text-slate-500"><?php echo e($activeUsersRate); ?>% de la base utilisateur.</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Transactions</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fas fa-arrow-right-arrow-left"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($totalTransactions); ?></p>
            <p class="mt-2 text-sm text-slate-500">Activité consolidée sur l'ensemble du système.</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Total virements</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-purple-50 text-purple-700">
                    <i class="fas fa-paper-plane"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($totalTransfersFormatted); ?></p>
            <p class="mt-2 text-sm text-slate-500">Volume cumule des virements emis.</p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Total dépôts</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                    <i class="fas fa-coins"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($totalDepositsFormatted); ?></p>
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
                        <p class="mt-2 text-sm leading-6 text-slate-500">Clients pleinement opérationnels sur la plateforme.</p>
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
                <?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900"><?php echo e($recentUser->name); ?></p>
                                <p class="mt-1 truncate text-sm text-slate-500"><?php echo e($recentUser->email); ?></p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] <?php echo e($recentUser->status === 'active' ? 'bg-emerald-50 text-emerald-700' : ($recentUser->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600')); ?>">
                                <?php echo e($recentUser->status); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <a href="<?php echo e(localized_route('admin.transactions')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Voir tout
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="mt-6 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusClass = match ($transaction->status) {
                            'success' => 'bg-emerald-50 text-emerald-700',
                            'pending', 'on_hold' => 'bg-amber-50 text-amber-700',
                            'refunded' => 'bg-slate-100 text-slate-700',
                            default => 'bg-rose-50 text-rose-700',
                        };
                    ?>
                    <div class="flex flex-col gap-3 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900">
                                <?php echo e(ucfirst(str_replace('_', ' ', $transaction->type))); ?> #<?php echo e($transaction->id); ?>

                            </p>
                            <p class="mt-1 truncate text-sm text-slate-500">
                                <?php echo e($transaction->user?->name ?? 'Client inconnu'); ?> - <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?>

                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 sm:justify-end">
                            <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] <?php echo e($statusClass); ?>">
                                <?php echo e(str_replace('_', ' ', $transaction->status)); ?>

                            </span>
                            <span class="text-sm font-semibold text-slate-900">
                                <?php echo e(\App\Helpers\CurrencyHelper::format($transaction->amount, 'EUR')); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="rounded-[24px] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center">
                        <p class="text-lg font-semibold text-slate-900">Aucune transaction recente</p>
                        <p class="mt-2 text-sm text-slate-500">Le flux opérationnel s'affichera ici des qu'un mouvement sera enregistre.</p>
                    </div>
                <?php endif; ?>
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
                    <a href="<?php echo e(localized_route('admin.users')); ?>" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <i class="fas fa-user-check"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Gerer les utilisateurs</p>
                                <p class="text-sm text-slate-500"><?php echo e($pendingUsersCount); ?> validation(s) en attente</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <i class="fas fa-circle-plus"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Effectuer un dépôt</p>
                                <p class="text-sm text-slate-500">Injecter un mouvement crediteur en quelques clics.</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="<?php echo e(localized_route('admin.settings')); ?>" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
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
                <?php echo $__env->make('components.market-tracker-fixed', ['compact' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_overlays'); ?>
    <?php echo $__env->make('components.admin-chat-widget-v2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('premium_dashboard_scripts'); ?>
    <?php
        $adminStatusChartLabels = ['Active', 'Pending', 'Suspendus'];
        $adminStatusChartValues = [$activeUsers, $pendingUsersCount, $suspendedUsersCount];
        $adminVolumeChartLabels = ['Dépôts 30j', 'Virements 30j'];
        $adminVolumeChartValues = [round((float) $monthlyDeposits, 2), round((float) $monthlyTransfers, 2)];
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusCtx = document.getElementById('adminStatusChart');
            const volumeCtx = document.getElementById('adminVolumeChart');

            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: <?php echo json_encode($adminStatusChartLabels, 15, 512) ?>,
                        datasets: [{
                            data: <?php echo json_encode($adminStatusChartValues, 15, 512) ?>,
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
                        labels: <?php echo json_encode($adminVolumeChartLabels, 15, 512) ?>,
                        datasets: [{
                            label: 'Montant',
                            data: <?php echo json_encode($adminVolumeChartValues, 15, 512) ?>,
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
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.premium-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>