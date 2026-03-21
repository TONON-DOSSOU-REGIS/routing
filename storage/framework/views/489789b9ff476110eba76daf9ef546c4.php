<?php
    $balanceFormatted = \App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR');
    $profilePhotoUrl = $user->profile_photo_url;
    $initials = strtoupper(substr($user->first_name ?? '', 0, 1) . substr($user->last_name ?? '', 0, 1));
    $accountStatusLabels = trans('profile.account_statuses');
    $transactionTypeLabels = trans('profile.transaction_types');
    $transactionStatusLabels = trans('profile.transaction_statuses');
    $accountStatusLabel = $accountStatusLabels[$user->status ?? 'active'] ?? ucfirst((string) ($user->status ?? 'active'));
    $accountTypeLabel = $user->isAdmin() ? __('profile.account_type_admin') : __('profile.account_type_client');
    $currencyCode = $user->default_currency ?? 'EUR';
    $currencies = config('currencies.currencies');
    $currencyLabel = $currencies[$currencyCode] ?? $currencyCode;
    $dateOfBirth = $user->date_of_birth?->format('d/m/Y') ?? __('profile.not_specified');
    $formattedIban = $user->iban
        ? trim(chunk_split(preg_replace('/\s+/', '', (string) $user->iban), 4, ' '))
        : __('profile.not_specified');
    $formattedBic = $user->bic ?: __('profile.not_specified');
    $maskedActivationCode = $user->activation_code ? str_repeat('•', 8) : __('profile.no_activation_code');
    $cardExpiry = $user->creditCard?->expiry_date?->format('m/Y') ?? __('profile.not_specified');
    $profileInfoCards = [
        ['icon' => 'fa-user-circle', 'tone' => 'bg-blue-50 text-blue-700', 'label' => __('profile.full_name'), 'value' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: __('profile.not_specified')],
        ['icon' => 'fa-envelope', 'tone' => 'bg-emerald-50 text-emerald-700', 'label' => __('profile.email_address'), 'value' => $user->email ?: __('profile.not_specified')],
        ['icon' => 'fa-phone', 'tone' => 'bg-violet-50 text-violet-700', 'label' => __('profile.phone'), 'value' => $user->phone ?: __('profile.not_specified')],
        ['icon' => 'fa-calendar', 'tone' => 'bg-amber-50 text-amber-700', 'label' => __('profile.date_of_birth'), 'value' => $dateOfBirth],
        ['icon' => 'fa-home', 'tone' => 'bg-rose-50 text-rose-700', 'label' => __('profile.address'), 'value' => $user->address ?: __('profile.not_specified')],
        ['icon' => 'fa-city', 'tone' => 'bg-cyan-50 text-cyan-700', 'label' => __('profile.city'), 'value' => $user->city ?: __('profile.not_specified')],
        ['icon' => 'fa-globe', 'tone' => 'bg-teal-50 text-teal-700', 'label' => __('profile.country'), 'value' => $user->country ?: __('profile.not_specified')],
        ['icon' => 'fa-id-badge', 'tone' => 'bg-indigo-50 text-indigo-700', 'label' => __('profile.id_type'), 'value' => $user->id_type ?: __('profile.not_specified')],
        ['icon' => 'fa-hashtag', 'tone' => 'bg-fuchsia-50 text-fuchsia-700', 'label' => __('profile.id_number'), 'value' => $user->id_number ?: __('profile.not_specified')],
        ['icon' => 'fa-money-bill-wave', 'tone' => 'bg-lime-50 text-lime-700', 'label' => __('profile.default_currency'), 'value' => $currencyCode . ' - ' . $currencyLabel],
    ];
    $accountStatusBadgeClass = match ($user->status) {
        'active' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80',
        'pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80',
        'suspended' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80',
        default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
    };
?>

<?php $__env->startSection('title', __('profile.page_title')); ?>
<?php $__env->startSection('dashboard_theme', 'client'); ?>
<?php $__env->startSection('dashboard_page_title', __('profile.page_title')); ?>
<?php $__env->startSection('dashboard_page_subtitle', __('profile.page_subtitle')); ?>
<?php $__env->startSection('dashboard_section_label', __('dashboard.premium_profile')); ?>
<?php $__env->startSection('dashboard_search_placeholder', __('dashboard.search_placeholder')); ?>
<?php $__env->startSection('dashboard_brand_title', 'Valtrix Bank'); ?>
<?php $__env->startSection('dashboard_brand_subtitle', __('dashboard.client_area')); ?>
<?php $__env->startSection('sidebar_primary_title', __('dashboard.menu')); ?>

