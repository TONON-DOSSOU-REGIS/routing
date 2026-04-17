<?php $__env->startPush('head'); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --auth-bg: #f5f4ef;
            --auth-surface: rgba(255, 255, 255, 0.82);
            --auth-surface-strong: rgba(255, 255, 255, 0.92);
            --auth-border: rgba(15, 23, 42, 0.08);
            --auth-text: #0f172a;
            --auth-muted: #64748b;
            --auth-accent: #f97316;
            --auth-accent-strong: #c2410c;
            --auth-accent-soft: rgba(249, 115, 22, 0.12);
            --auth-shadow: 0 24px 64px rgba(15, 23, 42, 0.16);
            --auth-shadow-soft: 0 16px 34px rgba(15, 23, 42, 0.08);
        }

        .auth-premium-page {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            font-family: 'Manrope', sans-serif;
            color: var(--auth-text);
            background:
                radial-gradient(circle at top left, rgba(249, 115, 22, 0.14), transparent 34%),
                radial-gradient(circle at right 18%, rgba(37, 99, 235, 0.12), transparent 26%),
                linear-gradient(180deg, #f8f5ee 0%, #f2efe7 100%);
        }

        .auth-premium-page::before,
        .auth-premium-page::after {
            content: "";
            position: fixed;
            border-radius: 999px;
            filter: blur(48px);
            pointer-events: none;
        }

        .auth-premium-page::before {
            top: -6rem;
            left: -4rem;
            width: 20rem;
            height: 20rem;
            background: rgba(249, 115, 22, 0.16);
        }

        .auth-premium-page::after {
            right: -4rem;
            bottom: -8rem;
            width: 24rem;
            height: 24rem;
            background: rgba(37, 99, 235, 0.14);
        }

        .auth-premium-shell {
            position: relative;
            z-index: 1;
        }

        .auth-nav,
        .auth-hero-card,
        .auth-form-card,
        .auth-footer-card {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--auth-border);
            box-shadow: var(--auth-shadow-soft);
        }

        .auth-nav,
        .auth-footer-card {
            background: rgba(255, 255, 255, 0.76);
        }

        .auth-nav {
            position: relative;
            z-index: 60;
            overflow: visible;
        }

        .auth-hero-card {
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.28), transparent 30%),
                linear-gradient(145deg, rgba(15, 23, 42, 0.94), rgba(30, 41, 59, 0.9));
            color: #fff;
            box-shadow: var(--auth-shadow);
        }

        .auth-form-card {
            background: linear-gradient(180deg, var(--auth-surface-strong), var(--auth-surface));
        }

        .auth-grid-glow::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 18px 18px;
            opacity: 0.45;
            pointer-events: none;
        }

        .auth-brand-title,
        .auth-heading {
            font-family: 'Sora', sans-serif;
        }

        .auth-chip {
            display: inline-flex;
            align-items: center;
            gap: .625rem;
            border-radius: 999px;
            padding: .75rem 1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.9);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .auth-chip-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 999px;
            background: rgba(249, 115, 22, 0.18);
            color: #fdba74;
        }

        .auth-stat-card {
            border-radius: 1.5rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 1rem 1.1rem;
        }

        .auth-stat-card p:first-child {
            color: rgba(255, 255, 255, 0.66);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .auth-input {
            background: rgba(248, 250, 252, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.26);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72);
            transition: border-color .18s, box-shadow .18s, background-color .18s;
        }

        .auth-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(249, 115, 22, 0.36);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.12);
        }

        .auth-submit {
            background: linear-gradient(135deg, var(--auth-accent), #fb923c);
            box-shadow: 0 18px 34px rgba(249, 115, 22, 0.28);
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .auth-submit:hover {
            transform: translateY(-1px);
            filter: saturate(1.05);
            box-shadow: 0 22px 40px rgba(249, 115, 22, 0.32);
        }

        .auth-submit:focus-visible {
            outline: none;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.16), 0 18px 34px rgba(249, 115, 22, 0.28);
        }

        .auth-link-btn {
            transition: transform .18s ease, border-color .18s ease, background-color .18s ease, color .18s ease;
        }

        .auth-link-btn:hover {
            transform: translateY(-1px);
        }

        .auth-nav-links {
            position: relative;
            z-index: 61;
        }

        .auth-panel-divider {
            position: relative;
            text-align: center;
        }

        .auth-panel-divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            border-top: 1px solid rgba(148, 163, 184, 0.24);
        }

        .auth-panel-divider span {
            position: relative;
            z-index: 1;
            display: inline-block;
            padding: 0 .85rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(255, 255, 255, 0.9));
            color: var(--auth-muted);
        }

        .auth-fade-in {
            animation: authFadeIn .42s ease-out;
        }

        @keyframes authFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1023px) {
            .auth-nav-links {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('auth_premium_head'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="auth-premium-page">
        <div class="auth-premium-shell px-4 py-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl auth-fade-in">
                <nav class="auth-nav rounded-[28px] px-5 py-4 sm:px-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center gap-4">
                            <a href="<?php echo e(localized_route('home')); ?>" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/80">
                                <img src="<?php echo e(asset('images/Logosite.png')); ?>" alt="Valtrix Bank" class="h-10 w-10 object-contain">
                            </a>
                            <div>
                                <p class="auth-brand-title text-lg font-semibold text-slate-950">Valtrix Bank</p>
                                <p class="text-sm text-slate-500"><?php echo $__env->yieldContent('auth_nav_subtitle', 'Accès client sécurisé'); ?></p>
                            </div>
                        </div>

                        <div class="auth-nav-links flex flex-col gap-3 sm:flex-row sm:items-center">
                            <div class="sm:min-w-[130px]">
                                <?php echo $__env->make('components.language-selector', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                            <?php echo $__env->yieldContent('auth_nav_actions'); ?>
                        </div>
                    </div>
                </nav>

                <main class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.08fr)_minmax(420px,520px)]">
                    <section class="auth-hero-card auth-grid-glow relative overflow-hidden rounded-[34px] px-6 py-7 sm:px-8 sm:py-9">
                        <div class="relative z-10">
                            <?php echo $__env->yieldContent('auth_hero'); ?>
                        </div>
                    </section>

                    <section class="auth-form-card rounded-[34px] px-6 py-7 sm:px-8 sm:py-9">
                        <?php echo $__env->yieldContent('auth_panel'); ?>
                    </section>
                </main>

                <footer class="auth-footer-card mt-6 rounded-[28px] px-5 py-4 sm:px-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Valtrix Bank</p>
                            <p class="mt-1 text-sm text-slate-500">&copy; <?php echo e(date('Y')); ?> <?php echo e(__('auth.footer_copyright')); ?></p>
                        </div>
                        <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-600">
                            <a href="<?php echo e(localized_route('support.nous-contacter')); ?>" class="transition hover:text-slate-900"><?php echo e(__('auth.footer_support')); ?></a>
                            <a href="<?php echo e(localized_route('support.securite')); ?>" class="transition hover:text-slate-900"><?php echo e(__('auth.footer_terms')); ?></a>
                            <a href="<?php echo e(localized_route('support.mentions-legales')); ?>" class="transition hover:text-slate-900"><?php echo e(__('auth.footer_privacy')); ?></a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('auth_premium_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\layouts\auth-premium.blade.php ENDPATH**/ ?>