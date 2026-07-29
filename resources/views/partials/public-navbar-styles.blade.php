{{-- Shared public navbar styles. Kept identical to the home page navigation so
     every public page (home + footer pages) renders the exact same header. --}}
<style>
    .bank-nav {
        position: fixed;
        z-index: 60;
        top: 0;
        left: 0;
        right: 0;
        padding-top: 14px;
        padding-bottom: 10px;
        pointer-events: none;
        background: linear-gradient(180deg, #071a2f 0%, rgba(7, 26, 47, 0.94) 64%, rgba(7, 26, 47, 0) 100%);
    }

    .bank-nav-inner {
        pointer-events: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        min-height: 74px;
        padding: 12px 16px 12px 20px;
        border: 1px solid rgba(255, 255, 255, 0.24);
        border-radius: 999px;
        background: rgba(7, 26, 47, 0.82);
        box-shadow: 0 24px 70px rgba(7, 26, 47, 0.2);
        backdrop-filter: blur(22px);
        -webkit-backdrop-filter: blur(22px);
    }

    .brand-mark {
        display: inline-flex;
        align-items: center;
        gap: 0;
        min-width: 0;
        color: #ffffff;
        font-weight: 800;
        font-size: 1rem;
        text-decoration: none;
    }

    .brand-mark img {
        width: clamp(150px, 14vw, 220px);
        height: 50px;
        object-fit: contain;
        filter: drop-shadow(0 8px 18px rgba(0, 0, 0, 0.22));
    }

    .brand-mark span {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: clamp(14px, 1.6vw, 26px);
    }

    .nav-links a {
        color: rgba(255, 255, 255, 0.82);
        font-size: 0.93rem;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
        white-space: nowrap;
    }

    .nav-links a:hover {
        color: #ffffff;
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .bank-nav .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.94rem;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        white-space: nowrap;
    }

    .bank-nav .btn:hover {
        transform: translateY(-2px);
    }

    .bank-nav .btn-primary {
        color: #071a2f;
        background: #ffffff;
        box-shadow: 0 14px 34px rgba(255, 255, 255, 0.2);
    }

    .bank-nav .btn-outline {
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.28);
        background: rgba(255, 255, 255, 0.08);
    }

    .mobile-toggle {
        display: none;
        width: 46px;
        height: 46px;
        border: 0;
        border-radius: 50%;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.12);
        cursor: pointer;
    }

    body.mobile-menu-active {
        overflow: hidden;
    }

    .mobile-menu-backdrop {
        position: fixed;
        inset: 0;
        z-index: 89;
        display: none;
        background: rgba(2, 6, 23, 0.52);
        opacity: 0;
        backdrop-filter: blur(10px);
        transition: opacity .32s ease;
    }

    .mobile-menu-backdrop.open {
        display: block;
        opacity: 1;
    }

    .mobile-menu {
        position: fixed;
        top: 14px;
        right: 14px;
        bottom: 14px;
        z-index: 90;
        display: flex;
        flex-direction: column;
        width: min(88vw, 390px);
        padding: 18px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 32px;
        background:
            radial-gradient(circle at top right, rgba(0, 184, 217, 0.18), transparent 36%),
            linear-gradient(180deg, rgba(7, 26, 47, 0.98), rgba(6, 23, 44, 0.96));
        box-shadow: -28px 0 80px rgba(2, 6, 23, 0.34);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        opacity: 0;
        pointer-events: none;
        transform: translateX(112%);
        transition: transform .42s cubic-bezier(.22, 1, .36, 1), opacity .26s ease;
        will-change: transform, opacity;
    }

    .mobile-menu.open {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }

    .mobile-menu-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 4px 2px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .mobile-menu-brand {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #ffffff;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .mobile-menu-brand img {
        width: 42px;
        height: 42px;
        object-fit: contain;
    }

    .mobile-close {
        width: 42px;
        height: 42px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 50%;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
        cursor: pointer;
    }

    .mobile-menu-links {
        display: grid;
        gap: 8px;
        padding: 18px 0;
    }

    .mobile-menu a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        color: #ffffff;
        padding: 13px 14px;
        border: 1px solid transparent;
        border-radius: 18px;
        font-weight: 700;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.05);
        transition: transform .2s ease, background .2s ease, border-color .2s ease;
    }

    .mobile-menu a:hover {
        transform: translateX(-4px);
        border-color: rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.1);
    }

    .mobile-menu-foot {
        display: grid;
        gap: 10px;
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
    }

    .mobile-menu-foot .language-selector {
        width: 100%;
    }

    .mobile-menu-foot .language-selector .language-btn {
        width: 100%;
        justify-content: center;
    }

    .mobile-menu-foot .mobile-auth-link {
        justify-content: center;
    }

    @media (max-width: 1080px) {
        .nav-links,
        .nav-actions {
            display: none;
        }

        .mobile-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    }

    @media (max-width: 640px) {
        .bank-nav {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .bank-nav-inner {
            padding: 10px 12px;
            border-radius: 20px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .mobile-menu,
        .mobile-menu-backdrop,
        .bank-nav .btn,
        .mobile-menu a {
            transition: none;
        }
    }
</style>
