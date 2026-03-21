<?php
    $depositVolume30DaysFormatted = \App\Helpers\CurrencyHelper::format($depositVolume30Days ?? 0, 'EUR');
?>

<?php $__env->startSection('title', 'Depot manuel - Valtrix Bank Admin'); ?>
<?php $__env->startSection('admin_nav_active', 'deposit'); ?>
<?php $__env->startSection('dashboard_page_title', 'Depot manuel'); ?>
<?php $__env->startSection('dashboard_page_subtitle', 'Creditez un compte client depuis une interface premium, avec apercu instantane et verification avant execution.'); ?>
<?php $__env->startSection('dashboard_section_label', 'Credit operations'); ?>

<?php $__env->startSection('dashboard_header_actions'); ?>
    <a href="<?php echo e(localized_route('admin.users')); ?>" class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800">
        <i class="fas fa-users text-xs"></i>
        Utilisateurs
    </a>
    <a href="<?php echo e(localized_route('admin.settings')); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-sliders text-xs"></i>
        Parametres
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('premium_dashboard_head'); ?>
    <style>
        .admin-field { background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.24); box-shadow: inset 0 1px 0 rgba(255,255,255,0.72); transition: border-color .18s, box-shadow .18s, background-color .18s; }
        .admin-field:focus { background: rgba(255,255,255,.98); border-color: rgba(21, 94, 239, 0.36); box-shadow: 0 0 0 4px rgba(21, 94, 239, 0.08); outline: none; }
        .admin-surface { border: 1px solid rgba(148,163,184,.18); background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,250,252,.88)); box-shadow: 0 18px 36px rgba(15,23,42,.06); }
        .admin-kpi { display: block; max-width: 100%; font-size: clamp(1.4rem, .95rem + 1vw, 2.4rem); line-height: 1.08; overflow-wrap: anywhere; word-break: break-word; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('dashboard_content'); ?>
    <section class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[30px] p-6 sm:p-7">
        <div class="relative z-10 grid gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Clients eligibles</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold"><?php echo e($users->count()); ?></p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Depots aujourd hui</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold"><?php echo e($depositsTodayCount); ?></p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Volume 30 jours</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold"><?php echo e($depositVolume30DaysFormatted); ?></p></div>
            <div class="rounded-[24px] bg-white/10 px-4 py-4 backdrop-blur-sm"><p class="text-xs uppercase tracking-[0.18em] text-white/60">Depots recents</p><p class="admin-kpi premium-kpi-number mt-2 font-semibold"><?php echo e($recentDeposits->count()); ?></p></div>
        </div>
    </section>

    <?php if(session('success') || session('status')): ?>
        <div class="rounded-[26px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
            <?php echo e(session('success') ?? session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="rounded-[26px] border border-rose-200 bg-rose-50 px-5 py-4">
            <p class="text-sm font-semibold text-rose-800">Erreurs de validation</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-rose-700">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid gap-6 2xl:grid-cols-[minmax(0,1.55fr)_380px]">
        <section class="admin-surface rounded-[30px] p-5 sm:p-6">
            <div class="flex items-start justify-between gap-3 border-b border-slate-200/70 pb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Operation</p>
                    <h2 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Crediter un compte</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Selectionnez un client, la devise, le montant et un motif si besoin.</p>
                </div>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Execution manuelle</span>
            </div>

            <form method="POST" action="<?php echo e(localized_route('admin.deposit.store')); ?>" class="mt-6 space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="user_id" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Utilisateur</label>
                        <select name="user_id" id="user_id" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>
                            <option value="">Choisir un utilisateur...</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" data-balance="<?php echo e($user->balance); ?>" <?php echo e(old('user_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?> - <?php echo e($user->email); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div id="balance-display" class="mt-3 hidden rounded-2xl bg-blue-50 px-4 py-3 text-sm text-blue-700 ring-1 ring-blue-200/80">
                            Solde actuel : <span id="current-balance" class="font-semibold"></span> <span id="balance-symbol">EUR</span>
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Montant</label>
                        <input type="number" name="amount" id="amount" min="0.01" step="0.01" value="<?php echo e(old('amount')); ?>" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="0.00" required>
                    </div>
                    <div>
                        <label for="currency" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Devise</label>
                        <select name="currency" id="currency" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" required>
                            <option value="">Choisir une devise...</option>
                            <?php $__currentLoopData = config('currencies.currencies'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($code); ?>" <?php echo e(old('currency') == $code ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="reason" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Motif</label>
                        <textarea name="reason" id="reason" rows="4" class="admin-field w-full rounded-2xl px-4 py-3 text-sm text-slate-700" placeholder="Remboursement, ajustement, bonus..."><?php echo e(old('reason')); ?></textarea>
                    </div>
                </div>

                <div class="rounded-[24px] bg-blue-50 px-4 py-4 ring-1 ring-blue-200/70">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-700">Apercu</p>
                    <p id="preview-text" class="mt-2 text-sm font-medium text-blue-900">Selectionnez un utilisateur, un montant et une devise pour voir l apercu.</p>
                    <p id="new-balance" class="mt-2 hidden text-sm text-blue-700">Nouveau solde : <span id="new-balance-amount" class="font-semibold"></span> <span id="new-balance-symbol">EUR</span></p>
                </div>

                <div class="rounded-[24px] bg-amber-50 px-4 py-4 ring-1 ring-amber-200/80">
                    <p class="text-sm font-semibold text-amber-900">Confirmation requise</p>
                    <p class="mt-2 text-sm leading-6 text-amber-700">Le compte sera credite immediatement et le client recevra une notification. Cette action doit etre lancee avec certitude.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <i class="fas fa-arrow-left text-xs"></i> Retour
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-800" onclick="return confirm('Confirmer ce depot manuel ?')">
                        <i class="fas fa-plus-circle text-xs"></i> Effectuer le depot
                    </button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <section class="admin-surface rounded-[30px] p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Historique</p>
                <h3 class="mt-2 premium-brand-title text-2xl font-semibold text-slate-950">Depots recents</h3>
                <div class="mt-5 space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $recentDeposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-900"><?php echo e($deposit->user?->first_name); ?> <?php echo e($deposit->user?->last_name); ?></p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e($deposit->created_at->format('d/m/Y H:i')); ?></p>
                                    <p class="mt-2 text-sm text-slate-500"><?php echo e($deposit->reason ?: 'Depot manuel'); ?></p>
                                </div>
                                <span class="text-sm font-semibold text-emerald-700">+<?php echo e(number_format($deposit->amount, 2, ',', ' ')); ?> EUR</span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="rounded-[22px] border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center">
                            <p class="text-sm font-semibold text-slate-900">Aucun depot recent</p>
                            <p class="mt-2 text-sm text-slate-500">Les derniers credits manuels apparaitront ici.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </aside>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('premium_dashboard_scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSelect = document.getElementById('user_id');
            const amountInput = document.getElementById('amount');
            const currencySelect = document.getElementById('currency');
            const previewText = document.getElementById('preview-text');
            const balanceDisplay = document.getElementById('balance-display');
            const currentBalance = document.getElementById('current-balance');
            const balanceSymbol = document.getElementById('balance-symbol');
            const newBalance = document.getElementById('new-balance');
            const newBalanceAmount = document.getElementById('new-balance-amount');
            const newBalanceSymbol = document.getElementById('new-balance-symbol');

            const getCurrencySymbol = (code) => {
                const currencies = <?php echo json_encode(config('currencies.currencies'), 15, 512) ?>;
                const label = currencies[code] || code;
                const match = label.match(/\(([^)]+)\)/);
                return match ? match[1] : code;
            };

            const updatePreview = () => {
                const option = userSelect.options[userSelect.selectedIndex];
                if (!userSelect.value || !amountInput.value || !currencySelect.value || !option) {
                    previewText.textContent = 'Selectionnez un utilisateur, un montant et une devise pour voir l apercu.';
                    balanceDisplay.classList.add('hidden');
                    newBalance.classList.add('hidden');
                    return;
                }

                const symbol = getCurrencySymbol(currencySelect.value);
                const balance = Number(option.getAttribute('data-balance') || 0);
                const amount = Number(amountInput.value || 0);
                const label = option.text.split(' - ')[0];

                previewText.textContent = `Depot de ${amount.toFixed(2)} ${symbol} sur le compte de ${label}.`;
                currentBalance.textContent = balance.toFixed(2);
                balanceSymbol.textContent = symbol;
                newBalanceAmount.textContent = (balance + amount).toFixed(2);
                newBalanceSymbol.textContent = symbol;
                balanceDisplay.classList.remove('hidden');
                newBalance.classList.remove('hidden');
            };

            [userSelect, amountInput, currencySelect].forEach((element) => element?.addEventListener('change', updatePreview));
            amountInput?.addEventListener('input', updatePreview);
            updatePreview();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin-premium', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\admin\deposit.blade.php ENDPATH**/ ?>