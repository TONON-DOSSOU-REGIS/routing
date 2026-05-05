<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('auth.2fa_setup_title')); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        @keyframes securityFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes securityPulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        @keyframes securitySweep {
            0% { transform: translateX(-130%); }
            100% { transform: translateX(130%); }
        }

        .security-float {
            animation: securityFloat 7s ease-in-out infinite;
        }

        .security-pulse {
            animation: securityPulse 2.6s ease-in-out infinite;
        }

        .security-sweep {
            position: relative;
            overflow: hidden;
        }

        .security-sweep::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 10%, rgba(255, 255, 255, 0.18) 45%, transparent 80%);
            transform: translateX(-130%);
            animation: securitySweep 5.8s linear infinite;
            pointer-events: none;
        }

        .twofactor-qr-svg {
            display: block;
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.16),_transparent_32%),radial-gradient(circle_at_bottom_right,_rgba(249,115,22,0.18),_transparent_28%),linear-gradient(180deg,#f8fafc_0%,#eef2ff_52%,#f8fafc_100%)] text-slate-900">
    <?php
        $setupProgress = $user->two_factor_enabled ? 100 : 68;
        $backupCodeCount = is_array($backupCodes ?? null) ? count($backupCodes) : 10;
        $maskedSecret = $user->two_factor_secret
            ? substr($user->two_factor_secret, 0, 4) . ' **** ' . substr($user->two_factor_secret, -4)
            : '----';
    ?>

    <div class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-72 bg-[radial-gradient(circle_at_top,_rgba(30,64,175,0.18),_transparent_58%)]"></div>
        <div class="pointer-events-none absolute -top-16 left-10 h-40 w-40 rounded-full bg-blue-200/50 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 right-0 h-56 w-56 rounded-full bg-orange-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
            <div class="grid gap-8 xl:grid-cols-[0.92fr,1.08fr]">
                <section class="security-float overflow-hidden rounded-[2rem] border border-slate-800/60 bg-slate-950 text-white shadow-[0_35px_100px_rgba(15,23,42,0.38)]">
                    <div class="relative h-full overflow-hidden px-6 py-7 sm:px-8 sm:py-9">
                        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>
                        <div class="absolute -left-14 bottom-0 h-48 w-48 rounded-full bg-orange-400/10 blur-3xl"></div>

                        <div class="relative z-10">
                            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.28em] text-blue-100">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 security-pulse"></span>
                                Valtrix Bank
                            </span>

                            <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                                <?php echo e(__('auth.2fa_setup_heading')); ?>

                            </h1>
                            <p class="mt-4 max-w-xl text-base leading-7 text-slate-300 sm:text-lg">
                                <?php echo e(__('auth.2fa_setup_description')); ?>

                            </p>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-200">
                                    <i class="fas fa-shield-halved text-emerald-300"></i>
                                    <?php echo e(__('auth.2fa_secret_title')); ?>

                                </div>
                                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-200">
                                    <i class="fas fa-mobile-screen-button text-blue-300"></i>
                                    <?php echo e(__('auth.2fa_enable_title')); ?>

                                </div>
                                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-200">
                                    <i class="fas fa-key text-orange-300"></i>
                                    <?php echo e(__('auth.2fa_backup_title')); ?>

                                </div>
                            </div>

                            <?php if(!empty($isAdminTwoFactorMandatory)): ?>
                                <div class="mt-6 rounded-[1.4rem] border border-amber-300/25 bg-amber-400/10 px-5 py-4 text-amber-100">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-300/15 text-amber-200">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-200">Admin</p>
                                            <p class="mt-2 text-sm leading-6 text-amber-50/90"><?php echo e(__('auth.2fa_admin_mandatory_notice')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                                <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_secret_title')); ?></p>
                                    <p class="mt-3 text-lg font-bold text-white"><?php echo e($maskedSecret); ?></p>
                                    <p class="mt-2 text-xs text-slate-300"><?php echo e(__('auth.2fa_secret_hint')); ?></p>
                                </div>
                                <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_enable_title')); ?></p>
                                    <p class="mt-3 text-3xl font-bold text-white">6</p>
                                    <p class="mt-2 text-xs text-slate-300"><?php echo e(__('auth.2fa_enable_hint')); ?></p>
                                </div>
                                <div class="rounded-[1.5rem] border border-white/10 bg-white/5 p-4">
                                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_backup_title')); ?></p>
                                    <p class="mt-3 text-3xl font-bold text-white"><?php echo e($backupCodeCount); ?></p>
                                    <p class="mt-2 text-xs text-slate-300"><?php echo e(__('auth.2fa_backup_hint')); ?></p>
                                </div>
                            </div>

                            <div class="security-sweep mt-8 overflow-hidden rounded-[1.9rem] border border-white/10 bg-white/5 p-5 sm:p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.3em] text-orange-200"><?php echo e(__('auth.2fa_setup_heading')); ?></p>
                                        <h2 class="mt-3 text-2xl font-bold text-white"><?php echo e(__('auth.2fa_setup_heading')); ?></h2>
                                    </div>
                                    <div class="rounded-2xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-right">
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-emerald-200">2FA</p>
                                        <p class="mt-1 text-2xl font-bold text-emerald-300"><?php echo e($setupProgress); ?>%</p>
                                    </div>
                                </div>

                                <div class="mt-5 h-3 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-3 rounded-full bg-gradient-to-r from-blue-400 via-sky-300 to-emerald-400" style="width: <?php echo e($setupProgress); ?>%"></div>
                                </div>

                                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">01</p>
                                        <p class="mt-2 font-semibold text-white"><?php echo e(__('auth.2fa_secret_title')); ?></p>
                                        <p class="mt-2 text-xs text-slate-400"><?php echo e(__('auth.2fa_secret_hint')); ?></p>
                                    </div>
                                    <div class="rounded-2xl border border-blue-300/20 bg-blue-400/10 px-4 py-4">
                                        <p class="text-xs uppercase tracking-[0.2em] text-blue-200">02</p>
                                        <p class="mt-2 font-semibold text-white"><?php echo e(__('auth.2fa_enable_title')); ?></p>
                                        <p class="mt-2 text-xs text-slate-300"><?php echo e(__('auth.2fa_enable_hint')); ?></p>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">03</p>
                                        <p class="mt-2 font-semibold text-white"><?php echo e(__('auth.2fa_backup_title')); ?></p>
                                        <p class="mt-2 text-xs text-slate-400"><?php echo e(__('auth.2fa_backup_hint')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="space-y-6">
                    <div class="rounded-[2rem] border border-white/70 bg-white/92 p-5 shadow-[0_30px_90px_rgba(148,163,184,0.18)] backdrop-blur-xl sm:p-7">
                        <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-slate-400">Valtrix Bank</p>
                                <h2 class="mt-3 text-2xl font-bold text-slate-950"><?php echo e(__('auth.2fa_setup_heading')); ?></h2>
                                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500"><?php echo e(__('auth.2fa_setup_description')); ?></p>
                            </div>
                            <div class="rounded-[1.3rem] border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] uppercase tracking-[0.24em] text-slate-400"><?php echo e(__('auth.2fa_otpauth_label')); ?></p>
                                <p class="mt-1 text-sm font-semibold text-slate-900 break-all"><?php echo e($user->email); ?></p>
                            </div>
                        </div>

                        <?php if(session('status')): ?>
                            <div class="mt-5 rounded-[1.25rem] border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                                        <i class="fas fa-circle-check"></i>
                                    </div>
                                    <p class="text-sm font-medium leading-6"><?php echo e(session('status')); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="mt-5 rounded-[1.25rem] border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                                        <i class="fas fa-triangle-exclamation"></i>
                                    </div>
                                    <p class="text-sm font-medium leading-6"><?php echo e($errors->first()); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mt-6 grid gap-6 xl:grid-cols-2">
                            <div class="rounded-[1.6rem] border border-slate-200 bg-gradient-to-br from-slate-50 via-white to-slate-100 p-5 shadow-sm">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-950"><?php echo e(__('auth.2fa_secret_title')); ?></h3>
                                        <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('auth.2fa_secret_hint')); ?></p>
                                    </div>
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>

                                <div class="mt-5 grid gap-4 lg:grid-cols-[190px,minmax(0,1fr)]">
                                    <div class="rounded-[1.35rem] border border-slate-200 bg-white p-4 shadow-sm">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-400">QR</p>
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                                <i class="fas fa-qrcode"></i>
                                            </span>
                                        </div>

                                        <div class="mt-4 overflow-hidden rounded-[1.15rem] border border-slate-200 bg-white p-3">
                                            <?php if(!empty($qrSvg)): ?>
                                                <?php echo $qrSvg; ?>

                                            <?php else: ?>
                                                <div class="flex aspect-square items-center justify-center rounded-[0.9rem] bg-slate-100 text-slate-400">
                                                    <i class="fas fa-qrcode text-3xl"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <p class="mt-3 text-xs leading-5 text-slate-500"><?php echo e(__('auth.2fa_secret_hint')); ?></p>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="rounded-[1.2rem] border border-slate-200 bg-white px-4 py-4">
                                            <div class="flex items-center justify-between gap-3">
                                                <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_secret_title')); ?></p>
                                                <button
                                                    type="button"
                                                    data-copy-secret-button
                                                    data-secret="<?php echo e($user->two_factor_secret); ?>"
                                                    data-label-default="<?php echo e(__('auth.2fa_copy_secret')); ?>"
                                                    data-label-success="<?php echo e(__('auth.2fa_copy_secret_success')); ?>"
                                                    class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                                >
                                                    <i class="fas fa-copy text-[11px]"></i>
                                                    <span><?php echo e(__('auth.2fa_copy_secret')); ?></span>
                                                </button>
                                            </div>
                                            <div class="mt-3 break-all font-mono text-lg font-semibold text-slate-950"><?php echo e($user->two_factor_secret); ?></div>
                                            <p data-copy-secret-feedback class="mt-3 hidden text-xs font-medium text-emerald-600" aria-live="polite">
                                                <?php echo e(__('auth.2fa_copy_secret_success')); ?>

                                            </p>
                                        </div>

                                        <div class="rounded-[1.2rem] border border-slate-200 bg-white px-4 py-4">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_otpauth_label')); ?></p>
                                            <div class="mt-3 break-all font-mono text-sm leading-6 text-slate-600"><?php echo e($otpauth); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[1.6rem] border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-indigo-50 p-5 shadow-sm">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-950"><?php echo e(__('auth.2fa_enable_title')); ?></h3>
                                        <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('auth.2fa_enable_hint')); ?></p>
                                    </div>
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-blue-700 shadow-sm">
                                        <i class="fas fa-mobile-screen-button"></i>
                                    </div>
                                </div>

                                <form method="POST" action="<?php echo e(localized_route('twofactor.enable', ['locale' => app()->getLocale()])); ?>" class="mt-5 space-y-4">
                                    <?php echo csrf_field(); ?>
                                    <div class="rounded-[1.25rem] border border-blue-100 bg-white p-3 shadow-sm">
                                        <input
                                            type="text"
                                            name="code"
                                            inputmode="numeric"
                                            autocomplete="one-time-code"
                                            maxlength="6"
                                            spellcheck="false"
                                            class="w-full border-0 bg-transparent px-2 py-2 text-center text-2xl font-bold tracking-[0.45em] text-slate-950 outline-none placeholder:text-slate-300"
                                            placeholder="<?php echo e(__('auth.2fa_code_placeholder')); ?>"
                                        >
                                    </div>

                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-3 rounded-[1.25rem] bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-[0_16px_34px_rgba(37,99,235,0.28)] transition hover:-translate-y-0.5 hover:shadow-[0_20px_40px_rgba(37,99,235,0.35)]">
                                        <i class="fas fa-shield-alt"></i>
                                        <?php echo e(__('auth.2fa_enable_button')); ?>

                                    </button>
                                </form>

                                <div class="mt-5 rounded-[1.2rem] border border-blue-100 bg-white/85 px-4 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                            <i class="fas fa-circle-info"></i>
                                        </div>
                                        <p class="text-sm leading-6 text-slate-600"><?php echo e(__('auth.2fa_enable_hint')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(!empty($backupCodes)): ?>
                            <div class="mt-6 rounded-[1.7rem] border border-amber-200 bg-gradient-to-br from-amber-50 to-white p-5 shadow-sm">
                                <div class="flex flex-col gap-4 border-b border-amber-200 pb-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-amber-950"><?php echo e(__('auth.2fa_backup_title')); ?></h3>
                                        <p class="mt-1 text-sm leading-6 text-amber-900/80"><?php echo e(__('auth.2fa_backup_hint')); ?></p>
                                    </div>
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-amber-700 shadow-sm">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>

                                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                    <?php $__currentLoopData = $backupCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="rounded-[1rem] border border-amber-200 bg-white px-4 py-3 text-center font-mono text-sm font-semibold tracking-[0.12em] text-amber-900 shadow-sm">
                                            <?php echo e($code); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (! (!empty($isAdminTwoFactorMandatory))): ?>
                            <div class="mt-6 rounded-[1.7rem] border border-slate-200 bg-slate-50/80 p-5 shadow-sm">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-950"><?php echo e(__('auth.2fa_disable_title')); ?></h3>
                                        <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('auth.2fa_disable_hint')); ?></p>
                                    </div>
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-slate-700 shadow-sm">
                                        <i class="fas fa-power-off"></i>
                                    </div>
                                </div>

                                <form method="POST" action="<?php echo e(localized_route('twofactor.disable', ['locale' => app()->getLocale()])); ?>" class="mt-5 space-y-4">
                                    <?php echo csrf_field(); ?>
                                    <input
                                        type="password"
                                        name="password"
                                        autocomplete="current-password"
                                        class="w-full rounded-[1.2rem] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-200/60"
                                        placeholder="<?php echo e(__('auth.2fa_password_placeholder')); ?>"
                                    >
                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-3 rounded-[1.25rem] bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white shadow-[0_16px_30px_rgba(15,23,42,0.18)] transition hover:-translate-y-0.5 hover:bg-black">
                                        <i class="fas fa-lock-open"></i>
                                        <?php echo e(__('auth.2fa_disable_button')); ?>

                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <div class="mt-6 flex flex-col gap-4 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <a href="<?php echo e($dashboardUrl); ?>" class="inline-flex items-center gap-3 rounded-[1.15rem] border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700">
                                <i class="fas fa-arrow-left"></i>
                                <?php echo e(__('auth.2fa_back_dashboard')); ?>

                            </a>

                            <div class="inline-flex items-center gap-3 rounded-[1.15rem] bg-slate-50 px-4 py-3 text-sm text-slate-500">
                                <i class="fas fa-shield-check text-emerald-600"></i>
                                <span><?php echo e(__('auth.2fa_setup_heading')); ?></span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
