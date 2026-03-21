<?php $__env->startSection('title', __('auth.forgot_password_page_title')); ?>
<?php $__env->startSection('auth_nav_subtitle', 'Password assistance'); ?>

<?php $__env->startSection('auth_nav_actions'); ?>
    <a href="<?php echo e(localized_route('home')); ?>" class="auth-link-btn inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50">
        <i class="fas fa-house text-xs"></i>
        <?php echo e(__('auth.nav_home')); ?>

    </a>
    <a href="<?php echo e(route('login', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-900/20 transition hover:bg-orange-600">
        <i class="fas fa-right-to-bracket text-xs"></i>
        <?php echo e(__('auth.nav_login')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth_hero'); ?>
    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/70 ring-1 ring-white/10">
        <span class="h-2.5 w-2.5 rounded-full bg-orange-400"></span>
        Recovery
    </span>

    <h1 class="auth-heading mt-6 text-4xl font-semibold tracking-[-0.05em] text-white sm:text-5xl">
        <?php echo e(__('auth.forgot_password_title')); ?>

    </h1>
    <p class="mt-4 max-w-2xl text-base leading-7 text-white/76 sm:text-lg">
        <?php echo e(__('auth.forgot_password_subtitle')); ?>

    </p>

    <div class="mt-10 space-y-3">
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-envelope text-sm"></i></span>
            <span class="text-sm font-semibold"><?php echo e(__('auth.send_reset_link')); ?></span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-shield-halved text-sm"></i></span>
            <span class="text-sm font-semibold"><?php echo e(__('auth.login_feature_security')); ?></span>
        </div>
        <div class="auth-chip">
            <span class="auth-chip-icon"><i class="fas fa-arrow-left text-sm"></i></span>
            <span class="text-sm font-semibold"><?php echo e(__('auth.back_to_login')); ?></span>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auth_panel'); ?>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Recovery</p>
            <h2 class="auth-heading mt-2 text-3xl font-semibold tracking-[-0.04em] text-slate-950"><?php echo e(__('auth.forgot_password')); ?></h2>
            <p class="mt-2 text-sm leading-6 text-slate-500"><?php echo e(__('auth.forgot_password_subtitle')); ?></p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-700 ring-1 ring-orange-200/80">
            <i class="fas fa-key text-[11px]"></i>
            Secure link
        </span>
    </div>

    <div class="mt-6 space-y-4">
        <?php if(session('status')): ?>
            <div class="rounded-[24px] border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm font-medium text-emerald-800">
                <?php echo e(session('status')); ?>

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

    <form method="POST" action="<?php echo e(route('password.email', ['locale' => app()->getLocale()])); ?>" class="mt-6 space-y-5">
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
                    required
                    autocomplete="email"
                    value="<?php echo e(old('email')); ?>"
                    placeholder="<?php echo e(__('auth.email_placeholder')); ?>"
                    class="auth-input w-full rounded-2xl py-3.5 pl-11 pr-4 text-sm text-slate-700"
                >
            </div>
        </div>

        <button type="submit" class="auth-submit inline-flex w-full items-center justify-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-semibold text-white">
            <i class="fas fa-paper-plane text-xs"></i>
            <?php echo e(__('auth.send_reset_link')); ?>

        </button>
    </form>

    <div class="mt-6 rounded-[24px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
        <a href="<?php echo e(route('login', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-orange-700 transition hover:text-orange-800">
            <i class="fas fa-arrow-left text-[11px]"></i>
            <?php echo e(__('auth.back_to_login')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth-premium', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\auth\passwords\email.blade.php ENDPATH**/ ?>