<?php $__env->startSection('sidebar_primary'); ?>
    <a href="<?php echo e(localized_route('dashboard')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-chart-pie"></i>
        </span>
        <span><?php echo e(__('dashboard.dashboard_title')); ?></span>
    </a>
    <a href="<?php echo e(localized_route('transfer.create')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-paper-plane"></i>
        </span>
        <span><?php echo e(__('dashboard.new_transfer')); ?></span>
    </a>
    <a href="<?php echo e(localized_route('transactions.history')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-clock-rotate-left"></i>
        </span>
        <span><?php echo e(__('dashboard.history')); ?></span>
    </a>
    <a href="<?php echo e(localized_route('profile')); ?>" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm ring-1 ring-emerald-200/80">
            <i class="fas fa-user-shield"></i>
        </span>
        <span><?php echo e(__('dashboard.profile')); ?></span>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_secondary_title', __('dashboard.services')); ?>
<?php $__env->startSection('sidebar_secondary'); ?>
    <a href="<?php echo e(localized_route('notifications.index')); ?>" class="premium-nav-item flex items-center justify-between gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
                <i class="fas fa-bell"></i>
            </span>
            <span><?php echo e(__('dashboard.notifications')); ?></span>
        </span>
        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700"><?php echo e($unreadNotificationsCount); ?></span>
    </a>
    <a href="<?php echo e(localized_route('support.nous-contacter')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
            <i class="fas fa-headset"></i>
        </span>
        <span><?php echo e(__('dashboard.support')); ?></span>
    </a>
    <form method="POST" action="<?php echo e(localized_route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
                <i class="fas fa-right-from-bracket"></i>
            </span>
            <span><?php echo e(__('dashboard.logout')); ?></span>
        </button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_footer'); ?>
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70"><?php echo e(__('dashboard.concierge_service')); ?></p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold"><?php echo e(__('dashboard.priority_access')); ?></h3>
            <p class="mt-2 text-sm leading-6 text-white/78">
                <?php echo e(__('dashboard.concierge_description')); ?>

            </p>
            <div class="mt-5 rounded-2xl bg-white/10 px-4 py-3">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.profile')); ?></p>
                        <p class="text-lg font-semibold"><?php echo e($profileCompletion); ?>%</p>
                    </div>
                    <a href="<?php echo e(localized_route('transactions.history')); ?>" class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-2 text-xs font-semibold text-slate-900">
                        <?php echo e(__('profile.view_all')); ?>

                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <div class="mt-3 h-2.5 rounded-full bg-white/20">
                    <div class="h-2.5 rounded-full bg-white" style="width: <?php echo e($profileCompletion); ?>%"></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <div class="hidden items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 ring-1 ring-slate-200 md:inline-flex">
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
        <?php echo e(__('dashboard.secure_session')); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_header_actions'); ?>
    <a href="<?php echo e(localized_route('transfer.create')); ?>" class="inline-flex items-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition hover:bg-orange-600">
        <i class="fas fa-paper-plane text-xs"></i>
        <?php echo e(__('profile.new_transfer')); ?>

    </a>
    <a href="<?php echo e(localized_route('transactions.history')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-clock-rotate-left text-xs"></i>
        <?php echo e(__('profile.history')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('premium_dashboard_head'); ?>
    <style>
        .profile-info-grid {
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
        }

        .profile-info-card,
        .profile-side-card,
        .profile-activity-item {
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 250, 252, 0.88));
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
        }

        .profile-info-value,
        .profile-stat-value,
        .profile-balance-value {
            display: block;
            max-width: 100%;
            white-space: normal;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .profile-stat-value {
            font-size: clamp(1.55rem, 1rem + 1.1vw, 2.7rem);
            line-height: 1.08;
        }

        .profile-balance-value {
            font-size: clamp(1.35rem, 0.92rem + 1vw, 2.35rem);
            line-height: 1.1;
            text-wrap: balance;
        }

        .profile-stat-card {
            min-width: 0;
        }

        .profile-avatar-shell {
            background:
                radial-gradient(circle at 30% 20%, rgba(255, 255, 255, 0.28), transparent 40%),
                linear-gradient(135deg, rgba(15, 91, 66, 0.92), rgba(22, 124, 91, 0.86));
        }

        .profile-data-row {
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        }

        .profile-data-row:last-child {
            border-bottom: 0;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('dashboard_content'); ?>
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-6 2xl:grid-cols-[minmax(0,1.35fr)_minmax(320px,420px)]">
            <div class="min-w-0">
                <div class="flex min-w-0 flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="profile-avatar-shell flex h-24 w-24 items-center justify-center overflow-hidden rounded-[28px] shadow-lg shadow-emerald-950/20 ring-1 ring-white/20">
                        <?php if($profilePhotoUrl): ?>
                            <img src="<?php echo e($profilePhotoUrl); ?>" alt="<?php echo e(trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))); ?>" class="h-full w-full object-cover">
                        <?php else: ?>
                            <span class="premium-brand-title text-3xl font-semibold text-white">
                                <?php echo e($initials !== '' ? $initials : 'U'); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm uppercase tracking-[0.22em] text-white/65"><?php echo e(__('dashboard.premium_profile')); ?></p>
                        <h2 class="premium-page-title mt-3 text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">
                            <?php echo e(trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: __('profile.page_title')); ?>

                        </h2>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-white/80"><?php echo e($user->email); ?></p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="rounded-full bg-white/12 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-white">
                                <?php echo e(__('profile.account_number', ['number' => $user->id])); ?>

                            </span>
                            <span class="rounded-full bg-white/12 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-white">
                                <?php echo e($accountStatusLabel); ?>

                            </span>
                            <span class="rounded-full bg-white/12 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-white">
                                <?php echo e($currencyCode); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <p class="mt-6 max-w-3xl text-sm leading-6 text-white/78 sm:text-base">
                    <?php echo e(__('profile.page_subtitle')); ?>

                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div class="profile-stat-card rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('profile.current_balance')); ?></p>
                    <p class="profile-balance-value premium-kpi-number mt-2 font-semibold"><?php echo e($balanceFormatted); ?></p>
                </div>
                <div class="profile-stat-card rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.premium_profile')); ?></p>
                    <p class="profile-stat-value premium-kpi-number mt-2 font-semibold"><?php echo e($profileCompletion); ?>%</p>
                </div>
                <div class="profile-stat-card rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.operations_to_track')); ?></p>
                    <p class="profile-stat-value premium-kpi-number mt-2 font-semibold"><?php echo e($pendingOperationsCount); ?></p>
                </div>
                <div class="profile-stat-card rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.notifications')); ?></p>
                    <p class="profile-stat-value premium-kpi-number mt-2 font-semibold"><?php echo e($unreadNotificationsCount); ?></p>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.6fr)_minmax(320px,380px)]">
        <section class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-3 border-b border-slate-200/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('dashboard.instant_reading')); ?></p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('profile.personal_info_title')); ?></h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('profile.personal_info_subtitle')); ?></p>
                    </div>
                    <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                        <?php echo e($profileCompletion); ?>%
                    </span>
                </div>

                <div class="profile-info-grid mt-6 grid gap-4">
                    <?php $__currentLoopData = $profileInfoCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="profile-info-card min-w-0 rounded-[24px] p-4">
                            <div class="flex min-w-0 items-start gap-3">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl <?php echo e($card['tone']); ?>">
                                    <i class="fas <?php echo e($card['icon']); ?>"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e($card['label']); ?></p>
                                    <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950">
                                        <?php echo e($card['value']); ?>

                                    </p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>

            <section class="premium-panel premium-card-hover rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-3 border-b border-slate-200/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('dashboard.activity')); ?></p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('profile.recent_activity_title')); ?></h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('profile.recent_activity_subtitle')); ?></p>
                    </div>
                    <a href="<?php echo e(localized_route('transactions.history')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                        <?php echo e(__('profile.view_all')); ?>

                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="mt-6 space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $typeLabel = $transactionTypeLabels[$transaction->type] ?? ucfirst((string) $transaction->type);
                            $statusLabel = $transactionStatusLabels[$transaction->status] ?? ucfirst((string) $transaction->status);
                            $amountColor = match ($transaction->type) {
                                'deposit' => 'text-emerald-700',
                                'withdrawal' => 'text-rose-700',
                                'transfer' => 'text-orange-600',
                                default => 'text-slate-950',
                            };
                            $amountPrefix = $transaction->type === 'deposit' ? '+' : ($transaction->type === 'withdrawal' || $transaction->type === 'transfer' ? '-' : '');
                            $statusClass = match ($transaction->status) {
                                'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80',
                                'on_hold' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80',
                                'pending' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200/80',
                                'failed' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80',
                                default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                            };
                        ?>
                        <article class="profile-activity-item min-w-0 rounded-[24px] px-4 py-4">
                            <div class="flex min-w-0 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex min-w-0 items-start gap-3">
                                    <span class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl
                                        <?php if($transaction->type === 'deposit'): ?> bg-emerald-50 text-emerald-700
                                        <?php elseif($transaction->type === 'withdrawal'): ?> bg-rose-50 text-rose-700
                                        <?php else: ?> bg-orange-50 text-orange-600 <?php endif; ?>">
                                        <i class="fas fa-<?php if($transaction->type === 'deposit'): ?> arrow-down <?php elseif($transaction->type === 'withdrawal'): ?> arrow-up <?php else: ?> paper-plane <?php endif; ?>"></i>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-slate-950"><?php echo e($typeLabel); ?></p>
                                        <p class="mt-1 text-xs uppercase tracking-[0.14em] text-slate-400">
                                            <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?>

                                        </p>
                                        <?php if($transaction->recipient_name): ?>
                                            <p class="mt-2 text-sm text-slate-500"><?php echo e($transaction->recipient_name); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="min-w-0 sm:text-right">
                                    <p class="profile-info-value text-lg font-semibold <?php echo e($amountColor); ?>">
                                        <?php echo e($amountPrefix); ?><?php echo e(\App\Helpers\CurrencyHelper::format($transaction->amount, $currencyCode)); ?>

                                    </p>
                                    <span class="mt-2 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold <?php echo e($statusClass); ?>">
                                        <i class="fas fa-circle text-[8px]"></i>
                                        <?php echo e($statusLabel); ?>

                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="rounded-[24px] border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm ring-1 ring-slate-200">
                                <i class="fas fa-exchange-alt text-2xl"></i>
                            </div>
                            <h3 class="mt-5 text-lg font-semibold text-slate-950"><?php echo e(__('profile.no_transactions')); ?></h3>
                            <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('profile.no_transactions_message')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </section>

        <aside class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('profile.banking_info_title')); ?></p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('dashboard.client_priorities')); ?></h3>
                <div class="mt-5 space-y-4">
                    <div class="profile-side-card profile-stat-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.current_balance')); ?></p>
                        <p class="profile-balance-value premium-brand-title mt-2 font-semibold text-slate-950"><?php echo e($balanceFormatted); ?></p>
                        <p class="mt-2 text-sm text-slate-500"><?php echo e(__('profile.available_balance')); ?></p>
                    </div>

                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="profile-data-row flex flex-col gap-1 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.account_number_label')); ?></span>
                            <span class="profile-info-value text-sm font-semibold text-slate-950 sm:text-right"><?php echo e($user->id); ?></span>
                        </div>
                        <div class="profile-data-row flex flex-col gap-1 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.account_status_label')); ?></span>
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold <?php echo e($accountStatusBadgeClass); ?>">
                                <i class="fas fa-circle text-[8px]"></i>
                                <?php echo e($accountStatusLabel); ?>

                            </span>
                        </div>
                        <div class="profile-data-row flex flex-col gap-1 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.account_type_label')); ?></span>
                            <span class="profile-info-value text-sm font-semibold text-slate-950 sm:text-right"><?php echo e($accountTypeLabel); ?></span>
                        </div>
                        <div class="profile-data-row flex flex-col gap-1 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.signup_date_label')); ?></span>
                            <span class="profile-info-value text-sm font-semibold text-slate-950 sm:text-right"><?php echo e($user->created_at->format('d/m/Y')); ?></span>
                        </div>
                        <div class="flex flex-col gap-1 pt-3 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.default_currency')); ?></span>
                            <span class="profile-info-value text-sm font-semibold text-slate-950 sm:text-right"><?php echo e($currencyCode); ?></span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('profile.banking_details_title')); ?></p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('profile.banking_details_subtitle')); ?></h3>
                <div class="mt-5 space-y-4">
                    <div class="profile-side-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.iban')); ?></p>
                        <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950"><?php echo e($formattedIban); ?></p>
                    </div>
                    <div class="profile-side-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.bic')); ?></p>
                        <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950"><?php echo e($formattedBic); ?></p>
                    </div>
                </div>
            </section>

            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('profile.credit_card_title')); ?></p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('profile.credit_card_subtitle')); ?></h3>

                <?php if($user->creditCard): ?>
                    <div class="mt-5 space-y-4">
                        <div class="profile-side-card rounded-[24px] px-4 py-4">
                            <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.card_holder_name')); ?></p>
                            <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950"><?php echo e($user->creditCard->card_holder_name); ?></p>
                        </div>
                        <div class="profile-side-card rounded-[24px] px-4 py-4">
                            <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.card_number')); ?></p>
                            <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950"><?php echo e($user->creditCard->masked_card_number); ?></p>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="profile-side-card rounded-[24px] px-4 py-4">
                                <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.card_type')); ?></p>
                                <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950"><?php echo e($user->creditCard->card_type ?? __('profile.not_specified')); ?></p>
                            </div>
                            <div class="profile-side-card rounded-[24px] px-4 py-4">
                                <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.expiry_date')); ?></p>
                                <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950"><?php echo e($cardExpiry); ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-5 rounded-[24px] border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm leading-6 text-slate-500">
                        <?php echo e(__('profile.no_credit_card')); ?>

                    </div>
                <?php endif; ?>
            </section>

            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('profile.security_title')); ?></p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('profile.security_subtitle')); ?></h3>
                <div class="mt-5 space-y-4">
                    <div class="profile-side-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('profile.activation_code')); ?></p>
                        <p class="profile-info-value mt-2 text-sm font-semibold leading-6 text-slate-950"><?php echo e($maskedActivationCode); ?></p>
                    </div>
                    <div class="profile-side-card rounded-[24px] px-4 py-4">
                        <div class="profile-data-row flex flex-col gap-1 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.account_status_label')); ?></span>
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold <?php echo e($accountStatusBadgeClass); ?>">
                                <i class="fas fa-circle text-[8px]"></i>
                                <?php echo e($accountStatusLabel); ?>

                            </span>
                        </div>
                        <div class="profile-data-row flex flex-col gap-1 py-3 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.two_factor_label')); ?></span>
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold <?php echo e($user->two_factor_enabled ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80' : 'bg-slate-100 text-slate-700 ring-1 ring-slate-200'); ?>">
                                <i class="fas fa-shield-alt text-[11px]"></i>
                                <?php echo e($user->two_factor_enabled ? __('profile.two_factor_enabled') : __('profile.two_factor_disabled')); ?>

                            </span>
                        </div>
                        <div class="flex flex-col gap-2 pt-3 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-slate-500"><?php echo e(__('profile.configure_2fa')); ?></span>
                            <a href="<?php echo e(localized_route('twofactor.setup')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                                <?php echo e(__('profile.manage')); ?>

                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="premium-gradient-card rounded-[30px] p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-white/65"><?php echo e(__('profile.quick_actions_title')); ?></p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold"><?php echo e(__('profile.quick_actions_subtitle')); ?></h3>
                <div class="mt-5 space-y-3">
                    <a href="<?php echo e(localized_route('transfer.create')); ?>" class="inline-flex w-full items-center justify-between gap-3 rounded-[22px] bg-white/10 px-4 py-4 text-sm font-semibold text-white transition hover:bg-white/16">
                        <span class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/14">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <span><?php echo e(__('profile.new_transfer')); ?></span>
                        </span>
                        <i class="fas fa-arrow-right text-[11px]"></i>
                    </a>
                    <a href="<?php echo e(localized_route('transactions.history')); ?>" class="inline-flex w-full items-center justify-between gap-3 rounded-[22px] bg-white/10 px-4 py-4 text-sm font-semibold text-white transition hover:bg-white/16">
                        <span class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/14">
                                <i class="fas fa-clock-rotate-left"></i>
                            </span>
                            <span><?php echo e(__('profile.history')); ?></span>
                        </span>
                        <i class="fas fa-arrow-right text-[11px]"></i>
                    </a>
                    <a href="<?php echo e(localized_route('dashboard')); ?>" class="inline-flex w-full items-center justify-between gap-3 rounded-[22px] bg-white/10 px-4 py-4 text-sm font-semibold text-white transition hover:bg-white/16">
                        <span class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/14">
                                <i class="fas fa-chart-pie"></i>
                            </span>
                            <span><?php echo e(__('profile.back_to_dashboard')); ?></span>
                        </span>
                        <i class="fas fa-arrow-right text-[11px]"></i>
                    </a>
                </div>
            </section>
        </aside>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_overlays'); ?>
    <?php echo $__env->make('components.client-chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.premium-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\profile\index.blade.php ENDPATH**/ ?>