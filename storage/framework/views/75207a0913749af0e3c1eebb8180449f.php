<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('auth.2fa_challenge_title')); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        @keyframes challengeFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        @keyframes challengePulse {
            0%, 100% { opacity: 0.55; }
            50% { opacity: 1; }
        }

        @keyframes challengeSweep {
            0% { transform: translateX(-130%); }
            100% { transform: translateX(130%); }
        }

        .challenge-float {
            animation: challengeFloat 7s ease-in-out infinite;
        }

        .challenge-pulse {
            animation: challengePulse 2.8s ease-in-out infinite;
        }

        .challenge-sweep {
            position: relative;
            overflow: hidden;
        }

        .challenge-sweep::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 10%, rgba(255, 255, 255, 0.18) 45%, transparent 80%);
            transform: translateX(-130%);
            animation: challengeSweep 5.8s linear infinite;
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.16),_transparent_32%),radial-gradient(circle_at_bottom_right,_rgba(249,115,22,0.16),_transparent_28%),linear-gradient(180deg,#f8fafc_0%,#eef2ff_50%,#f8fafc_100%)] text-slate-900">
    <?php
        $emailParts = explode('@', (string) $email, 2);
        $localPart = $emailParts[0] ?? '';
        $maskedLocal = $localPart === ''
            ? '***'
            : substr($localPart, 0, min(2, strlen($localPart))) . str_repeat('*', max(strlen($localPart) - 2, 0));
        $maskedEmail = isset($emailParts[1]) ? $maskedLocal . '@' . $emailParts[1] : $email;
    ?>

    <div class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-72 bg-[radial-gradient(circle_at_top,_rgba(30,64,175,0.18),_transparent_58%)]"></div>
        <div class="pointer-events-none absolute -top-16 left-10 h-40 w-40 rounded-full bg-blue-200/50 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 right-0 h-56 w-56 rounded-full bg-orange-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
            <div class="grid gap-8 xl:grid-cols-[0.9fr,1.1fr]">
                <section class="challenge-float overflow-hidden rounded-[2rem] border border-slate-800/60 bg-slate-950 text-white shadow-[0_35px_100px_rgba(15,23,42,0.38)]">
                    <div class="relative h-full overflow-hidden px-6 py-7 sm:px-8 sm:py-9">
                        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>
                        <div class="absolute -left-14 bottom-0 h-48 w-48 rounded-full bg-orange-400/10 blur-3xl"></div>

                        <div class="relative z-10">
                            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.28em] text-blue-100">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 challenge-pulse"></span>
                                Valtrix Bank
                            </span>

                            <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                                <?php echo e(__('auth.2fa_challenge_heading')); ?>

                            </h1>
                            <p class="mt-4 max-w-xl text-base leading-7 text-slate-300 sm:text-lg">
                                <?php echo e(__('auth.2fa_challenge_description')); ?>

                            </p>

                            <div class="mt-7 rounded-[1.6rem] border border-white/10 bg-white/5 p-5">
                                <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_otpauth_label')); ?></p>
                                <p class="mt-3 text-lg font-semibold text-white break-all"><?php echo e($maskedEmail); ?></p>
                                <p class="mt-2 text-sm leading-6 text-slate-300"><?php echo e(__('auth.2fa_setup_heading')); ?></p>
                            </div>

                            <div class="challenge-sweep mt-7 rounded-[1.9rem] border border-white/10 bg-white/5 p-5 sm:p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.3em] text-orange-200">2FA</p>
                                        <h2 class="mt-3 text-2xl font-bold text-white"><?php echo e(__('auth.2fa_challenge_heading')); ?></h2>
                                    </div>
                                    <div class="rounded-2xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-right">
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-emerald-200">Secure</p>
                                        <p class="mt-1 text-2xl font-bold text-emerald-300">100%</p>
                                    </div>
                                </div>

                                <div class="mt-5 h-3 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-3 rounded-full bg-gradient-to-r from-blue-400 via-sky-300 to-emerald-400" style="width: 100%"></div>
                                </div>

                                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">01</p>
                                        <p class="mt-2 font-semibold text-white"><?php echo e(__('auth.2fa_code_label')); ?></p>
                                        <p class="mt-2 text-xs text-slate-400"><?php echo e(__('auth.2fa_challenge_description')); ?></p>
                                    </div>
                                    <div class="rounded-2xl border border-blue-300/20 bg-blue-400/10 px-4 py-4">
                                        <p class="text-xs uppercase tracking-[0.2em] text-blue-200">02</p>
                                        <p class="mt-2 font-semibold text-white"><?php echo e(__('auth.2fa_backup_label')); ?></p>
                                        <p class="mt-2 text-xs text-slate-300"><?php echo e(__('auth.2fa_backup_placeholder')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-7 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-[1.4rem] border border-white/10 bg-white/5 p-4">
                                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_code_label')); ?></p>
                                    <p class="mt-3 text-3xl font-bold text-white">6</p>
                                    <p class="mt-2 text-xs text-slate-300"><?php echo e(__('auth.2fa_code_placeholder')); ?></p>
                                </div>
                                <div class="rounded-[1.4rem] border border-white/10 bg-white/5 p-4">
                                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400"><?php echo e(__('auth.2fa_backup_label')); ?></p>
                                    <p class="mt-3 text-3xl font-bold text-white">1</p>
                                    <p class="mt-2 text-xs text-slate-300"><?php echo e(__('auth.2fa_verify_button')); ?></p>
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
                                <h2 class="mt-3 text-2xl font-bold text-slate-950"><?php echo e(__('auth.2fa_challenge_heading')); ?></h2>
                                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500"><?php echo e(__('auth.2fa_challenge_description')); ?></p>
                            </div>
                            <div class="rounded-[1.3rem] border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-[11px] uppercase tracking-[0.24em] text-slate-400"><?php echo e(__('auth.2fa_otpauth_label')); ?></p>
                                <p class="mt-1 text-sm font-semibold text-slate-900 break-all"><?php echo e($maskedEmail); ?></p>
                            </div>
                        </div>

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

                        <form method="POST" action="<?php echo e(localized_route('twofactor.verify', ['locale' => app()->getLocale()])); ?>" class="mt-6 space-y-6">
                            <?php echo csrf_field(); ?>

                            <div class="grid gap-6 xl:grid-cols-2">
                                <div class="rounded-[1.6rem] border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-indigo-50 p-5 shadow-sm">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-950"><?php echo e(__('auth.2fa_code_label')); ?></h3>
                                            <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('auth.2fa_challenge_description')); ?></p>
                                        </div>
                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-blue-700 shadow-sm">
                                            <i class="fas fa-mobile-screen-button"></i>
                                        </div>
                                    </div>

                                    <div class="mt-5 rounded-[1.25rem] border border-blue-100 bg-white p-3 shadow-sm">
                                        <input
                                            type="text"
                                            name="code"
                                            inputmode="numeric"
                                            autocomplete="one-time-code"
                                            maxlength="6"
                                            spellcheck="false"
                                            value="<?php echo e(old('code')); ?>"
                                            class="w-full border-0 bg-transparent px-2 py-2 text-center text-2xl font-bold tracking-[0.45em] text-slate-950 outline-none placeholder:text-slate-300"
                                            placeholder="<?php echo e(__('auth.2fa_code_placeholder')); ?>"
                                        >
                                    </div>
                                </div>

                                <div class="rounded-[1.6rem] border border-amber-100 bg-gradient-to-br from-amber-50 via-white to-orange-50 p-5 shadow-sm">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-950"><?php echo e(__('auth.2fa_backup_label')); ?></h3>
                                            <p class="mt-1 text-sm leading-6 text-slate-500"><?php echo e(__('auth.2fa_backup_placeholder')); ?></p>
                                        </div>
                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-amber-700 shadow-sm">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </div>

                                    <div class="mt-5 rounded-[1.25rem] border border-amber-100 bg-white p-3 shadow-sm">
                                        <input
                                            type="text"
                                            name="recovery_code"
                                            autocomplete="off"
                                            spellcheck="false"
                                            value="<?php echo e(old('recovery_code')); ?>"
                                            class="w-full border-0 bg-transparent px-2 py-2 text-center text-base font-semibold tracking-[0.18em] text-slate-950 outline-none placeholder:text-slate-300"
                                            placeholder="<?php echo e(__('auth.2fa_backup_placeholder')); ?>"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[1.35rem] border border-slate-200 bg-slate-50/80 px-4 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-slate-700 shadow-sm">
                                        <i class="fas fa-shield-check"></i>
                                    </div>
                                    <p class="text-sm leading-6 text-slate-600"><?php echo e(__('auth.2fa_challenge_description')); ?></p>
                                </div>
                            </div>

                            <button type="submit" class="inline-flex w-full items-center justify-center gap-3 rounded-[1.25rem] bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-[0_16px_34px_rgba(37,99,235,0.28)] transition hover:-translate-y-0.5 hover:shadow-[0_20px_40px_rgba(37,99,235,0.35)]">
                                <i class="fas fa-shield-alt"></i>
                                <?php echo e(__('auth.2fa_verify_button')); ?>

                            </button>
                        </form>

                        <div class="mt-6 flex flex-col gap-4 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center gap-3 rounded-[1.15rem] border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-700">
                                <i class="fas fa-arrow-left"></i>
                                <?php echo e(__('auth.back_to_login')); ?>

                            </a>

                            <div class="inline-flex items-center gap-3 rounded-[1.15rem] bg-slate-50 px-4 py-3 text-sm text-slate-500">
                                <i class="fas fa-lock text-emerald-600"></i>
                                <span><?php echo e(__('auth.2fa_setup_heading')); ?></span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\auth\two-factor-challenge.blade.php ENDPATH**/ ?>