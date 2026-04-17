<?php $__env->startSection('title', __('auth.login_page_title')); ?>
<?php $__env->startSection('auth_nav_subtitle', 'Accès client'); ?>

<?php $__env->startSection('auth_nav_actions'); ?>
    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="auth-link-btn inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-user-plus text-xs"></i>
        <?php echo e(__('auth.nav_create_account')); ?>

    </a>
    <span class="inline-flex items-center justify-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20">
        <i class="fas fa-right-to-bracket text-xs"></i>
        <?php echo e(__('auth.nav_login')); ?>

    </span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth_hero'); ?>
    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/70 ring-1 ring-white/10">
        <span class="h-2.5 w-2.5 rounded-full bg-orange-400"></span>
        Accès sécurisé
    </span>

    <h1 class="auth-heading mt-6 text-4xl font-semibold tracking-[-0.05em] text-white sm:text-5xl">
        <?php echo e(__('auth.login_hero_title')); ?>

    </h1>
    <p class="mt-4 max-w-2xl text-base leading-7 text-white/76 sm:text-lg">
        <?php echo e(__('auth.login_hero_description')); ?>

    </p>

    <div class="mt-8 grid gap-3 sm:grid-cols-3">
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-shield-halved text-sm"></i></span>
            <span class="text-sm font-semibold"><?php echo e(__('auth.login_feature_security')); ?></span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-bell text-sm"></i></span>
            <span class="text-sm font-semibold"><?php echo e(__('auth.login_feature_notifications')); ?></span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-chart-line text-sm"></i></span>
            <span class="text-sm font-semibold"><?php echo e(__('auth.login_feature_analytics')); ?></span>
        </div>
    </div>

    <div class="mt-10 grid gap-3 sm:grid-cols-3">
        <div class="auth-stat-card">
            <p><?php echo e(__('auth.login_feature_security')); ?></p>
            <div class="mt-3 text-lg font-semibold text-white">24/7</div>
            <p class="mt-2 text-sm leading-6 text-white/74">Surveillance continue et accès securise a vos espaces sensibles.</p>
        </div>
        <div class="auth-stat-card">
            <p><?php echo e(__('auth.login_feature_notifications')); ?></p>
            <div class="mt-3 text-lg font-semibold text-white">Instant</div>
            <p class="mt-2 text-sm leading-6 text-white/74">Les mouvements importants remontent dans votre centre de notifications en direct.</p>
        </div>
        <div class="auth-stat-card">
            <p><?php echo e(__('auth.login_feature_analytics')); ?></p>
            <div class="mt-3 text-lg font-semibold text-white">Premium</div>
            <p class="mt-2 text-sm leading-6 text-white/74">Retrouvez le même niveau de qualité d'interface que sur votre tableau de bord client.</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth_panel'); ?>
    <?php
        $passwordRequestUrl = \Illuminate\Support\Facades\Route::has('password.request')
            ? route('password.request', ['locale' => app()->getLocale()])
            : localized_route('support.nous-contacter');
    ?>

    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Accès client</p>
            <h2 class="auth-heading mt-2 text-3xl font-semibold tracking-[-0.04em] text-slate-950"><?php echo e(__('auth.login_title')); ?></h2>
            <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('auth.login_subtitle')); ?></p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-700 ring-1 ring-orange-200/80">
            <i class="fas fa-lock text-[11px]"></i>
            Niveau bancaire
        </span>
    </div>

    <div class="mt-6 space-y-4">
        <?php if(session('success')): ?>
            <div class="rounded-[24px] border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm font-medium text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('status')): ?>
            <div class="rounded-[24px] border border-blue-200 bg-blue-50 px-4 py-4 text-sm font-medium text-blue-800">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('login_link_notice')): ?>
            <div class="rounded-[24px] border border-blue-200 bg-blue-50 px-4 py-4 text-sm font-medium text-blue-800">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-2xl bg-white text-blue-700 ring-1 ring-blue-200/80">
                        <i class="fas fa-link text-sm"></i>
                    </span>
                    <p><?php echo e(session('login_link_notice')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="rounded-[24px] border border-rose-200 bg-rose-50 px-4 py-4">
                <ul class="space-y-1 text-sm text-rose-700">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <form method="POST" action="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="mt-6 space-y-5">
        <?php echo csrf_field(); ?>

        <div>
            <label for="email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('auth.email')); ?></label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-envelope text-sm"></i>
                </span>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    value="<?php echo e(old('email', session('prefill_email'))); ?>"
                    placeholder="<?php echo e(__('auth.email_placeholder')); ?>"
                    class="auth-input w-full rounded-2xl py-3.5 pl-11 pr-4 text-sm text-slate-700"
                >
            </div>
        </div>

        <div>
            <div class="mb-2 flex items-center justify-between gap-3">
                <label for="password" class="block text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('auth.password')); ?></label>
                <a href="<?php echo e($passwordRequestUrl); ?>" class="text-sm font-semibold text-orange-700 transition hover:text-orange-800"><?php echo e(__('auth.forgot_password')); ?></a>
            </div>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fas fa-lock text-sm"></i>
                </span>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    placeholder="<?php echo e(__('auth.password_placeholder')); ?>"
                    class="auth-input w-full rounded-2xl py-3.5 pl-11 pr-12 text-sm text-slate-700"
                >
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-4 text-slate-400 transition hover:text-slate-700">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <label for="remember" class="inline-flex items-center gap-3 text-sm text-slate-600">
                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                <span><?php echo e(__('auth.remember_me')); ?></span>
            </label>
            <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-500">
                <i class="fas fa-shield-halved text-[11px]"></i>
                Espace sécurisé
            </div>
        </div>

        <button type="submit" class="auth-submit inline-flex w-full items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-semibold text-white">
            <i class="fas fa-right-to-bracket text-xs"></i>
            <?php echo e(__('auth.login_button')); ?>

        </button>
    </form>

    <div class="auth-panel-divider mt-7">
        <span class="text-sm font-medium"><?php echo e(__('auth.or')); ?></span>
    </div>

    <div class="mt-6 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
        <p class="text-sm font-semibold text-slate-900"><?php echo e(__('auth.no_account')); ?></p>
        <p class="mt-2 text-sm leading-6 text-slate-500">L'ouverture de compte bénéficie désormais du même niveau de finition premium que votre espace connecté.</p>
        <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-orange-700 transition hover:text-orange-800">
            <?php echo e(__('auth.register_link')); ?>

            <i class="fas fa-arrow-right text-[11px]"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('auth_premium_scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            toggleBtn?.addEventListener('click', function () {
                if (!passwordInput) {
                    return;
                }

                const icon = toggleBtn.querySelector('i');
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon?.classList.toggle('fa-eye', !isPassword);
                icon?.classList.toggle('fa-eye-slash', isPassword);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.auth-premium', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\auth\login.blade.php ENDPATH**/ ?>