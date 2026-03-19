<?php $__env->startSection('title', __('dashboard.dashboard_title')); ?>
<?php $__env->startSection('dashboard_theme', 'client'); ?>
<?php $__env->startSection('dashboard_page_title', __('dashboard.dashboard_title')); ?>
<?php $__env->startSection('dashboard_page_subtitle', __('dashboard.page_subtitle')); ?>
<?php $__env->startSection('dashboard_section_label', __('dashboard.client_area')); ?>
<?php $__env->startSection('dashboard_search_placeholder', __('dashboard.search_placeholder')); ?>
<?php $__env->startSection('dashboard_brand_title', 'Valtrix Bank'); ?>
<?php $__env->startSection('dashboard_brand_subtitle', __('dashboard.client_area')); ?>
<?php $__env->startSection('sidebar_primary_title', __('dashboard.menu')); ?>

<?php $__env->startSection('sidebar_primary'); ?>
    <a href="<?php echo e(localized_route('dashboard')); ?>" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm ring-1 ring-slate-200">
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
    <a href="<?php echo e(localized_route('profile')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70">
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
            <div class="mt-5 flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.profile')); ?></p>
                    <p class="text-lg font-semibold"><?php echo e($profileCompletion); ?>%</p>
                </div>
                <a href="<?php echo e(localized_route('profile')); ?>" class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-2 text-xs font-semibold text-slate-900">
                    <?php echo e(__('dashboard.complete')); ?>

                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
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
        <?php echo e(__('dashboard.new_transfer')); ?>

    </a>
    <a href="<?php echo e(localized_route('transactions.history')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-list-ul text-xs"></i>
        <?php echo e(__('dashboard.view_all')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_content'); ?>
    <?php
        $balanceFormatted = \App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR');
        $incomingFormatted = \App\Helpers\CurrencyHelper::format($incomingLast30Days, $user->default_currency ?? 'EUR');
        $outgoingFormatted = \App\Helpers\CurrencyHelper::format($outgoingLast30Days, $user->default_currency ?? 'EUR');
        $transactionTypeKeys = [
            'transfer' => 'type_transfer',
            'deposit' => 'type_deposit',
            'withdrawal' => 'type_withdrawal',
        ];
        $transactionStatusKeys = [
            'pending' => 'status_pending',
            'on_hold' => 'status_on_hold',
            'success' => 'status_success',
            'failed' => 'status_failed',
            'refunded' => 'status_refunded',
        ];
        $translateTransactionType = function ($type) use ($transactionTypeKeys) {
            $key = $transactionTypeKeys[$type] ?? null;

            return $key ? __('transactions.' . $key) : ucfirst(str_replace('_', ' ', (string) $type));
        };
        $translateTransactionStatus = function ($status) use ($transactionStatusKeys) {
            $key = $transactionStatusKeys[$status] ?? null;

            return $key ? __('transactions.' . $key) : ucfirst(str_replace('_', ' ', (string) $status));
        };
        $accountStatusKey = 'profile.account_statuses.' . $user->status;
        $accountStatusLabel = __($accountStatusKey);
        if ($accountStatusLabel === $accountStatusKey) {
            $accountStatusLabel = ucfirst((string) $user->status);
        }
        $latestTransactionLabel = $latestTransaction
            ? $translateTransactionType($latestTransaction->type) . ' #' . $latestTransaction->id
            : __('dashboard.no_recent_operation');
        $cardLabel = $user->creditCard?->masked_card_number ?? __('dashboard.empty_value');
        $cardExpiry = $user->creditCard?->expiry_date?->format('m/y');
    ?>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.7fr)_minmax(300px,360px)]">
        <section class="premium-gradient-card premium-grid-glow premium-card-hover relative min-w-0 overflow-hidden rounded-[30px] p-6 sm:p-7">
            <div class="relative z-10">
                <div class="flex min-w-0 flex-col gap-6 lg:items-start 2xl:flex-row 2xl:justify-between">
                    <div class="min-w-0 max-w-2xl">
                        <p class="text-sm uppercase tracking-[0.22em] text-white/65"><?php echo e(__('dashboard.immediate_summary')); ?></p>
                        <h2 class="mt-4 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">
                            <?php echo e($balanceFormatted); ?>

                        </h2>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-white/78">
                            <?php echo e(__('dashboard.hero_summary')); ?>

                        </p>
                    </div>

                    <div class="grid w-full gap-3 sm:grid-cols-2 2xl:max-w-[340px]">
                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.primary_card')); ?></p>
                            <p class="mt-2 text-lg font-semibold"><?php echo e($cardLabel); ?></p>
                            <p class="mt-1 text-xs text-white/70">
                                <?php echo e($cardExpiry ? __('dashboard.expires', ['date' => $cardExpiry]) : __('dashboard.virtual_card_active')); ?>

                            </p>
                        </div>
                        <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.latest_operation')); ?></p>
                            <p class="mt-2 text-lg font-semibold"><?php echo e($latestTransactionLabel); ?></p>
                            <p class="mt-1 text-xs text-white/70">
                                <?php echo e($latestTransaction?->created_at?->format('d/m/Y H:i') ?? __('dashboard.no_recorded_movement')); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-3">
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.incoming_30_days')); ?></p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($incomingFormatted); ?></p>
                    </div>
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.outgoing_30_days')); ?></p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($outgoingFormatted); ?></p>
                    </div>
                    <div class="min-w-0 rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('dashboard.transfer_success')); ?></p>
                        <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($transferSuccessRate); ?>%</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('dashboard.daily_focus')); ?></p>
                    <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('dashboard.client_priorities')); ?></h2>
                </div>
                <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                    <?php echo e(__('dashboard.real_time')); ?>

                </span>
            </div>

            <div class="mt-5 space-y-4">
                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.unread_notifications')); ?></p>
                            <p class="mt-1 text-sm text-slate-500"><?php echo e(__('dashboard.unread_notifications_description')); ?></p>
                        </div>
                        <span class="premium-brand-title text-3xl font-semibold text-slate-900"><?php echo e($unreadNotificationsCount); ?></span>
                    </div>
                </div>

                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.operations_to_track')); ?></p>
                            <p class="mt-1 text-sm text-slate-500"><?php echo e(__('dashboard.operations_to_track_description')); ?></p>
                        </div>
                        <span class="premium-brand-title text-3xl font-semibold text-slate-900"><?php echo e($pendingOperationsCount); ?></span>
                    </div>
                </div>

                <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.premium_profile')); ?></p>
                            <p class="mt-1 text-sm text-slate-500"><?php echo e(__('dashboard.premium_profile_description')); ?></p>
                        </div>
                        <span class="premium-brand-title text-3xl font-semibold text-slate-900"><?php echo e($profileCompletion); ?>%</span>
                    </div>
                    <div class="mt-3 h-2.5 rounded-full bg-slate-200">
                        <div class="h-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-700" style="width: <?php echo e($profileCompletion); ?>%"></div>
                    </div>
                </div>

                <a href="<?php echo e(localized_route('support.nous-contacter')); ?>" class="premium-gradient-card block rounded-[24px] p-4">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/65"><?php echo e(__('dashboard.direct_support')); ?></p>
                    <h3 class="mt-2 text-lg font-semibold"><?php echo e(__('dashboard.support_immediate_title')); ?></h3>
                    <p class="mt-2 text-sm text-white/78"><?php echo e(__('dashboard.support_immediate_description')); ?></p>
                </a>
            </div>
        </section>
    </div>

    <section class="grid gap-4 md:grid-cols-2 2xl:grid-cols-4">
        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.current_balance')); ?></span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fas fa-wallet"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($balanceFormatted); ?></p>
            <p class="mt-2 text-sm text-slate-500"><?php echo e(__('dashboard.updated_today')); ?></p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.incoming_flows')); ?></span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                    <i class="fas fa-arrow-down"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($incomingFormatted); ?></p>
            <p class="mt-2 text-sm text-slate-500"><?php echo e(__('dashboard.incoming_flows_description')); ?></p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.outgoing_flows')); ?></span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-700">
                    <i class="fas fa-arrow-up"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($outgoingFormatted); ?></p>
            <p class="mt-2 text-sm text-slate-500"><?php echo e(__('dashboard.outgoing_flows_description')); ?></p>
        </article>

        <article class="premium-panel premium-card-hover min-w-0 rounded-[26px] p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.account')); ?></span>
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                    <i class="fas fa-shield-check"></i>
                </span>
            </div>
            <p class="premium-kpi-number mt-4 text-3xl font-semibold text-slate-950"><?php echo e($accountStatusLabel); ?></p>
            <p class="mt-2 text-sm text-slate-500"><?php echo e(__('dashboard.verified_account')); ?></p>
        </article>
    </section>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.65fr)_minmax(300px,360px)]">
        <section class="min-w-0">
            <?php echo $__env->make('components.analytics-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </section>

        <div class="min-w-0 space-y-6">
            <section class="premium-panel premium-card-hover min-w-0 rounded-[28px] p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400"><?php echo e(__('dashboard.quick_pilot')); ?></p>
                        <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950"><?php echo e(__('dashboard.smart_actions')); ?></h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500"><?php echo e(__('dashboard.flash')); ?></span>
                </div>

                <div class="mt-5 space-y-3">
                    <a href="<?php echo e(localized_route('transfer.create')); ?>" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.new_transfer')); ?></p>
                                <p class="text-sm text-slate-500"><?php echo e(__('dashboard.send_payment')); ?></p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="<?php echo e(localized_route('notifications.index')); ?>" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <i class="fas fa-bell"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.notification_center')); ?></p>
                                <p class="text-sm text-slate-500"><?php echo e(__('dashboard.notification_center_description', ['count' => $unreadNotificationsCount])); ?></p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>

                    <a href="<?php echo e(localized_route('profile')); ?>" class="flex items-center justify-between gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                <i class="fas fa-user-gear"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.my_profile')); ?></p>
                                <p class="text-sm text-slate-500"><?php echo e(__('dashboard.profile_completion_short', ['percent' => $profileCompletion])); ?></p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-slate-300"></i>
                    </a>
                </div>
            </section>

            <section class="premium-panel premium-card-hover min-w-0 rounded-[28px] p-3">
                <?php echo $__env->make('components.market-tracker-fixed', ['compact' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </section>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2 2xl:grid-cols-[minmax(0,1.45fr)_minmax(0,1fr)]">
        <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400"><?php echo e(__('dashboard.activity')); ?></p>
                    <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950"><?php echo e(__('dashboard.recent_transactions')); ?></h2>
                </div>
                <a href="<?php echo e(localized_route('transactions.history')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <?php echo e(__('dashboard.view_all')); ?>

                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="mt-6 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isPositive = $transaction->type === 'deposit';
                        $transactionColor = $isPositive ? 'emerald' : ($transaction->status === 'on_hold' ? 'amber' : 'slate');
                        $transactionTypeLabel = $translateTransactionType($transaction->type);
                        $transactionStatusLabel = $translateTransactionStatus($transaction->status);
                    ?>
                    <div class="flex flex-col gap-3 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-<?php echo e($transactionColor); ?>-50 text-<?php echo e($transactionColor); ?>-700">
                                <i class="fas <?php echo e($isPositive ? 'fa-arrow-down' : 'fa-arrow-up'); ?>"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">
                                    <?php echo e($transactionTypeLabel); ?>

                                    <span class="ml-2 text-xs font-medium uppercase tracking-[0.16em] text-slate-400">#<?php echo e($transaction->id); ?></span>
                                </p>
                                <p class="mt-1 truncate text-sm text-slate-500">
                                    <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?>

                                    <?php if($transaction->recipient_name): ?>
                                        | <?php echo e($transaction->recipient_name); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <div class="text-left sm:text-right">
                            <p class="text-sm font-semibold <?php echo e($isPositive ? 'text-emerald-700' : 'text-slate-900'); ?>">
                                <?php echo e(\App\Helpers\CurrencyHelper::format($transaction->amount, $user->default_currency ?? 'EUR')); ?>

                            </p>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">
                                <?php echo e($transactionStatusLabel); ?>

                            </p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="rounded-[24px] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center">
                        <p class="text-lg font-semibold text-slate-900"><?php echo e(__('dashboard.no_recent_transactions')); ?></p>
                        <p class="mt-2 text-sm text-slate-500"><?php echo e(__('dashboard.no_recent_transactions_description')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <div class="min-w-0 space-y-6">
            <section class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400"><?php echo e(__('dashboard.experience')); ?></p>
                        <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950"><?php echo e(__('dashboard.premium_journey')); ?></h2>
                    </div>
                    <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold"><?php echo e(__('dashboard.guidance')); ?></span>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <i class="fas fa-shield-heart"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.secure_area')); ?></p>
                                <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('dashboard.secure_area_description')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <i class="fas fa-wave-square"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.instant_reading')); ?></p>
                                <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('dashboard.instant_reading_description')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                <i class="fas fa-headset"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900"><?php echo e(__('dashboard.support_close')); ?></p>
                                <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('dashboard.support_close_description')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="premium-gradient-card min-w-0 rounded-[30px] p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65"><?php echo e(__('dashboard.priority_channel')); ?></p>
                <h2 class="premium-brand-title mt-3 text-2xl font-semibold"><?php echo e(__('dashboard.banking_assistance')); ?></h2>
                <p class="mt-3 text-sm leading-6 text-white/78">
                    <?php echo e(__('dashboard.banking_assistance_description')); ?>

                </p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <button type="button" onclick="toggleClientChat()" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-slate-900">
                        <i class="fas fa-comments text-xs"></i>
                        <?php echo e(__('dashboard.open_chat')); ?>

                    </button>
                    <a href="<?php echo e(localized_route('support.nous-contacter')); ?>" class="inline-flex items-center gap-2 rounded-full border border-white/30 px-4 py-2.5 text-sm font-semibold text-white">
                        <?php echo e(__('home.footer_contact_us')); ?>

                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_overlays'); ?>
    <?php echo $__env->make('components.client-chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.premium-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views/dashboard/index.blade.php ENDPATH**/ ?>