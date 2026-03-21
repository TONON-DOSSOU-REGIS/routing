<?php $__env->startPush('head'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --shell-bg: rgba(250, 248, 244, 0.92);
            --shell-border: rgba(15, 23, 42, 0.06);
            --panel-bg: rgba(255, 255, 255, 0.92);
            --panel-border: rgba(15, 23, 42, 0.08);
            --text-main: #101828;
            --text-muted: #667085;
            --accent: #167c5b;
            --accent-strong: #0f5b42;
            --accent-soft: #e8f8f1;
            --accent-soft-strong: rgba(22, 124, 91, 0.14);
            --shadow-soft: 0 20px 60px rgba(15, 23, 42, 0.08);
            --shadow-card: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .premium-theme-admin {
            --accent: #155eef;
            --accent-strong: #194185;
            --accent-soft: #e9f2ff;
            --accent-soft-strong: rgba(21, 94, 239, 0.14);
        }

        .premium-dashboard-body {
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(22, 124, 91, 0.14), transparent 34%),
                radial-gradient(circle at bottom right, rgba(21, 94, 239, 0.12), transparent 28%),
                linear-gradient(180deg, #f5f4f1 0%, #efeee8 100%);
            color: var(--text-main);
        }

        .premium-shell {
            position: relative;
            background: var(--shell-bg);
            border: 1px solid var(--shell-border);
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            overflow-x: clip;
        }

        .premium-sidebar {
            background: rgba(255, 255, 255, 0.98);
            border-right: 1px solid rgba(15, 23, 42, 0.06);
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: contain;
            touch-action: pan-y;
        }

        @media (max-width: 1023px) {
            .premium-sidebar {
                height: 100dvh;
                padding-bottom: calc(1.5rem + env(safe-area-inset-bottom));
            }
        }

        @media (min-width: 1024px) {
            .premium-sidebar {
                background:
                    linear-gradient(180deg, rgba(255, 255, 255, 0.78), rgba(255, 255, 255, 0.52)),
                    radial-gradient(circle at top, rgba(255, 255, 255, 0.95), transparent 60%);
            }
        }

        .premium-dashboard-body.is-sidebar-open {
            overflow: hidden;
        }

        .premium-brand-title,
        .premium-page-title {
            font-family: 'Sora', sans-serif;
        }

        .premium-nav-item {
            transition: transform 180ms ease, background-color 180ms ease, color 180ms ease, box-shadow 180ms ease;
        }

        .premium-nav-item:hover {
            transform: translateX(4px);
            background: rgba(255, 255, 255, 0.88);
            box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.06);
        }

        .premium-nav-item.is-active {
            background: linear-gradient(135deg, var(--accent-soft), rgba(255, 255, 255, 0.92));
            color: var(--accent-strong);
            box-shadow: inset 0 0 0 1px var(--accent-soft-strong);
        }

        .premium-dot {
            background: var(--accent);
            box-shadow: 0 0 0 5px rgba(22, 124, 91, 0.14);
        }

        .premium-panel {
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            box-shadow: var(--shadow-card);
        }

        /* Shared dashboard chrome should stay flat and simple. */
        .premium-dashboard-body .premium-shell,
        .premium-dashboard-body .premium-sidebar,
        .premium-dashboard-body .premium-nav-item,
        .premium-dashboard-body .premium-search,
        .premium-dashboard-body .premium-panel,
        .premium-dashboard-body .premium-gradient-card {
            border-radius: 0 !important;
        }

        .premium-card-hover {
            transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
        }

        .premium-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.12);
            border-color: rgba(15, 23, 42, 0.12);
        }

        .premium-search {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        .premium-search:focus-within {
            border-color: rgba(15, 23, 42, 0.18);
            box-shadow: 0 0 0 4px var(--accent-soft-strong);
        }

        .premium-soft-chip {
            background: var(--accent-soft);
            color: var(--accent-strong);
        }

        .premium-gradient-card {
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.24), transparent 34%),
                linear-gradient(135deg, var(--accent-strong), var(--accent));
            color: #fff;
            box-shadow: 0 22px 44px rgba(15, 23, 42, 0.18);
        }

        .premium-grid-glow::before {
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

        .premium-kpi-number {
            font-family: 'Sora', sans-serif;
            letter-spacing: -0.04em;
        }

        .premium-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .premium-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.55);
            border-radius: 999px;
        }

        .premium-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .premium-fade-in {
            animation: premiumFadeIn 420ms ease-out;
        }

        @keyframes premiumFadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('premium_dashboard_head'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $authUser = auth()->user();
        $dashboardTheme = trim($__env->yieldContent('dashboard_theme')) ?: 'client';
        $dashboardTitle = trim($__env->yieldContent('dashboard_page_title')) ?: 'Dashboard';
        $dashboardSubtitle = trim($__env->yieldContent('dashboard_page_subtitle')) ?: '';
        $dashboardSearchPlaceholder = trim($__env->yieldContent('dashboard_search_placeholder')) ?: 'Rechercher une action, un client ou un mouvement...';
        $dashboardSectionLabel = trim($__env->yieldContent('dashboard_section_label')) ?: ($dashboardTheme === 'admin' ? 'Pilotage central' : 'Espace premium');
        $dashboardFooterBrand = trim($__env->yieldContent('dashboard_footer_brand')) ?: ($dashboardTheme === 'admin' ? 'Valtrix Admin' : 'Valtrix Bank');
        $displayName = $authUser?->name ?? 'Utilisateur';
        $displayEmail = $authUser?->email ?? '';
        $profilePhotoUrl = $authUser?->profile_photo_url;
    ?>

    <div class="premium-dashboard-body min-h-screen overflow-x-clip <?php echo e($dashboardTheme === 'admin' ? 'premium-theme-admin' : ''); ?>">
        <div class="fixed inset-0 pointer-events-none">
            <div class="absolute left-[12%] top-[-8rem] h-72 w-72 rounded-full bg-emerald-300/20 blur-3xl"></div>
            <div class="absolute right-[10%] top-[18%] h-64 w-64 rounded-full bg-blue-300/20 blur-3xl"></div>
            <div class="absolute bottom-[-5rem] left-[36%] h-72 w-72 rounded-full bg-amber-200/20 blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <div class="premium-shell flex min-h-screen w-full overflow-hidden premium-fade-in">
                <aside
                    id="premium-dashboard-sidebar"
                    class="premium-sidebar premium-scroll fixed inset-y-0 left-0 z-30 w-[290px] max-w-[85vw] -translate-x-full overflow-y-auto p-6 shadow-2xl transition-transform duration-300 ease-out lg:static lg:inset-auto lg:z-auto lg:h-auto lg:w-[290px] lg:max-w-none lg:translate-x-0 lg:shadow-none"
                    aria-hidden="true"
                >
                    <div class="flex min-h-full flex-col gap-8">
                        <div class="flex items-center gap-4">
                            <a href="<?php echo e(localized_route('home')); ?>" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/70">
                                <img src="<?php echo e(asset('images/Logosite.png')); ?>" alt="Valtrix Bank" class="h-10 w-10 object-contain">
                            </a>
                            <div>
                                <p class="premium-brand-title text-lg font-semibold text-slate-900">
                                    <?php echo $__env->yieldContent('dashboard_brand_title', 'Valtrix Bank'); ?>
                                </p>
                                <p class="text-sm text-slate-500">
                                    <?php echo $__env->yieldContent('dashboard_brand_subtitle', $dashboardTheme === 'admin' ? 'Back office premium' : 'Client banking suite'); ?>
                                </p>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                    <?php echo $__env->yieldContent('sidebar_primary_title', 'Navigation'); ?>
                                </p>
                                <div class="space-y-2">
                                    <?php echo $__env->yieldContent('sidebar_primary'); ?>
                                </div>
                            </div>

                            <?php if (! empty(trim($__env->yieldContent('sidebar_secondary')))): ?>
                                <div>
                                    <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                        <?php echo $__env->yieldContent('sidebar_secondary_title', 'Operations'); ?>
                                    </p>
                                    <div class="space-y-2">
                                        <?php echo $__env->yieldContent('sidebar_secondary'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-auto">
                            <?php echo $__env->yieldContent('sidebar_footer'); ?>
                        </div>
                    </div>
                </aside>

                <div
                    id="premium-dashboard-sidebar-backdrop"
                    class="pointer-events-none absolute inset-0 z-20 bg-slate-950/28 opacity-0 transition-opacity duration-300 lg:hidden"
                ></div>

                <div class="relative z-10 flex min-w-0 flex-1 flex-col overflow-x-clip">
                    <header class="border-b border-slate-200/70 px-4 py-4 sm:px-6 lg:px-8">
                        <div class="flex flex-wrap items-center gap-3 lg:gap-4">
                            <button
                                type="button"
                                id="premium-dashboard-sidebar-toggle"
                                class="order-1 inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm lg:hidden"
                                aria-controls="premium-dashboard-sidebar"
                                aria-expanded="false"
                            >
                                <i class="fas fa-bars text-sm"></i>
                            </button>

                            <div class="order-2 ml-auto flex items-center gap-3 lg:ml-0">
                                <?php echo $__env->yieldContent('topbar_actions'); ?>
                                <?php echo $__env->make('components.notification-bell', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>

                            <div class="premium-search order-3 flex min-w-0 basis-full items-center gap-3 rounded-2xl px-4 py-3 lg:order-1 lg:min-w-[320px] lg:flex-1 lg:basis-auto 2xl:min-w-[420px]">
                                <i class="fas fa-search text-slate-400"></i>
                                <input
                                    type="text"
                                    class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-0"
                                    placeholder="<?php echo e($dashboardSearchPlaceholder); ?>"
                                >
                                <span class="hidden rounded-xl bg-slate-100 px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500 sm:inline-flex">
                                    <?php echo e(__('dashboard.search_quick_label')); ?>

                                </span>
                            </div>

                            <div class="order-4 hidden min-w-0 w-full items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-center shadow-sm sm:w-auto sm:justify-start sm:text-left lg:order-3 lg:flex">
                                <div class="hidden text-right sm:block">
                                    <p class="text-sm font-semibold text-slate-900"><?php echo e($displayName); ?></p>
                                    <p class="text-xs text-slate-500"><?php echo e($displayEmail); ?></p>
                                </div>
                                <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
                                    <?php if($profilePhotoUrl): ?>
                                        <img src="<?php echo e($profilePhotoUrl); ?>" alt="<?php echo e($displayName); ?>" class="h-full w-full object-cover">
                                    <?php else: ?>
                                        <span class="premium-brand-title text-sm font-semibold text-slate-700">
                                            <?php echo e(strtoupper(substr($authUser?->first_name ?? 'U', 0, 1) . substr($authUser?->last_name ?? '', 0, 1))); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 overflow-x-clip px-4 py-5 sm:px-6 lg:px-8">
                        <div class="mb-6 flex flex-col gap-5 2xl:flex-row 2xl:items-end 2xl:justify-between">
                            <div>
                                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 ring-1 ring-slate-200">
                                    <span class="premium-dot h-2 w-2 rounded-full"></span>
                                    <?php echo e($dashboardSectionLabel); ?>

                                </div>
                                <h1 class="premium-page-title text-3xl font-semibold tracking-[-0.04em] text-slate-950 sm:text-4xl">
                                    <?php echo e($dashboardTitle); ?>

                                </h1>
                                <?php if($dashboardSubtitle !== ''): ?>
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500 sm:text-base">
                                        <?php echo e($dashboardSubtitle); ?>

                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:flex-wrap sm:items-center">
                                <?php echo $__env->yieldContent('dashboard_header_actions'); ?>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <?php echo $__env->yieldContent('dashboard_content'); ?>
                        </div>
                    </main>

                    <footer class="border-t border-slate-200/70 bg-white/55 px-4 py-4 backdrop-blur-sm sm:px-6 lg:px-8">
                        <div class="flex flex-col items-center gap-3 text-center text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between lg:text-left">
                            <p class="max-w-2xl">
                                &copy; <?php echo e(date('Y')); ?>

                                <span class="font-semibold text-slate-900"><?php echo e($dashboardFooterBrand); ?></span>.
                                <?php echo e(__('home.footer_copyright')); ?>

                            </p>

                            <div class="flex flex-wrap items-center justify-center gap-3 text-center text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 lg:justify-end lg:text-right">
                                <a href="<?php echo e(localized_route('support.nous-contacter')); ?>" class="transition hover:text-slate-900">
                                    <?php echo e(__('home.footer_contact_us')); ?>

                                </a>
                                <a href="<?php echo e(localized_route('support.securite')); ?>" class="transition hover:text-slate-900">
                                    <?php echo e(__('home.footer_security')); ?>

                                </a>
                                <a href="<?php echo e(localized_route('support.mentions-legales')); ?>" class="transition hover:text-slate-900">
                                    <?php echo e(__('home.footer_legal')); ?>

                                </a>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        <?php echo $__env->yieldContent('dashboard_overlays'); ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dashboardBody = document.querySelector('.premium-dashboard-body');
            const sidebar = document.getElementById('premium-dashboard-sidebar');
            const toggleButton = document.getElementById('premium-dashboard-sidebar-toggle');
            const backdrop = document.getElementById('premium-dashboard-sidebar-backdrop');
            const html = document.documentElement;

            if (!dashboardBody || !sidebar || !toggleButton || !backdrop) {
                return;
            }

            const setSidebarState = (isOpen) => {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.add('pointer-events-none', 'opacity-0');
                    dashboardBody.classList.remove('is-sidebar-open');
                    html.classList.remove('overflow-hidden');
                    toggleButton.setAttribute('aria-expanded', 'false');
                    sidebar.setAttribute('aria-hidden', 'false');
                    return;
                }

                sidebar.classList.toggle('-translate-x-full', !isOpen);
                backdrop.classList.toggle('pointer-events-none', !isOpen);
                backdrop.classList.toggle('opacity-0', !isOpen);
                dashboardBody.classList.toggle('is-sidebar-open', isOpen);
                html.classList.toggle('overflow-hidden', isOpen);
                toggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                sidebar.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
            };

            const closeSidebar = () => {
                setSidebarState(false);
            };

            setSidebarState(false);
            toggleButton.addEventListener('click', function () {
                const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
                setSidebarState(!isExpanded);
            });
            backdrop.addEventListener('click', closeSidebar);
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });
            window.addEventListener('resize', function () {
                setSidebarState(false);
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('premium_dashboard_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerveau\resources\views\layouts\premium-dashboard.blade.php ENDPATH**/ ?>