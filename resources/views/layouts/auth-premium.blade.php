@extends('layouts.app')

@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --auth-navy: #06172b;
            --auth-navy-soft: #0b2848;
            --auth-blue: #0b5cff;
            --auth-cyan: #00b8d9;
            --auth-surface: rgba(255, 255, 255, 0.94);
            --auth-border: rgba(255, 255, 255, 0.14);
            --auth-text: #0a1930;
            --auth-muted: #607089;
            --auth-shadow: 0 34px 90px rgba(3, 18, 37, 0.28);
            --auth-shadow-soft: 0 20px 50px rgba(3, 18, 37, 0.14);
        }

        .auth-premium-page {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            overflow-x: clip;
            overflow-y: visible;
            isolation: isolate;
            font-family: 'Manrope', sans-serif;
            color: var(--auth-text);
            background:
                radial-gradient(circle at 12% 8%, rgba(0, 184, 217, 0.18), transparent 25%),
                radial-gradient(circle at 88% 16%, rgba(11, 92, 255, 0.22), transparent 28%),
                linear-gradient(145deg, #03101f 0%, #071d35 38%, #eaf3fb 38.1%, #f7fbff 100%);
        }

        .auth-premium-page::before,
        .auth-premium-page::after {
            content: "";
            position: fixed;
            border-radius: 999px;
            filter: blur(80px);
            pointer-events: none;
            z-index: -1;
            animation: authAurora 12s ease-in-out infinite alternate;
        }

        .auth-premium-page::before {
            top: -9rem;
            left: 20%;
            width: 28rem;
            height: 28rem;
            background: rgba(0, 184, 217, 0.2);
        }

        .auth-premium-page::after {
            right: -8rem;
            bottom: -10rem;
            width: 30rem;
            height: 30rem;
            background: rgba(11, 92, 255, 0.16);
        }

        .auth-premium-shell {
            position: relative;
            z-index: 1;
        }

        .auth-premium-shell main,
        .auth-hero-card,
        .auth-form-card,
        .auth-form-card form,
        .auth-form-card form > section,
        .auth-form-card input,
        .auth-form-card select {
            min-width: 0;
            max-width: 100%;
        }

        .auth-nav,
        .auth-hero-card,
        .auth-form-card,
        .auth-footer-card {
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--auth-border);
            box-shadow: var(--auth-shadow-soft);
        }

        .auth-nav,
        .auth-footer-card {
            background: rgba(6, 23, 43, 0.72);
            color: #fff;
        }

        .auth-nav {
            position: relative;
            z-index: 60;
            overflow: visible;
        }

        .auth-menu-toggle {
            display: none;
            width: 2.85rem;
            height: 2.85rem;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 15px;
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transition: background-color .2s ease, border-color .2s ease, transform .2s ease;
        }

        .auth-menu-toggle:hover,
        .auth-menu-toggle:focus-visible {
            border-color: rgba(142, 233, 255, 0.42);
            background: rgba(142, 233, 255, 0.12);
        }

        .auth-menu-toggle:focus-visible {
            outline: 3px solid rgba(142, 233, 255, 0.22);
            outline-offset: 2px;
        }

        .auth-menu-bars {
            position: relative;
            width: 1.2rem;
            height: .9rem;
        }

        .auth-menu-bars span {
            position: absolute;
            left: 0;
            width: 100%;
            height: 2px;
            border-radius: 999px;
            background: currentColor;
            transition: top .22s ease, transform .22s ease, opacity .18s ease;
        }

        .auth-menu-bars span:nth-child(1) { top: 0; }
        .auth-menu-bars span:nth-child(2) { top: calc(50% - 1px); }
        .auth-menu-bars span:nth-child(3) { top: calc(100% - 2px); }

        .auth-menu-toggle[aria-expanded="true"] .auth-menu-bars span:nth-child(1) {
            top: calc(50% - 1px);
            transform: rotate(45deg);
        }

        .auth-menu-toggle[aria-expanded="true"] .auth-menu-bars span:nth-child(2) {
            opacity: 0;
            transform: scaleX(.4);
        }

        .auth-menu-toggle[aria-expanded="true"] .auth-menu-bars span:nth-child(3) {
            top: calc(50% - 1px);
            transform: rotate(-45deg);
        }

        .auth-mobile-drawer,
        .auth-mobile-backdrop {
            display: none;
        }

        .auth-nav .auth-brand-title,
        .auth-footer-card .text-slate-900 {
            color: #fff;
        }

        .auth-nav .text-slate-500,
        .auth-footer-card .text-slate-500,
        .auth-footer-card .text-slate-600 {
            color: rgba(255, 255, 255, 0.62);
        }

        .auth-hero-card {
            align-self: start;
            min-height: 680px;
            position: sticky;
            top: 1rem;
            background:
                radial-gradient(circle at var(--auth-pointer-x, 82%) var(--auth-pointer-y, 12%), rgba(42, 220, 255, 0.2), transparent 30%),
                linear-gradient(145deg, rgba(5, 25, 48, 0.98), rgba(8, 45, 77, 0.96));
            color: #fff;
            box-shadow: var(--auth-shadow);
        }

        .auth-hero-card::after {
            content: "";
            position: absolute;
            right: -12%;
            bottom: -18%;
            width: 22rem;
            height: 22rem;
            border-radius: 50%;
            border: 1px solid rgba(142, 233, 255, 0.16);
            box-shadow: 0 0 0 44px rgba(142, 233, 255, 0.035), 0 0 0 88px rgba(142, 233, 255, 0.025);
            pointer-events: none;
        }

        .auth-form-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #ffffff, var(--auth-surface));
            border-color: rgba(255, 255, 255, 0.82);
            box-shadow: var(--auth-shadow);
        }

        .auth-form-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, var(--auth-blue), var(--auth-cyan), #8ee9ff);
        }

        .auth-grid-glow::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 24px 24px;
            mask-image: linear-gradient(to bottom, #000, transparent 72%);
            opacity: 0.34;
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
            background: rgba(255, 255, 255, 0.075);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: rgba(255, 255, 255, 0.9);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transition: transform .25s ease, background-color .25s ease, border-color .25s ease;
        }

        .auth-chip:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(142, 233, 255, 0.32);
        }

        .auth-chip-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 999px;
            background: linear-gradient(145deg, rgba(11, 92, 255, 0.32), rgba(0, 184, 217, 0.24));
            color: #8ee9ff;
        }

        .auth-stat-card {
            border-radius: 1.5rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 1rem 1.1rem;
            transition: transform .25s ease, border-color .25s ease;
        }

        .auth-stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(142, 233, 255, 0.34);
        }

        .auth-stat-card p:first-child {
            color: rgba(255, 255, 255, 0.66);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .auth-input {
            min-height: 3.25rem;
            background: rgba(245, 249, 253, 0.9);
            border: 1px solid rgba(112, 133, 159, 0.22);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72);
            transition: transform .18s, border-color .18s, box-shadow .18s, background-color .18s;
        }

        .auth-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(11, 92, 255, 0.5);
            box-shadow: 0 0 0 4px rgba(11, 92, 255, 0.1), 0 12px 24px rgba(6, 23, 43, 0.07);
            transform: translateY(-1px);
        }

        .auth-submit {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--auth-blue), var(--auth-cyan));
            box-shadow: 0 18px 36px rgba(11, 92, 255, 0.24);
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .auth-submit::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 20%, rgba(255,255,255,.26) 46%, transparent 72%);
            transform: translateX(-120%);
            transition: transform .6s ease;
        }

        .auth-submit:hover::before {
            transform: translateX(120%);
        }

        .auth-submit:hover {
            transform: translateY(-1px);
            filter: saturate(1.05);
            box-shadow: 0 22px 42px rgba(11, 92, 255, 0.3);
        }

        .auth-submit:focus-visible {
            outline: none;
            box-shadow: 0 0 0 4px rgba(11, 92, 255, 0.14), 0 18px 34px rgba(11, 92, 255, 0.25);
        }

        .auth-form-card .text-orange-700,
        .auth-form-card .hover\:text-orange-800:hover {
            color: #075ee8 !important;
        }

        .auth-form-card input[type="checkbox"] {
            accent-color: var(--auth-blue);
        }

        .auth-form-card form > section,
        .auth-form-card form > label[for="terms"],
        .auth-form-card form + .auth-panel-divider + div {
            background: rgba(244, 248, 252, 0.74);
            border: 1px solid rgba(107, 129, 157, 0.1);
            box-shadow: inset 0 1px 0 #fff;
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
            flex-wrap: wrap;
        }

        .auth-panel-header,
        .auth-panel-header > div {
            min-width: 0;
        }

        .auth-heading,
        .auth-chip,
        .auth-stat-card,
        .auth-floating-security {
            overflow-wrap: anywhere;
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

        .auth-visual-stage {
            position: relative;
            min-height: 190px;
            margin-top: 2rem;
            perspective: 1000px;
        }

        .auth-bank-card {
            position: relative;
            width: min(100%, 390px);
            min-height: 190px;
            overflow: hidden;
            border-radius: 28px;
            padding: 1.35rem;
            color: #fff;
            background:
                radial-gradient(circle at 82% 8%, rgba(142, 233, 255, 0.32), transparent 30%),
                linear-gradient(145deg, rgba(11, 92, 255, 0.94), rgba(0, 184, 217, 0.82));
            border: 1px solid rgba(255, 255, 255, 0.34);
            box-shadow: 0 30px 65px rgba(0, 8, 24, 0.34), inset 0 1px 0 rgba(255,255,255,.3);
            transform: rotateY(-8deg) rotateX(4deg);
            animation: authCardFloat 5s ease-in-out infinite;
        }

        .auth-bank-card::after {
            content: "";
            position: absolute;
            width: 13rem;
            height: 13rem;
            right: -4rem;
            bottom: -7rem;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 50%;
            box-shadow: 0 0 0 26px rgba(255,255,255,.05), 0 0 0 52px rgba(255,255,255,.035);
        }

        .auth-card-chip-metal {
            width: 42px;
            height: 32px;
            border-radius: 9px;
            background: linear-gradient(145deg, #fef3c7, #d6a843 55%, #fff1ad);
            box-shadow: inset 0 0 0 1px rgba(92, 61, 8, .22);
        }

        .auth-floating-security {
            position: absolute;
            right: 0;
            bottom: 1rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            max-width: 180px;
            padding: .85rem 1rem;
            border-radius: 18px;
            color: #17304d;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(255,255,255,.72);
            box-shadow: 0 18px 40px rgba(0, 8, 24, .28);
            backdrop-filter: blur(16px);
            animation: authBadgeFloat 4s ease-in-out infinite alternate;
        }

        .auth-live-dot {
            width: .65rem;
            height: .65rem;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 6px rgba(34, 197, 94, .12);
            animation: authPulse 1.8s ease-out infinite;
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

        @keyframes authAurora {
            to { transform: translate3d(3rem, 2rem, 0) scale(1.08); }
        }

        @keyframes authCardFloat {
            50% { transform: rotateY(-4deg) rotateX(2deg) translateY(-8px); }
        }

        @keyframes authBadgeFloat {
            to { transform: translateY(-8px); }
        }

        @keyframes authPulse {
            70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        @media (max-width: 1279px) {
            .auth-premium-shell main {
                grid-template-columns: minmax(0, 1fr);
            }

            .auth-hero-card {
                position: relative;
                top: auto;
                min-height: auto;
            }

            .auth-form-card { order: 1; }
            .auth-hero-card { order: 2; }

            .auth-form-card {
                width: 100%;
                max-width: 860px;
                justify-self: center;
            }
        }

        @media (max-width: 1023px) {
            .auth-nav-links {
                width: 100%;
                justify-content: space-between;
            }

            .auth-nav-links > a,
            .auth-nav-links > span {
                flex: 1 1 auto;
            }

            .auth-hero-card {
                max-width: 860px;
                width: 100%;
                justify-self: center;
            }
        }

        @media (max-width: 767px) {
            .auth-nav-inner {
                gap: 0;
            }

            .auth-nav-brand-row {
                width: 100%;
            }

            .auth-menu-toggle {
                display: inline-flex;
            }

            .auth-nav-links {
                display: none;
            }

            .auth-mobile-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 10000;
                visibility: hidden;
                opacity: 0;
                background: rgba(1, 10, 22, 0.66);
                backdrop-filter: blur(5px);
                -webkit-backdrop-filter: blur(5px);
                pointer-events: none;
                transition: opacity .32s ease, visibility .32s ease;
            }

            .auth-mobile-backdrop.is-open {
                visibility: visible;
                opacity: 1;
                pointer-events: auto;
            }

            .auth-mobile-drawer {
                display: flex;
                position: fixed;
                z-index: 10001;
                top: 0;
                right: 0;
                bottom: 0;
                width: min(88vw, 380px);
                height: 100vh;
                height: 100dvh;
                flex-direction: column;
                gap: .85rem;
                padding: 1.1rem;
                overflow-x: hidden;
                overflow-y: auto;
                visibility: hidden;
                opacity: .5;
                color: #fff;
                background:
                    radial-gradient(circle at 90% 4%, rgba(0, 184, 217, .2), transparent 28%),
                    linear-gradient(165deg, #071d35 0%, #041426 100%);
                border-left: 1px solid rgba(142, 233, 255, .18);
                box-shadow: -28px 0 70px rgba(0, 8, 24, .38);
                transform: translate3d(105%, 0, 0);
                pointer-events: none;
                transition: transform .4s cubic-bezier(.22, 1, .36, 1), opacity .28s ease, visibility .4s ease;
            }

            .auth-mobile-drawer.is-open {
                visibility: visible;
                opacity: 1;
                transform: translate3d(0, 0, 0);
                pointer-events: auto;
            }

            .auth-mobile-drawer:focus {
                outline: none;
            }

            .auth-mobile-drawer-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: .35rem;
                padding: .35rem .2rem 1rem;
                border-bottom: 1px solid rgba(255, 255, 255, .11);
            }

            .auth-mobile-drawer-close {
                display: inline-flex;
                width: 2.75rem;
                height: 2.75rem;
                flex: 0 0 auto;
                align-items: center;
                justify-content: center;
                border: 1px solid rgba(255,255,255,.14);
                border-radius: 14px;
                color: #fff;
                background: rgba(255,255,255,.08);
                transition: transform .2s ease, background-color .2s ease;
            }

            .auth-mobile-drawer-close:hover,
            .auth-mobile-drawer-close:focus-visible {
                background: rgba(142, 233, 255, .14);
                transform: rotate(4deg);
            }

            .auth-mobile-drawer > div,
            .auth-mobile-drawer > a,
            .auth-mobile-drawer > span {
                width: 100%;
            }

            .auth-mobile-drawer > a,
            .auth-mobile-drawer > span {
                min-height: 3.25rem;
                justify-content: center;
            }

            .auth-mobile-drawer .language-selector,
            .auth-mobile-drawer .language-dropdown,
            .auth-mobile-drawer .language-btn {
                width: 100%;
            }

            .auth-mobile-drawer .language-selector .language-menu {
                position: static;
                width: 100%;
                min-width: 0;
                max-height: 42vh;
                margin-top: .55rem;
                border-radius: 16px;
            }

            .auth-mobile-drawer .language-selector .language-menu.show::before {
                content: none;
            }

            body.auth-menu-open {
                overflow: hidden;
            }
        }

        @media (max-width: 639px) {
            .auth-premium-page {
                background: linear-gradient(155deg, #03101f 0%, #0a2a48 20rem, #edf5fb 20.1rem, #f8fbff 100%);
            }

            .auth-nav-links {
                align-items: stretch;
            }

            .auth-nav-links > div,
            .auth-nav-links > a,
            .auth-nav-links > span {
                width: 100%;
            }

            .auth-hero-card .auth-heading {
                font-size: clamp(2rem, 10vw, 2.6rem);
                line-height: 1.08;
            }

            .auth-visual-stage { min-height: 176px; }
            .auth-bank-card {
                min-height: 164px;
                border-radius: 23px;
                transform: none;
                animation: none;
            }
            .auth-floating-security { right: -.25rem; bottom: -.5rem; transform: scale(.9); transform-origin: right bottom; animation: none; }
        }

        @media (max-width: 479px) {
            .auth-premium-shell {
                padding: .625rem;
            }

            .auth-nav,
            .auth-footer-card {
                border-radius: 22px;
                padding: .9rem;
            }

            .auth-brand-lockup {
                gap: .75rem;
            }

            .auth-brand-lockup > a {
                width: 3rem;
                height: 3rem;
                border-radius: 14px;
                flex: 0 0 auto;
            }

            .auth-brand-lockup > a img {
                width: 2.15rem;
                height: 2.15rem;
            }

            .auth-nav .auth-brand-title {
                font-size: .96rem;
            }

            .auth-nav .auth-brand-title + p {
                font-size: .72rem;
                line-height: 1.3;
            }

            .auth-form-card,
            .auth-hero-card {
                border-radius: 24px;
                padding: 1.25rem;
            }

            .auth-panel-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .auth-panel-header .auth-heading {
                font-size: 1.65rem;
                line-height: 1.15;
            }

            .auth-field-header {
                flex-wrap: wrap;
                align-items: flex-start;
            }

            .auth-field-header a {
                font-size: .78rem;
            }

            .auth-form-card form > section {
                border-radius: 20px;
                padding: 1rem;
            }

            .auth-input {
                font-size: 16px;
            }

            .auth-bank-card {
                min-height: 150px;
                padding: 1rem;
            }

            .auth-bank-card > p {
                margin-top: 1rem;
                font-size: .85rem;
                letter-spacing: .1em;
                white-space: nowrap;
            }

            .auth-card-chip-metal {
                width: 36px;
                height: 27px;
                margin-top: 1.15rem;
            }

            .auth-floating-security {
                max-width: 154px;
                padding: .7rem .75rem;
            }

            .auth-footer-card > div > div:last-child {
                column-gap: .8rem;
                row-gap: .5rem;
            }
        }

        @media (min-width: 1280px) and (max-height: 900px) {
            .auth-hero-card {
                position: relative;
                top: auto;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .auth-premium-page::before,
            .auth-premium-page::after,
            .auth-bank-card,
            .auth-floating-security,
            .auth-live-dot {
                animation: none;
            }

            .auth-chip,
            .auth-stat-card,
            .auth-submit,
            .auth-input,
            .auth-mobile-drawer,
            .auth-mobile-backdrop {
                transition: none;
            }
        }
    </style>
    @stack('auth_premium_head')
@endpush

@section('content')
    <div class="auth-premium-page">
        <div class="auth-premium-shell px-4 py-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl auth-fade-in">
                <nav class="auth-nav rounded-[28px] px-5 py-4 sm:px-6">
                    <div class="auth-nav-inner flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="auth-nav-brand-row flex items-center justify-between gap-4">
                            <div class="auth-brand-lockup flex min-w-0 items-center gap-4">
                                <a href="{{ localized_route('home') }}" class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/80">
                                    <img src="{{ asset('images/Logosite.png') }}" alt="Zuider Bank S.A" class="h-10 w-10 object-contain">
                                </a>
                                <div class="min-w-0">
                                    <p class="auth-brand-title text-lg font-semibold text-slate-950">Zuider Bank S.A</p>
                                    <p class="text-sm text-slate-500">@yield('auth_nav_subtitle', __('auth_ui.secure_client_access'))</p>
                                </div>
                            </div>

                            <button type="button" class="auth-menu-toggle" id="auth-menu-toggle" aria-label="Menu" aria-controls="auth-mobile-menu" aria-expanded="false">
                                <span class="auth-menu-bars" aria-hidden="true">
                                    <span></span><span></span><span></span>
                                </span>
                            </button>
                        </div>

                        <div class="auth-nav-links flex flex-col gap-3 sm:flex-row sm:items-center">
                            <div class="sm:min-w-[130px]">
                                @include('components.language-selector')
                            </div>
                            @yield('auth_nav_actions')
                        </div>
                    </div>
                </nav>

                <div class="auth-mobile-backdrop" id="auth-mobile-backdrop" aria-hidden="true"></div>
                <aside class="auth-mobile-drawer" id="auth-mobile-menu" role="dialog" aria-modal="true" aria-label="Menu" aria-hidden="true" tabindex="-1" inert>
                    <div class="auth-mobile-drawer-header">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white">
                                <img src="{{ asset('images/Logosite.png') }}" alt="" class="h-8 w-8 object-contain">
                            </span>
                            <span class="min-w-0">
                                <span class="auth-brand-title block truncate text-sm font-semibold">Zuider Bank S.A</span>
                                <span class="mt-0.5 block text-xs text-white/55">@yield('auth_nav_subtitle', __('auth_ui.secure_client_access'))</span>
                            </span>
                        </div>
                        <button type="button" class="auth-mobile-drawer-close" id="auth-menu-close" aria-label="Fermer le menu">
                            <i class="fas fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div>
                        @include('components.language-selector')
                    </div>
                    @yield('auth_nav_actions')
                </aside>

                <main class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.08fr)_minmax(420px,520px)]">
                    <section class="auth-hero-card auth-grid-glow relative overflow-hidden rounded-[34px] px-6 py-7 sm:px-8 sm:py-9">
                        <div class="relative z-10">
                            @yield('auth_hero')

                            <div class="auth-visual-stage" aria-hidden="true">
                                <div class="auth-bank-card">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 ring-1 ring-white/25">
                                                <img src="{{ asset('images/Logosite.png') }}" alt="" class="h-7 w-7 object-contain brightness-0 invert">
                                            </span>
                                            <span class="auth-brand-title text-sm font-semibold tracking-wide">ZUIDER BANK</span>
                                        </div>
                                        <i class="fas fa-wifi rotate-90 text-lg text-white/80"></i>
                                    </div>
                                    <div class="auth-card-chip-metal mt-7"></div>
                                    <p class="mt-5 text-lg font-semibold tracking-[0.18em]">••••&nbsp; ••••&nbsp; ••••&nbsp; 4826</p>
                                    <div class="mt-4 flex items-end justify-between text-[10px] font-semibold uppercase tracking-[0.16em] text-white/65">
                                        <span>{{ __('auth_ui.secure_access') }}</span>
                                        <span>VISA</span>
                                    </div>
                                </div>
                                <div class="auth-floating-security">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                        <i class="fas fa-shield-halved"></i>
                                    </span>
                                    <span>
                                        <span class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">
                                            <span class="auth-live-dot"></span> 24/7
                                        </span>
                                        <span class="mt-1 block text-xs font-bold">{{ __('auth_ui.bank_level') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="auth-form-card rounded-[34px] px-6 py-7 sm:px-8 sm:py-9">
                        @yield('auth_panel')
                    </section>
                </main>

                <footer class="auth-footer-card mt-6 rounded-[28px] px-5 py-4 sm:px-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Zuider Bank S.A</p>
                            <p class="mt-1 text-sm text-slate-500">&copy; {{ date('Y') }} {{ __('auth.footer_copyright') }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-600">
                            <a href="{{ localized_route('support.nous-contacter') }}" class="transition hover:text-slate-900">{{ __('auth.footer_support') }}</a>
                            <a href="{{ localized_route('support.securite') }}" class="transition hover:text-slate-900">{{ __('auth.footer_terms') }}</a>
                            <a href="{{ localized_route('support.mentions-legales') }}" class="transition hover:text-slate-900">{{ __('auth.footer_privacy') }}</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    @stack('auth_premium_scripts')

    <script>
        document.querySelectorAll('.auth-hero-card').forEach(function (card) {
            card.addEventListener('pointermove', function (event) {
                const bounds = card.getBoundingClientRect();
                card.style.setProperty('--auth-pointer-x', ((event.clientX - bounds.left) / bounds.width * 100) + '%');
                card.style.setProperty('--auth-pointer-y', ((event.clientY - bounds.top) / bounds.height * 100) + '%');
            });
        });

        const authMenuButton = document.getElementById('auth-menu-toggle');
        const authMobileMenu = document.getElementById('auth-mobile-menu');
        const authMenuClose = document.getElementById('auth-menu-close');
        const authMenuBackdrop = document.getElementById('auth-mobile-backdrop');

        const setAuthMenuState = function (open) {
            if (!authMenuButton || !authMobileMenu) return;
            authMenuButton.setAttribute('aria-expanded', open ? 'true' : 'false');
            authMobileMenu.classList.toggle('is-open', open);
            authMobileMenu.setAttribute('aria-hidden', open ? 'false' : 'true');
            authMobileMenu.toggleAttribute('inert', !open);
            authMenuBackdrop?.classList.toggle('is-open', open);
            document.body.classList.toggle('auth-menu-open', open);
            if (open) window.setTimeout(function () { authMobileMenu.focus(); }, 180);
        };

        authMenuButton?.addEventListener('click', function () {
            setAuthMenuState(authMenuButton.getAttribute('aria-expanded') !== 'true');
        });

        authMobileMenu?.addEventListener('click', function (event) {
            if (event.target.closest('a')) setAuthMenuState(false);
        });

        authMenuClose?.addEventListener('click', function () {
            setAuthMenuState(false);
            authMenuButton?.focus();
        });

        authMenuBackdrop?.addEventListener('click', function () { setAuthMenuState(false); });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && authMenuButton?.getAttribute('aria-expanded') === 'true') {
                setAuthMenuState(false);
                authMenuButton.focus();
            }

            if (event.key === 'Tab' && authMenuButton?.getAttribute('aria-expanded') === 'true' && authMobileMenu) {
                const focusable = Array.from(authMobileMenu.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'));
                if (!focusable.length) return;
                const first = focusable[0];
                const last = focusable[focusable.length - 1];
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });

        window.matchMedia('(min-width: 768px)').addEventListener('change', function (event) {
            if (event.matches) setAuthMenuState(false);
        });
        window.addEventListener('pageshow', function () { setAuthMenuState(false); });
        window.addEventListener('pagehide', function () { setAuthMenuState(false); });
    </script>
@endsection
