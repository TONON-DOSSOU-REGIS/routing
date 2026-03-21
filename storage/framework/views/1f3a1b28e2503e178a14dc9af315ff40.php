<?php $__env->startSection('title', __('budgets.edit_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900"><?php echo e(__('budgets.edit_heading')); ?></h1>
            <p class="text-gray-600 mt-2"><?php echo e(__('budgets.edit_subtitle', ['category' => $budget->category])); ?></p>
        </div>

        <form action="<?php echo e(localized_route('budgets.update', $budget)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('budgets.category_label')); ?>

                </label>
                <input type="text" name="category" id="category" value="<?php echo e($budget->category); ?>" readonly
                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                <p class="mt-1 text-sm text-gray-600"><?php echo e(__('budgets.category_help')); ?></p>
            </div>

            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('budgets.budget_amount_label')); ?> *
                </label>
                <input type="number" name="amount" id="amount" step="0.01" min="0" value="<?php echo e($budget->amount); ?>" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="<?php echo e(__('budgets.amount_placeholder')); ?>">
                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="alert_enabled" id="alert_enabled" <?php echo e($budget->alert_enabled ? 'checked' : ''); ?>

                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="alert_enabled" class="ml-2 block text-sm text-gray-900">
                        <?php echo e(__('budgets.enable_alerts')); ?>

                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-600"><?php echo e(__('budgets.alert_helper')); ?></p>
            </div>

            <div class="mb-8" id="alert_threshold_container" style="<?php echo e($budget->alert_enabled ? '' : 'display: none;'); ?>">
                <label for="alert_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                    <?php echo e(__('budgets.alert_threshold_label')); ?>

                </label>
                <input type="number" name="alert_threshold" id="alert_threshold" value="<?php echo e($budget->alert_threshold); ?>" min="1" max="100"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-600"><?php echo e(__('budgets.alert_threshold_helper')); ?></p>
                <?php $__errorArgs = ['alert_threshold'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="<?php echo e(localized_route('budgets.index')); ?>"
                   class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <?php echo e(__('budgets.cancel')); ?>

                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    <?php echo e(__('budgets.update')); ?>

                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('alert_enabled').addEventListener('change', function() {
    const container = document.getElementById('alert_threshold_container');
    const input = document.getElementById('alert_threshold');

    if (this.checked) {
        container.style.display = 'block';
        input.required = true;
    } else {
        container.style.display = 'none';
        input.required = false;
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\budgets\edit.blade.php ENDPATH**/ ?>