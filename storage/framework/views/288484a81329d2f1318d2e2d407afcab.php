<?php $__env->startSection('title', __('budgets.page_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900"><?php echo e(__('budgets.page_heading')); ?></h1>
            <p class="text-gray-600 mt-1"><?php echo e(__('budgets.page_subtitle')); ?></p>
        </div>
        <a href="<?php echo e(localized_route('budgets.create')); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-300 shadow-lg">
            <i class="fas fa-plus mr-2"></i> <?php echo e(__('budgets.new_budget')); ?>

        </a>
    </div>

    <!-- Budgets Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_user')); ?></th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_category')); ?></th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_amount')); ?></th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_spent')); ?></th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_remaining')); ?></th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_month')); ?></th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_status')); ?></th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><?php echo e(__('budgets.table_actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo e($budget->user->name ?? __('budgets.unknown_user')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <?php echo e($budget->category); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            <?php echo e(number_format($budget->amount, 2)); ?> €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <?php echo e(number_format($budget->spent, 2)); ?> €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo e($budget->remaining >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <i class="fas <?php echo e($budget->remaining >= 0 ? 'fa-check-circle' : 'fa-exclamation-triangle'); ?> mr-1"></i>
                                <?php echo e(number_format($budget->remaining, 2)); ?> €
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <?php echo e($budget->month->format('M Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($budget->is_over_budget): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> <?php echo e(__('budgets.status_over_budget')); ?>

                                </span>
                            <?php elseif($budget->should_alert): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> <?php echo e(__('budgets.status_alert')); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> <?php echo e(__('budgets.status_ok')); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="<?php echo e(localized_route('budgets.edit', $budget)); ?>" class="inline-flex items-center px-3 py-2 border border-yellow-300 rounded-lg text-yellow-700 bg-yellow-50 hover:bg-yellow-100 transition-colors duration-200" title="<?php echo e(__('budgets.action_edit')); ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(localized_route('budgets.destroy', $budget)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-red-300 rounded-lg text-red-700 bg-red-50 hover:bg-red-100 transition-colors duration-200" title="<?php echo e(__('budgets.action_delete')); ?>" onclick="return confirm('<?php echo e(__('budgets.delete_confirm')); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-wallet text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(__('budgets.empty_title')); ?></h3>
                                <p class="text-gray-500 mb-6 max-w-sm"><?php echo e(__('budgets.empty_message')); ?></p>
                                <a href="<?php echo e(localized_route('budgets.create')); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-300 shadow-lg">
                                    <i class="fas fa-plus mr-2"></i> <?php echo e(__('budgets.empty_action')); ?>

                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($budgets->hasPages()): ?>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <?php echo e($budgets->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\budgets\index.blade.php ENDPATH**/ ?>