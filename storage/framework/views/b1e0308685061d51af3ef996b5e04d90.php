<?php
    $adminNavActive = trim($__env->yieldContent('admin_nav_active', ''));
?>

<?php $__env->startSection('title', trim($__env->yieldContent('title', 'Administration - Valtrix Bank'))); ?>
<?php $__env->startSection('dashboard_theme', 'admin'); ?>
<?php $__env->startSection('dashboard_page_title', trim($__env->yieldContent('dashboard_page_title', 'Administration premium'))); ?>
<?php $__env->startSection('dashboard_page_subtitle', trim($__env->yieldContent('dashboard_page_subtitle', 'Un poste de pilotage premium pour les opérations critiques, les validations et la supervision.'))); ?>
<?php $__env->startSection('dashboard_section_label', trim($__env->yieldContent('dashboard_section_label', 'Pilotage admin'))); ?>
<?php $__env->startSection('dashboard_search_placeholder', 'Rechercher un client, une transaction, une opération ou un statut...'); ?>
<?php $__env->startSection('dashboard_brand_title', 'Valtrix Admin'); ?>
<?php $__env->startSection('dashboard_brand_subtitle', 'Centre de contrôle'); ?>
<?php $__env->startSection('sidebar_primary_title', 'Navigation'); ?>
<?php $__env->startSection('sidebar_secondary_title', 'Opérations'); ?>

<?php $__env->startSection('sidebar_primary'); ?>
    <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="premium-nav-item <?php echo e($adminNavActive === 'dashboard' ? 'is-active text-slate-900' : 'text-slate-600'); ?> flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl <?php echo e($adminNavActive === 'dashboard' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70'); ?> shadow-sm"><i class="fas fa-chart-line"></i></span>
        <span>Tableau de bord</span>
    </a>
    <a href="<?php echo e(localized_route('admin.users')); ?>" class="premium-nav-item <?php echo e(in_array($adminNavActive, ['users', 'users-create'], true) ? 'is-active text-slate-900' : 'text-slate-600'); ?> flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl <?php echo e(in_array($adminNavActive, ['users', 'users-create'], true) ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70'); ?> shadow-sm"><i class="fas fa-users"></i></span>
        <span>Utilisateurs</span>
    </a>
    <a href="<?php echo e(localized_route('admin.transactions')); ?>" class="premium-nav-item <?php echo e($adminNavActive === 'transactions' ? 'is-active text-slate-900' : 'text-slate-600'); ?> flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl <?php echo e($adminNavActive === 'transactions' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70'); ?> shadow-sm"><i class="fas fa-exchange-alt"></i></span>
        <span>Virements</span>
    </a>
    <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="premium-nav-item <?php echo e($adminNavActive === 'deposit' ? 'is-active text-slate-900' : 'text-slate-600'); ?> flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl <?php echo e($adminNavActive === 'deposit' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70'); ?> shadow-sm"><i class="fas fa-plus-circle"></i></span>
        <span>Dépôt</span>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_secondary'); ?>
    <a href="<?php echo e(localized_route('admin.settings')); ?>" class="premium-nav-item <?php echo e($adminNavActive === 'settings' ? 'is-active text-slate-900' : 'text-slate-600'); ?> flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl <?php echo e($adminNavActive === 'settings' ? 'bg-white text-blue-700 ring-1 ring-slate-200' : 'bg-white/70 text-slate-500 ring-1 ring-slate-200/70'); ?> shadow-sm"><i class="fas fa-gear"></i></span>
        <span>Paramètres</span>
    </a>
    <a href="<?php echo e(localized_route('admin.export.pdf')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-file-pdf"></i></span>
        <span>Export PDF</span>
    </a>
    <a href="<?php echo e(localized_route('admin.export.excel')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-file-excel"></i></span>
        <span>Export Excel</span>
    </a>
    <a href="<?php echo e(localized_route('home')); ?>" class="premium-nav-item flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-600">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-arrow-left"></i></span>
        <span>Retour au site</span>
    </a>
    <form method="POST" action="<?php echo e(localized_route('logout')); ?>"><?php echo csrf_field(); ?>
        <button type="submit" class="premium-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-500 shadow-sm ring-1 ring-slate-200/70"><i class="fas fa-right-from-bracket"></i></span>
            <span>Déconnexion</span>
        </button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_footer'); ?>
    <div class="premium-gradient-card premium-grid-glow relative overflow-hidden rounded-[26px] p-5">
        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/65">Pilotage</p>
            <h3 class="mt-3 premium-brand-title text-xl font-semibold">Couverture active</h3>
            <p class="mt-2 text-sm leading-6 text-white/78"><?php echo e($activeUsersRate); ?>% du parc client est actif. Les files prioritaires et le chat admin restent accessibles depuis ce centre de pilotage.</p>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-white/10 px-4 py-3"><p class="text-xs uppercase tracking-[0.16em] text-white/60">Alertes</p><p class="mt-2 text-lg font-semibold"><?php echo e($unreadNotificationsCount); ?></p></div>
                <div class="rounded-2xl bg-white/10 px-4 py-3"><p class="text-xs uppercase tracking-[0.16em] text-white/60">Chat</p><p class="mt-2 text-lg font-semibold"><?php echo e($chatUnreadCount); ?></p></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <div class="hidden items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 ring-1 ring-slate-200 md:inline-flex">
        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
        Supervision active
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard_overlays'); ?>
    <?php echo $__env->yieldContent('admin_dashboard_overlays'); ?>
    <?php echo $__env->make('components.admin-chat-widget-v2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.premium-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views/layouts/admin-premium.blade.php ENDPATH**/ ?>