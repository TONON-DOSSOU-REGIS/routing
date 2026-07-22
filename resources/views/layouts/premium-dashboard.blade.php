@extends('layouts.app')

@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --shell-bg: rgba(244, 248, 253, 0.94);
            --shell-border: rgba(255, 255, 255, 0.14);
            --panel-bg: rgba(255, 255, 255, 0.9);
            --panel-border: rgba(112, 133, 159, 0.14);
            --text-main: #091a31;
            --text-muted: #607089;
            --accent: #0b5cff;
            --accent-strong: #063b8f;
            --accent-cyan: #00b8d9;
            --accent-gold: #f5b544;
            --accent-soft: #eaf2ff;
            --accent-soft-strong: rgba(11, 92, 255, 0.14);
            --shadow-soft: 0 28px 80px rgba(2, 16, 35, 0.22);
            --shadow-card: 0 18px 42px rgba(7, 29, 57, 0.1);
        }

        .premium-theme-admin {
            --accent: #4f46e5;
            --accent-strong: #253481;
            --accent-cyan: #22d3ee;
            --accent-soft: #eef0ff;
            --accent-soft-strong: rgba(79, 70, 229, 0.15);
        }

        .premium-dashboard-body {
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at 10% 8%, rgba(0, 184, 217, 0.18), transparent 26%),
                radial-gradient(circle at 92% 12%, rgba(11, 92, 255, 0.22), transparent 28%),
                linear-gradient(145deg, #03101f 0%, #071a2f 48%, #0a2642 100%);
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
            overflow-y: visible;
        }

        .premium-sidebar {
            color: #fff;
            background:
                radial-gradient(circle at 20% 4%, rgba(0, 184, 217, .18), transparent 24%),
                linear-gradient(180deg, #071d35 0%, #041426 100%);
            border-right: 1px solid rgba(142, 233, 255, 0.12);
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: contain;
            touch-action: pan-y;
        }

        .premium-sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .24;
            background-image:
                linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
            background-size: 24px 24px;
            mask-image: linear-gradient(to bottom, #000, transparent 72%);
            pointer-events: none;
        }

        .premium-sidebar > * {
            position: relative;
            z-index: 1;
        }

        .premium-sidebar .premium-brand-title,
        .premium-sidebar .text-slate-900 {
            color: #fff !important;
        }

        .premium-sidebar .text-slate-400,
        .premium-sidebar .text-slate-500,
        .premium-sidebar .text-slate-600 {
            color: rgba(255, 255, 255, .62) !important;
        }

        .premium-sidebar-brand {
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .premium-sidebar-close {
            display: none;
            width: 2.65rem;
            height: 2.65rem;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,.14);
            border-radius: 14px;
            color: #fff;
            background: rgba(255,255,255,.08);
        }

        @media (max-width: 1023px) {
            .premium-sidebar {
                height: 100dvh;
                padding-bottom: calc(1.5rem + env(safe-area-inset-bottom));
                border-radius: 0 28px 28px 0;
            }

            .premium-sidebar-close { display: inline-flex; }
        }

        @media (min-width: 1024px) {
            .premium-dashboard-body { padding: 14px; }

            .premium-shell {
                min-height: calc(100vh - 28px) !important;
                border-radius: 30px;
            }

            .premium-sidebar {
                position: relative !important;
                border-radius: 29px 0 0 29px;
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
            position: relative;
            border: 1px solid transparent;
            transition: transform 200ms ease, background-color 200ms ease, color 200ms ease, box-shadow 200ms ease, border-color 200ms ease;
        }

        .premium-nav-item:hover {
            transform: translateX(5px);
            color: #fff !important;
            background: rgba(255, 255, 255, 0.085);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 12px 28px rgba(0, 8, 24, .18);
        }

        .premium-nav-item.is-active {
            color: #fff !important;
            background: linear-gradient(135deg, rgba(11, 92, 255, .82), rgba(0, 184, 217, .42));
            border-color: rgba(142, 233, 255, .24);
            box-shadow: 0 16px 34px rgba(0, 24, 58, .3), inset 0 1px 0 rgba(255,255,255,.16);
        }

        .premium-theme-admin .premium-nav-item.is-active {
            background: linear-gradient(135deg, rgba(79, 70, 229, .9), rgba(8, 145, 178, .58));
        }

        .premium-nav-item > span[class*="h-10"][class*="w-10"],
        .premium-nav-item > span:first-child > span[class*="h-10"][class*="w-10"] {
            color: #8ee9ff !important;
            background: rgba(255,255,255,.08) !important;
            border-color: rgba(255,255,255,.1) !important;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.08) !important;
        }

        .premium-nav-item.is-active > span[class*="h-10"][class*="w-10"],
        .premium-nav-item.is-active > span:first-child > span[class*="h-10"][class*="w-10"] {
            color: #fff !important;
            background: rgba(255,255,255,.16) !important;
            border-color: rgba(255,255,255,.18) !important;
        }

        .premium-dot {
            background: var(--accent);
            box-shadow: 0 0 0 5px rgba(22, 124, 91, 0.14);
        }

        .premium-panel {
            --premium-card-rx: 0deg;
            --premium-card-ry: 0deg;
            --premium-card-light-x: 50%;
            --premium-card-light-y: 20%;
            position: relative;
            isolation: isolate;
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            box-shadow: var(--shadow-card);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .premium-panel::before {
            content: "";
            position: absolute;
            z-index: -1;
            inset: 0;
            border-radius: inherit;
            background:
                radial-gradient(420px circle at var(--premium-card-light-x) var(--premium-card-light-y), rgba(11, 92, 255, .12), transparent 48%),
                linear-gradient(115deg, transparent 25%, rgba(255, 255, 255, .7) 46%, transparent 65%);
            background-size: 100% 100%, 240% 100%;
            background-position: center, 130% 0;
            opacity: .48;
            pointer-events: none;
            transition: opacity 320ms ease, background-position 700ms cubic-bezier(.22, 1, .36, 1);
        }

        .premium-card-hover {
            transform: perspective(1200px) translate3d(0, 0, 0) rotateX(var(--premium-card-rx)) rotateY(var(--premium-card-ry));
            transform-style: preserve-3d;
            transition: transform 320ms cubic-bezier(.22, 1, .36, 1), box-shadow 320ms ease, border-color 320ms ease;
        }

        .premium-card-hover:hover,
        .premium-card-hover:focus-within {
            transform: perspective(1200px) translate3d(0, -6px, 0) rotateX(var(--premium-card-rx)) rotateY(var(--premium-card-ry));
            box-shadow: 0 30px 58px rgba(7, 29, 57, 0.16);
            border-color: rgba(11, 92, 255, 0.28);
        }

        .premium-card-hover:hover::before,
        .premium-card-hover:focus-within::before {
            opacity: .9;
            background-position: center, -90% 0;
        }

        .premium-search {
            background: rgba(246, 249, 253, 0.9);
            border: 1px solid rgba(112, 133, 159, 0.16);
            box-shadow: inset 0 1px 0 #fff, 0 10px 24px rgba(7, 29, 57, .05);
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .premium-search:focus-within {
            background: #fff;
            border-color: rgba(11, 92, 255, 0.36);
            box-shadow: 0 0 0 4px var(--accent-soft-strong), 0 14px 30px rgba(7, 29, 57, .08);
        }

        .premium-soft-chip {
            background: var(--accent-soft);
            color: var(--accent-strong);
        }

        .premium-gradient-card {
            --premium-card-rx: 0deg;
            --premium-card-ry: 0deg;
            --premium-card-light-x: 50%;
            --premium-card-light-y: 20%;
            position: relative;
            isolation: isolate;
            background:
                radial-gradient(circle at 86% 8%, rgba(142, 233, 255, 0.28), transparent 30%),
                radial-gradient(circle at 8% 100%, rgba(245, 181, 68, .14), transparent 32%),
                linear-gradient(135deg, #061a32 0%, var(--accent-strong) 48%, var(--accent) 100%);
            color: #fff;
            border: 1px solid rgba(142, 233, 255, .18);
            box-shadow: 0 26px 54px rgba(4, 24, 48, 0.25), inset 0 1px 0 rgba(255,255,255,.12);
        }

        .premium-gradient-card::after {
            content: "";
            position: absolute;
            z-index: -1;
            width: 22rem;
            height: 22rem;
            left: var(--premium-card-light-x);
            top: var(--premium-card-light-y);
            border-radius: 999px;
            background: rgba(142, 233, 255, .18);
            filter: blur(55px);
            opacity: .48;
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: left 180ms ease-out, top 180ms ease-out, opacity 320ms ease;
        }

        .premium-gradient-card:hover::after,
        .premium-gradient-card:focus-within::after {
            opacity: .78;
        }

        .premium-topbar {
            position: sticky;
            z-index: 18;
            top: 0;
            background: rgba(248, 251, 255, .82);
            border-color: rgba(112, 133, 159, .12) !important;
            box-shadow: 0 10px 30px rgba(7, 29, 57, .05);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
        }

        .premium-user-pill {
            background: rgba(255,255,255,.82) !important;
            border-color: rgba(112, 133, 159, .14) !important;
            box-shadow: 0 12px 28px rgba(7, 29, 57, .07) !important;
        }

        .premium-main {
            background:
                radial-gradient(circle at 96% 2%, rgba(11, 92, 255, .075), transparent 23%),
                linear-gradient(180deg, rgba(247,250,254,.62), rgba(239,245,251,.72));
        }

        .premium-page-header {
            position: relative;
            padding: .4rem 0 .25rem;
        }

        .premium-dashboard-footer {
            background: rgba(255,255,255,.68) !important;
            border-color: rgba(112,133,159,.12) !important;
        }

        .premium-content-stack > * {
            animation: premiumCardReveal .52s cubic-bezier(.22, 1, .36, 1) backwards;
        }

        .premium-content-stack > *:nth-child(2) { animation-delay: 70ms; }
        .premium-content-stack > *:nth-child(3) { animation-delay: 130ms; }
        .premium-content-stack > *:nth-child(4) { animation-delay: 190ms; }

        @keyframes premiumCardReveal {
            from { opacity: 0; transform: translateY(18px) scale(.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
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

        @media (prefers-reduced-motion: reduce) {
            .premium-fade-in,
            .premium-content-stack > * {
                animation: none;
            }

            .premium-card-hover,
            .premium-nav-item {
                transition: none;
            }

            .premium-card-hover,
            .premium-card-hover:hover,
            .premium-card-hover:focus-within {
                transform: none;
            }
        }
    </style>
    @stack('premium_dashboard_head')
@endpush

@section('content')
    @php
        $authUser = auth()->user();
        $dashboardTheme = trim($__env->yieldContent('dashboard_theme')) ?: 'client';
        $dashboardTitle = html_entity_decode(trim($__env->yieldContent('dashboard_page_title')) ?: 'Dashboard', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $dashboardSubtitle = html_entity_decode(trim($__env->yieldContent('dashboard_page_subtitle')) ?: '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $dashboardSearchPlaceholder = html_entity_decode(trim($__env->yieldContent('dashboard_search_placeholder')) ?: __('admin_pages.dashboard_search_default'), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $dashboardSectionLabel = html_entity_decode(trim($__env->yieldContent('dashboard_section_label')) ?: ($dashboardTheme === 'admin' ? __('admin_pages.central_pilotage') : __('admin_pages.premium_space')), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $dashboardFooterBrand = html_entity_decode(trim($__env->yieldContent('dashboard_footer_brand')) ?: ($dashboardTheme === 'admin' ? 'Zuider Admin' : 'Zuider Bank S.A'), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $displayName = $authUser?->name ?? __('common.user');
        $displayEmail = $authUser?->email ?? '';
        $profilePhotoUrl = $authUser?->profile_photo_url;
    @endphp

    <div class="premium-dashboard-body min-h-screen overflow-x-clip {{ $dashboardTheme === 'admin' ? 'premium-theme-admin' : '' }}">
        <div class="fixed inset-0 pointer-events-none">
            <div class="absolute left-[12%] top-[-8rem] h-72 w-72 rounded-full bg-emerald-300/20 blur-3xl"></div>
            <div class="absolute right-[10%] top-[18%] h-64 w-64 rounded-full bg-blue-300/20 blur-3xl"></div>
            <div class="absolute bottom-[-5rem] left-[36%] h-72 w-72 rounded-full bg-amber-200/20 blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <div class="premium-shell flex min-h-screen w-full overflow-hidden premium-fade-in">
                <aside
                    id="premium-dashboard-sidebar"
                    data-mobile-menu-autoclose="true"
                    class="premium-sidebar premium-scroll fixed inset-y-0 left-0 z-30 w-[290px] max-w-[85vw] -translate-x-full overflow-y-auto p-6 shadow-2xl transition-transform duration-300 ease-out lg:static lg:inset-auto lg:z-auto lg:h-auto lg:w-[290px] lg:max-w-none lg:translate-x-0 lg:shadow-none"
                    aria-hidden="true"
                >
                    <div class="flex min-h-full flex-col gap-8">
                        <div class="premium-sidebar-brand flex items-center justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-4">
                                <a href="{{ localized_route('home') }}" class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white shadow-xl shadow-slate-950/20 ring-1 ring-white/20">
                                    <img src="{{ asset('images/Logosite.png') }}" alt="Zuider Bank S.A" class="h-10 w-10 object-contain">
                                </a>
                                <div class="min-w-0">
                                    <p class="premium-brand-title truncate text-lg font-semibold text-slate-900">
                                        @yield('dashboard_brand_title', 'Zuider Bank S.A')
                                    </p>
                                    <p class="truncate text-sm text-slate-500">
                                        @yield('dashboard_brand_subtitle', $dashboardTheme === 'admin' ? 'Back office premium' : 'Client banking suite')
                                    </p>
                                    <span class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-white/8 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-cyan-200 ring-1 ring-white/10">
                                        <i class="fas fa-gem text-[9px] text-amber-300"></i>
                                        {{ $dashboardTheme === 'admin' ? 'Executive' : 'Premium' }}
                                    </span>
                                </div>
                            </div>
                            <button type="button" id="premium-dashboard-sidebar-close" class="premium-sidebar-close" aria-label="Fermer le menu">
                                <i class="fas fa-xmark"></i>
                            </button>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                    @yield('sidebar_primary_title', 'Navigation')
                                </p>
                                <div class="space-y-2">
                                    @yield('sidebar_primary')
                                </div>
                            </div>

                            @hasSection('sidebar_secondary')
                                <div>
                                    <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">
                                        @yield('sidebar_secondary_title', 'Operations')
                                    </p>
                                    <div class="space-y-2">
                                        @yield('sidebar_secondary')
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-auto">
                            @yield('sidebar_footer')
                        </div>
                    </div>
                </aside>

                <div
                    id="premium-dashboard-sidebar-backdrop"
                    class="pointer-events-none absolute inset-0 z-20 bg-slate-950/28 opacity-0 transition-opacity duration-300 lg:hidden"
                ></div>

                <div class="relative z-10 flex min-w-0 flex-1 flex-col overflow-x-clip">
                    <header class="premium-topbar border-b border-slate-200/70 px-4 py-4 sm:px-6 lg:px-8">
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
                                @yield('topbar_actions')
                                @include('components.notification-bell')
                            </div>

                            <div class="premium-search order-3 flex min-w-0 basis-full items-center gap-3 rounded-2xl px-4 py-3 lg:order-1 lg:min-w-[320px] lg:flex-1 lg:basis-auto 2xl:min-w-[420px]">
                                <i class="fas fa-search text-slate-400"></i>
                                <input
                                    type="text"
                                    class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-0"
                                    placeholder="{{ $dashboardSearchPlaceholder }}"
                                >
                                <span class="hidden rounded-xl bg-slate-100 px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500 sm:inline-flex">
                                    {{ __('dashboard.search_quick_label') }}
                                </span>
                            </div>

                            <div class="premium-user-pill order-4 hidden min-w-0 w-full items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-center shadow-sm sm:w-auto sm:justify-start sm:text-left lg:order-3 lg:flex">
                                <div class="hidden text-right sm:block">
                                    <p class="text-sm font-semibold text-slate-900">{{ $displayName }}</p>
                                    <p class="text-xs text-slate-500">{{ $displayEmail }}</p>
                                </div>
                                <div class="relative flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
                                    @if($profilePhotoUrl)
                                        <img src="{{ $profilePhotoUrl }}" alt="{{ $displayName }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="premium-brand-title text-sm font-semibold text-slate-700">
                                            {{ strtoupper(substr($authUser?->first_name ?? 'U', 0, 1) . substr($authUser?->last_name ?? '', 0, 1)) }}
                                        </span>
                                    @endif
                                    <span class="absolute bottom-0.5 right-0.5 h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="premium-main flex-1 overflow-x-clip px-4 py-5 sm:px-6 lg:px-8 lg:py-7">
                        <div class="premium-page-header mb-6 flex flex-col gap-5 2xl:flex-row 2xl:items-end 2xl:justify-between">
                            <div>
                                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 ring-1 ring-slate-200">
                                    <span class="premium-dot h-2 w-2 rounded-full"></span>
                                    {{ $dashboardSectionLabel }}
                                </div>
                                <h1 class="premium-page-title text-3xl font-semibold tracking-[-0.04em] text-slate-950 sm:text-4xl">
                                    {{ $dashboardTitle }}
                                </h1>
                                @if($dashboardSubtitle !== '')
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500 sm:text-base">
                                        {{ $dashboardSubtitle }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:flex-wrap sm:items-center">
                                @yield('dashboard_header_actions')
                            </div>
                        </div>

                        <div class="premium-content-stack space-y-6" data-premium-card-system="ultra">
                            @yield('dashboard_content')
                        </div>
                    </main>

                    <footer class="premium-dashboard-footer border-t border-slate-200/70 bg-white/55 px-4 py-4 backdrop-blur-sm sm:px-6 lg:px-8">
                        <div class="flex flex-col items-center gap-3 text-center text-sm text-slate-500 lg:flex-row lg:items-center lg:justify-between lg:text-left">
                            <p class="max-w-2xl">
                                &copy; {{ date('Y') }}
                                <span class="font-semibold text-slate-900">{{ $dashboardFooterBrand }}</span>.
                                {{ __('home.footer_copyright') }}
                            </p>

                            <div class="flex flex-wrap items-center justify-center gap-3 text-center text-xs font-semibold uppercase tracking-[0.16em] text-slate-500 lg:justify-end lg:text-right">
                                <a href="{{ localized_route('support.nous-contacter') }}" class="transition hover:text-slate-900">
                                    {{ __('home.footer_contact_us') }}
                                </a>
                                <a href="{{ localized_route('support.securite') }}" class="transition hover:text-slate-900">
                                    {{ __('home.footer_security') }}
                                </a>
                                <a href="{{ localized_route('support.mentions-legales') }}" class="transition hover:text-slate-900">
                                    {{ __('home.footer_legal') }}
                                </a>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        @yield('dashboard_overlays')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dashboardBody = document.querySelector('.premium-dashboard-body');
            const sidebar = document.getElementById('premium-dashboard-sidebar');
            const toggleButton = document.getElementById('premium-dashboard-sidebar-toggle');
            const closeButton = document.getElementById('premium-dashboard-sidebar-close');
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
            closeButton?.addEventListener('click', closeSidebar);
            backdrop.addEventListener('click', closeSidebar);
            sidebar.addEventListener('click', function (event) {
                if (window.innerWidth < 1024 && event.target.closest('a[href], button[type="submit"]')) {
                    closeSidebar();
                }
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });
            window.addEventListener('resize', function () {
                setSidebarState(false);
            });
            window.addEventListener('pageshow', function () {
                setSidebarState(false);
            });
            window.addEventListener('pagehide', closeSidebar);

            const canAnimateCards = window.matchMedia('(hover: hover) and (pointer: fine)').matches
                && !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (canAnimateCards) {
                document.querySelectorAll('.premium-card-hover').forEach((card) => {
                    card.addEventListener('pointermove', (event) => {
                        const bounds = card.getBoundingClientRect();
                        const x = Math.min(Math.max(event.clientX - bounds.left, 0), bounds.width);
                        const y = Math.min(Math.max(event.clientY - bounds.top, 0), bounds.height);
                        const xRatio = x / bounds.width;
                        const yRatio = y / bounds.height;

                        card.style.setProperty('--premium-card-rx', `${((.5 - yRatio) * 2.2).toFixed(2)}deg`);
                        card.style.setProperty('--premium-card-ry', `${((xRatio - .5) * 2.8).toFixed(2)}deg`);
                        card.style.setProperty('--premium-card-light-x', `${(xRatio * 100).toFixed(1)}%`);
                        card.style.setProperty('--premium-card-light-y', `${(yRatio * 100).toFixed(1)}%`);
                    }, { passive: true });

                    card.addEventListener('pointerleave', () => {
                        card.style.setProperty('--premium-card-rx', '0deg');
                        card.style.setProperty('--premium-card-ry', '0deg');
                        card.style.setProperty('--premium-card-light-x', '50%');
                        card.style.setProperty('--premium-card-light-y', '20%');
                    });
                });
            }
        });
    </script>
    @stack('premium_dashboard_scripts')
@endsection
