<?php
    $historyTotal = $historySummary['total'] ?? $transactions->total();
    $historySuccess = $historySummary['success'] ?? 0;
    $historyPending = $historySummary['pending'] ?? 0;
    $historyVolume = \App\Helpers\CurrencyHelper::format($historySummary['volume'] ?? 0, $user->default_currency ?? 'EUR');
    $activeFiltersCount = collect(request()->only(['type', 'status', 'date_from', 'date_to']))->filter()->count();
    $statusMap = [
        'pending' => 'status_pending',
        'on_hold' => 'status_on_hold',
        'success' => 'status_success',
        'failed' => 'status_failed',
        'refunded' => 'status_refunded',
    ];
    $typeMap = [
        'transfer' => 'type_transfer',
        'deposit' => 'type_deposit',
        'withdrawal' => 'type_withdrawal',
    ];
?>

<?php $__env->startSection('title', __('transactions.history_page_title')); ?>
<?php $__env->startSection('dashboard_theme', 'client'); ?>
<?php $__env->startSection('dashboard_page_title', __('transactions.history_title')); ?>
<?php $__env->startSection('dashboard_page_subtitle', __('transactions.history_subtitle')); ?>
<?php $__env->startSection('dashboard_section_label', __('dashboard.activity')); ?>
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
    <a href="<?php echo e(localized_route('transactions.history')); ?>" class="premium-nav-item is-active flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-900">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm ring-1 ring-emerald-200/80">
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
    <a href="<?php echo e(localized_route('dashboard')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-chart-pie text-xs"></i>
        <?php echo e(__('dashboard.dashboard_title')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('premium_dashboard_head'); ?>
    <style>
        .history-field {
            background: rgba(248, 250, 252, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.24);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72);
            transition: border-color 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
        }

        .history-field:focus {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(22, 124, 91, 0.38);
            box-shadow: 0 0 0 4px rgba(22, 124, 91, 0.1);
            outline: none;
        }

        .history-summary-card {
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 250, 252, 0.88));
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
        }

        .history-table-row {
            transition: background-color 180ms ease, transform 180ms ease;
        }

        .history-table-row:hover {
            background: rgba(248, 250, 252, 0.88);
        }

        .history-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 9999px;
            padding: 0.45rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .history-progress-track {
            height: 0.45rem;
            overflow: hidden;
            border-radius: 9999px;
            background: rgba(226, 232, 240, 0.95);
        }

        .history-progress-fill {
            height: 100%;
            border-radius: inherit;
            transition: width 220ms ease;
        }

        .history-mobile-card {
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(248, 250, 252, 0.92));
            box-shadow: 0 18px 32px rgba(15, 23, 42, 0.06);
        }

        .history-mobile-meta {
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: rgba(248, 250, 252, 0.92);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('dashboard_content'); ?>
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 flex flex-col gap-6 2xl:flex-row 2xl:items-end 2xl:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-[0.22em] text-white/65"><?php echo e(__('dashboard.immediate_summary')); ?></p>
                <h2 class="mt-4 premium-page-title text-3xl font-semibold tracking-[-0.05em] sm:text-4xl">
                    <?php echo e(__('transactions.history_title')); ?>

                </h2>
                <p class="mt-3 text-sm leading-6 text-white/78 sm:text-base">
                    <?php echo e(__('transactions.history_overview')); ?>

                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 2xl:grid-cols-4 2xl:min-w-[720px]">
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('transactions.table_transaction')); ?></p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($historyTotal); ?></p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('transactions.status_success')); ?></p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($historySuccess); ?></p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('transactions.status_pending')); ?></p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($historyPending); ?></p>
                </div>
                <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/60"><?php echo e(__('transactions.table_amount')); ?></p>
                    <p class="premium-kpi-number mt-2 text-2xl font-semibold"><?php echo e($historyVolume); ?></p>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.6fr)_minmax(320px,380px)]">
        <section class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5 sm:p-6">
                <div class="flex flex-col gap-3 border-b border-slate-200/70 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('dashboard.real_time')); ?></p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('transactions.filter_apply')); ?></h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('transactions.history_subtitle')); ?></p>
                    </div>
                    <?php if($activeFiltersCount > 0): ?>
                        <a href="<?php echo e(localized_route('transactions.history')); ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 sm:w-auto">
                            <i class="fas fa-rotate-left text-xs"></i>
                            <?php echo e(__('transactions.reset_filters')); ?>

                        </a>
                    <?php endif; ?>
                </div>

                <form method="GET" class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                    <div>
                        <label for="type" class="mb-3 block text-sm font-semibold text-slate-800"><?php echo e(__('transactions.filter_type')); ?></label>
                        <select name="type" id="type" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                            <option value=""><?php echo e(__('transactions.all_types')); ?></option>
                            <option value="transfer" <?php echo e(request('type') == 'transfer' ? 'selected' : ''); ?>><?php echo e(__('transactions.type_transfer')); ?></option>
                            <option value="deposit" <?php echo e(request('type') == 'deposit' ? 'selected' : ''); ?>><?php echo e(__('transactions.type_deposit')); ?></option>
                            <option value="withdrawal" <?php echo e(request('type') == 'withdrawal' ? 'selected' : ''); ?>><?php echo e(__('transactions.type_withdrawal')); ?></option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="mb-3 block text-sm font-semibold text-slate-800"><?php echo e(__('transactions.filter_status')); ?></label>
                        <select name="status" id="status" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                            <option value=""><?php echo e(__('transactions.all_statuses')); ?></option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('transactions.status_pending')); ?></option>
                            <option value="on_hold" <?php echo e(request('status') == 'on_hold' ? 'selected' : ''); ?>><?php echo e(__('transactions.status_on_hold')); ?></option>
                            <option value="success" <?php echo e(request('status') == 'success' ? 'selected' : ''); ?>><?php echo e(__('transactions.status_success')); ?></option>
                            <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>><?php echo e(__('transactions.status_failed')); ?></option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="mb-3 block text-sm font-semibold text-slate-800"><?php echo e(__('transactions.filter_date_from')); ?></label>
                        <input type="date" name="date_from" id="date_from" value="<?php echo e(request('date_from')); ?>" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                    </div>

                    <div>
                        <label for="date_to" class="mb-3 block text-sm font-semibold text-slate-800"><?php echo e(__('transactions.filter_date_to')); ?></label>
                        <input type="date" name="date_to" id="date_to" value="<?php echo e(request('date_to')); ?>" class="history-field block w-full rounded-2xl px-4 py-3.5 text-sm text-slate-900">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            <i class="fas fa-filter text-xs"></i>
                            <?php echo e(__('transactions.filter_apply')); ?>

                        </button>
                    </div>
                </form>
            </section>

            <section class="premium-panel premium-card-hover overflow-hidden rounded-[30px]">
                <div class="flex flex-col gap-4 border-b border-slate-200/70 px-5 py-5 sm:px-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('dashboard.activity')); ?></p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('transactions.history_overview')); ?></h2>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                        <?php if($activeFiltersCount > 0): ?>
                            <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                                <?php echo e($activeFiltersCount); ?> <?php echo e(__('transactions.filter_type')); ?>

                            </span>
                        <?php endif; ?>

                        <?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(localized_route('admin.export.pdf')); ?>" class="history-export-link inline-flex w-full items-center justify-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100 sm:w-auto">
                                <i class="fas fa-file-pdf text-xs"></i>
                                <?php echo e(__('transactions.export_pdf')); ?>

                            </a>
                            <a href="<?php echo e(localized_route('admin.export.excel')); ?>" class="history-export-link inline-flex w-full items-center justify-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100 sm:w-auto">
                                <i class="fas fa-file-excel text-xs"></i>
                                <?php echo e(__('transactions.export_excel')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="space-y-4 px-4 py-4 sm:hidden">
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $typeKey = $typeMap[$transaction->type] ?? null;
                            $typeLabel = $typeKey ? __('transactions.' . $typeKey) : ucfirst($transaction->type);
                            $statusKey = $statusMap[$transaction->status] ?? null;
                            $statusLabel = $statusKey ? __('transactions.' . $statusKey) : ucfirst(str_replace('_', ' ', $transaction->status));
                            $statusClass = match ($transaction->status) {
                                'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80',
                                'on_hold' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80',
                                'pending' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200/80',
                                'failed', 'refunded' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80',
                                default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                            };
                            $progressClass = match (true) {
                                $transaction->progress >= 100 => 'bg-emerald-500',
                                $transaction->progress >= 70 => 'bg-sky-500',
                                $transaction->progress >= 30 => 'bg-amber-500',
                                default => 'bg-rose-500',
                            };
                            $typeIconShellClass = match ($transaction->type) {
                                'transfer' => 'bg-sky-50 text-sky-700',
                                'deposit' => 'bg-emerald-50 text-emerald-700',
                                default => 'bg-rose-50 text-rose-700',
                            };
                            $typeIcon = match ($transaction->type) {
                                'transfer' => 'paper-plane',
                                'deposit' => 'arrow-down',
                                default => 'arrow-up',
                            };
                            $amountClass = match ($transaction->type) {
                                'deposit' => 'text-emerald-700',
                                'withdrawal' => 'text-rose-700',
                                default => 'text-slate-950',
                            };
                            $formattedAmount = \App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR');
                            $recipientName = $transaction->recipient_name ?? __('transactions.not_available');
                        ?>
                        <article class="history-mobile-card rounded-[28px] p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl <?php echo e($typeIconShellClass); ?>">
                                        <i class="fas fa-<?php echo e($typeIcon); ?>"></i>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('transactions.table_transaction')); ?></p>
                                        <h3 class="mt-1 truncate text-base font-semibold text-slate-950"><?php echo e($typeLabel); ?></h3>
                                        <p class="text-xs text-slate-500">#<?php echo e($transaction->id); ?></p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('transactions.table_amount')); ?></p>
                                    <p class="mt-1 text-base font-semibold <?php echo e($amountClass); ?>"><?php echo e($formattedAmount); ?></p>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <span class="history-status-badge <?php echo e($statusClass); ?>">
                                    <i class="fas fa-<?php if($transaction->status === 'success'): ?> check-circle <?php elseif($transaction->status === 'on_hold'): ?> clock <?php elseif($transaction->status === 'pending'): ?> hourglass-half <?php else: ?> ban <?php endif; ?>"></i>
                                    <?php echo e($statusLabel); ?>

                                </span>
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-slate-200/80">
                                    <i class="fas fa-calendar-days text-[10px]"></i>
                                    <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?>

                                </span>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div class="history-mobile-meta rounded-[22px] px-4 py-3">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('transactions.table_beneficiary')); ?></p>
                                    <p class="mt-1 text-sm font-semibold text-slate-900"><?php echo e($recipientName); ?></p>
                                    <?php if($transaction->recipient_iban): ?>
                                        <p class="mt-1 text-xs text-slate-500"><?php echo e(substr($transaction->recipient_iban, 0, 4)); ?>...<?php echo e(substr($transaction->recipient_iban, -4)); ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="history-mobile-meta rounded-[22px] px-4 py-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('transactions.table_progress')); ?></p>
                                        <p class="text-xs font-semibold text-slate-500"><?php echo e($transaction->progress); ?>%</p>
                                    </div>
                                    <div class="mt-3 history-progress-track w-full">
                                        <div class="history-progress-fill <?php echo e($progressClass); ?>" style="width: <?php echo e($transaction->progress); ?>%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <?php if($transaction->status === 'success' && in_array($transaction->type, ['transfer', 'deposit'])): ?>
                                    <a href="<?php echo e(localized_route('transactions.receipt', $transaction)); ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3 py-3 text-sm font-semibold text-sky-700 transition hover:border-sky-300 hover:bg-sky-100">
                                        <i class="fas fa-download text-[10px]"></i>
                                        <?php echo e(__('transactions.action_receipt')); ?>

                                    </a>
                                <?php endif; ?>
                                <?php if($transaction->status === 'on_hold'): ?>
                                    <span class="inline-flex w-full items-center justify-center gap-2 rounded-[18px] border border-amber-200 bg-amber-50 px-3 py-3 text-center text-sm font-semibold text-amber-700">
                                        <i class="fas fa-triangle-exclamation text-[10px]"></i>
                                        <?php echo e($transaction->message); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-2 py-10 text-center">
                            <div class="mx-auto max-w-md rounded-[28px] border border-slate-200 bg-white px-5 py-10 shadow-sm">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <i class="fas fa-exchange-alt text-2xl"></i>
                                </div>
                                <h3 class="mt-5 text-lg font-semibold text-slate-950"><?php echo e(__('transactions.no_transactions')); ?></h3>
                                <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('transactions.no_transactions_message')); ?></p>
                                <a href="<?php echo e(localized_route('transactions.history')); ?>" class="mt-5 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                                    <i class="fas fa-rotate-left text-xs"></i>
                                    <?php echo e(__('transactions.reset_filters')); ?>

                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="premium-scroll hidden overflow-x-auto sm:block">
                    <table class="min-w-[980px] w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50/85">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_transaction')); ?></th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_type')); ?></th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_amount')); ?></th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_beneficiary')); ?></th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_status')); ?></th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_progress')); ?></th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_date')); ?></th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e(__('transactions.table_actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80 bg-white">
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $typeKey = $typeMap[$transaction->type] ?? null;
                                    $typeLabel = $typeKey ? __('transactions.' . $typeKey) : ucfirst($transaction->type);
                                    $statusKey = $statusMap[$transaction->status] ?? null;
                                    $statusLabel = $statusKey ? __('transactions.' . $statusKey) : ucfirst(str_replace('_', ' ', $transaction->status));
                                    $statusClass = match ($transaction->status) {
                                        'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80',
                                        'on_hold' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80',
                                        'pending' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200/80',
                                        'failed', 'refunded' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80',
                                        default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                                    };
                                    $progressClass = match (true) {
                                        $transaction->progress >= 100 => 'bg-emerald-500',
                                        $transaction->progress >= 70 => 'bg-sky-500',
                                        $transaction->progress >= 30 => 'bg-amber-500',
                                        default => 'bg-rose-500',
                                    };
                                ?>
                                <tr class="history-table-row">
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold text-slate-950">#<?php echo e($transaction->id); ?></div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl
                                                <?php if($transaction->type === 'transfer'): ?> bg-sky-50 text-sky-700
                                                <?php elseif($transaction->type === 'deposit'): ?> bg-emerald-50 text-emerald-700
                                                <?php else: ?> bg-rose-50 text-rose-700 <?php endif; ?>">
                                                <i class="fas fa-<?php if($transaction->type === 'transfer'): ?> paper-plane <?php elseif($transaction->type === 'deposit'): ?> arrow-down <?php else: ?> arrow-up <?php endif; ?>"></i>
                                            </span>
                                            <span class="font-semibold text-slate-900"><?php echo e($typeLabel); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold <?php if($transaction->type === 'deposit'): ?> text-emerald-700 <?php elseif($transaction->type === 'withdrawal'): ?> text-rose-700 <?php else: ?> text-slate-950 <?php endif; ?>">
                                            <?php echo e(\App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR')); ?>

                                        </div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold text-slate-900">
                                            <?php echo e($transaction->recipient_name ?? __('transactions.not_available')); ?>

                                        </div>
                                        <?php if($transaction->recipient_iban): ?>
                                            <div class="mt-1 text-xs text-slate-500">
                                                <?php echo e(substr($transaction->recipient_iban, 0, 4)); ?>...<?php echo e(substr($transaction->recipient_iban, -4)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <span class="history-status-badge <?php echo e($statusClass); ?>">
                                            <i class="fas fa-<?php if($transaction->status === 'success'): ?> check-circle <?php elseif($transaction->status === 'on_hold'): ?> clock <?php elseif($transaction->status === 'pending'): ?> hourglass-half <?php else: ?> ban <?php endif; ?>"></i>
                                            <?php echo e($statusLabel); ?>

                                        </span>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="history-progress-track w-full">
                                            <div class="history-progress-fill <?php echo e($progressClass); ?>" style="width: <?php echo e($transaction->progress); ?>%"></div>
                                        </div>
                                        <div class="mt-2 text-xs font-semibold text-slate-500"><?php echo e($transaction->progress); ?>%</div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-semibold text-slate-900"><?php echo e($transaction->created_at->format('d/m/Y')); ?></div>
                                        <div class="mt-1 text-xs text-slate-500"><?php echo e($transaction->created_at->format('H:i')); ?></div>
                                    </td>
                                    <td class="px-5 py-4 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <?php if($transaction->status === 'success' && in_array($transaction->type, ['transfer', 'deposit'])): ?>
                                                <a href="<?php echo e(localized_route('transactions.receipt', $transaction)); ?>" class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:border-sky-300 hover:bg-sky-100" title="<?php echo e(__('transactions.action_download_receipt')); ?>">
                                                    <i class="fas fa-download text-[10px]"></i>
                                                    <?php echo e(__('transactions.action_receipt')); ?>

                                                </a>
                                            <?php endif; ?>
                                            <?php if($transaction->status === 'on_hold'): ?>
                                                <span class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700">
                                                    <i class="fas fa-triangle-exclamation text-[10px]"></i>
                                                    <?php echo e($transaction->message); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="px-5 py-14 text-center">
                                        <div class="mx-auto max-w-md">
                                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                                <i class="fas fa-exchange-alt text-2xl"></i>
                                            </div>
                                            <h3 class="mt-5 text-lg font-semibold text-slate-950"><?php echo e(__('transactions.no_transactions')); ?></h3>
                                            <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('transactions.no_transactions_message')); ?></p>
                                            <a href="<?php echo e(localized_route('transactions.history')); ?>" class="mt-5 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                                                <i class="fas fa-rotate-left text-xs"></i>
                                                <?php echo e(__('transactions.reset_filters')); ?>

                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($transactions->hasPages()): ?>
                    <div class="flex flex-col items-center gap-4 border-t border-slate-200/70 px-5 py-5 text-center sm:px-6 sm:text-left lg:flex-row lg:items-center lg:justify-between">
                        <div class="text-sm text-slate-600">
                            <?php echo e(__('transactions.showing_results', ['first' => $transactions->firstItem(), 'last' => $transactions->lastItem(), 'total' => $transactions->total()])); ?>

                        </div>
                        <div class="w-full overflow-x-auto lg:w-auto">
                            <?php echo e($transactions->links('vendor.pagination.tailwind')); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </section>

        <aside class="space-y-6">
            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('dashboard.instant_reading')); ?></p>
                        <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('transactions.filter_status')); ?></h2>
                    </div>
                    <span class="premium-soft-chip rounded-full px-3 py-1 text-xs font-semibold">
                        <?php echo e($activeFiltersCount); ?>

                    </span>
                </div>

                <div class="mt-5 space-y-3">
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('transactions.filter_type')); ?></p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">
                            <?php echo e(request('type') ? __('transactions.' . ($typeMap[request('type')] ?? 'all_types')) : __('transactions.all_types')); ?>

                        </p>
                    </div>
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('transactions.filter_status')); ?></p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">
                            <?php echo e(request('status') ? __('transactions.' . ($statusMap[request('status')] ?? 'all_statuses')) : __('transactions.all_statuses')); ?>

                        </p>
                    </div>
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('transactions.table_date')); ?></p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">
                            <?php echo e(request('date_from') ?: __('transactions.not_available')); ?> - <?php echo e(request('date_to') ?: __('transactions.not_available')); ?>

                        </p>
                    </div>
                </div>
            </section>

            <?php if(auth()->user()->isAdmin()): ?>
                <section class="premium-gradient-card rounded-[30px] p-5">
                    <p class="text-xs uppercase tracking-[0.18em] text-white/65"><?php echo e(__('dashboard.priority_channel')); ?></p>
                    <h3 class="mt-2 premium-brand-title text-2xl font-semibold"><?php echo e(__('transactions.table_actions')); ?></h3>
                    <p class="mt-3 text-sm leading-6 text-white/78"><?php echo e(__('transactions.history_overview')); ?></p>
                    <div class="mt-5 space-y-3">
                        <a href="<?php echo e(localized_route('admin.export.pdf')); ?>" class="history-export-link inline-flex w-full items-center justify-center gap-2 rounded-full bg-white/90 px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-white">
                            <i class="fas fa-file-pdf text-xs"></i>
                            <?php echo e(__('transactions.export_pdf')); ?>

                        </a>
                        <a href="<?php echo e(localized_route('admin.export.excel')); ?>" class="history-export-link inline-flex w-full items-center justify-center gap-2 rounded-full border border-white/30 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            <i class="fas fa-file-excel text-xs"></i>
                            <?php echo e(__('transactions.export_excel')); ?>

                        </a>
                    </div>
                </section>
            <?php endif; ?>

            <section class="premium-panel premium-card-hover rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"><?php echo e(__('dashboard.operations_to_track')); ?></p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('dashboard.client_priorities')); ?></h3>
                <div class="mt-5 space-y-3">
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.operations_to_track')); ?></p>
                        <p class="premium-brand-title mt-2 text-3xl font-semibold text-slate-950"><?php echo e($pendingOperationsCount); ?></p>
                    </div>
                    <div class="history-summary-card rounded-[24px] px-4 py-4">
                        <p class="text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.notifications')); ?></p>
                        <p class="premium-brand-title mt-2 text-3xl font-semibold text-slate-950"><?php echo e($unreadNotificationsCount); ?></p>
                    </div>
                    <a href="<?php echo e(localized_route('support.nous-contacter')); ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                        <i class="fas fa-headset text-xs"></i>
                        <?php echo e(__('dashboard.support')); ?>

                    </a>
                </div>
            </section>
        </aside>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_overlays'); ?>
    <?php echo $__env->make('components.client-chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('premium_dashboard_scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const statusSelect = document.getElementById('status');
            const dateFrom = document.getElementById('date_from');
            const dateTo = document.getElementById('date_to');

            if (typeSelect) {
                typeSelect.addEventListener('change', function () {
                    this.form.submit();
                });
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', function () {
                    this.form.submit();
                });
            }

            function submitDateFilter() {
                if (dateFrom && dateTo && dateFrom.value && dateTo.value) {
                    dateFrom.form.submit();
                }
            }

            if (dateFrom) {
                dateFrom.addEventListener('change', submitDateFilter);
            }

            if (dateTo) {
                dateTo.addEventListener('change', submitDateFilter);
            }

            document.querySelectorAll('.history-export-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i><?php echo e(__('transactions.generating')); ?>';

                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 3000);
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.premium-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\transactions\history.blade.php ENDPATH**/ ?>