<script>
    (() => {
        const copyButton = document.querySelector('[data-copy-secret-button]');
        const feedback = document.querySelector('[data-copy-secret-feedback]');

        if (!copyButton) {
            return;
        }

        const defaultLabel = copyButton.dataset.labelDefault || 'Copy key';
        const successLabel = copyButton.dataset.labelSuccess || 'Key copied';

        const updateSuccessState = () => {
            const label = copyButton.querySelector('span');
            if (label) {
                label.textContent = successLabel;
            }

            copyButton.classList.remove('bg-blue-50', 'text-blue-700', 'border-blue-100');
            copyButton.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-100');

            if (feedback) {
                feedback.classList.remove('hidden');
            }

            window.setTimeout(() => {
                if (label) {
                    label.textContent = defaultLabel;
                }

                copyButton.classList.add('bg-blue-50', 'text-blue-700', 'border-blue-100');
                copyButton.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-100');

                if (feedback) {
                    feedback.classList.add('hidden');
                }
            }, 2200);
        };

        const fallbackCopy = (value) => {
            const field = document.createElement('textarea');
            field.value = value;
            field.setAttribute('readonly', '');
            field.style.position = 'absolute';
            field.style.left = '-9999px';
            document.body.appendChild(field);
            field.select();
            document.execCommand('copy');
            document.body.removeChild(field);
        };

        copyButton.addEventListener('click', async () => {
            const secret = copyButton.dataset.secret || '';
            if (!secret) {
                return;
            }

            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(secret);
                } else {
                    fallbackCopy(secret);
                }

                updateSuccessState();
            } catch (error) {
                try {
                    fallbackCopy(secret);
                    updateSuccessState();
                } catch (fallbackError) {
                    console.error(fallbackError);
                }
            }
        });
    })();
</script>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/auth/two-factor-setup.blade.php ENDPATH**/ ?>