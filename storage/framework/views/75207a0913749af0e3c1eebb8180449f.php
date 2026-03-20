<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('auth.2fa_challenge_title')); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50">
    <div class="max-w-lg mx-auto p-6">
        <div class="bg-white shadow rounded-2xl p-6">
            <h1 class="text-2xl font-bold text-slate-900"><?php echo e(__('auth.2fa_challenge_heading')); ?></h1>
            <p class="text-slate-600 mt-2"><?php echo e(__('auth.2fa_challenge_description')); ?></p>

            <?php if($errors->any()): ?>
                <div class="mt-4 rounded-lg bg-red-50 text-red-700 px-4 py-3">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(localized_route('twofactor.verify', ['locale' => app()->getLocale()])); ?>" class="mt-6 space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="text-sm text-slate-700"><?php echo e(__('auth.2fa_code_label')); ?></label>
                    <input type="text" name="code" inputmode="numeric" maxlength="6" class="w-full mt-1 p-3 rounded-lg border border-slate-200" placeholder="<?php echo e(__('auth.2fa_code_placeholder')); ?>">
                </div>
                <div>
                    <label class="text-sm text-slate-700"><?php echo e(__('auth.2fa_backup_label')); ?></label>
                    <input type="text" name="recovery_code" class="w-full mt-1 p-3 rounded-lg border border-slate-200" placeholder="<?php echo e(__('auth.2fa_backup_placeholder')); ?>">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 font-semibold hover:bg-blue-700">
                    <?php echo e(__('auth.2fa_verify_button')); ?>

                </button>
            </form>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\auth\two-factor-challenge.blade.php ENDPATH**/ ?>