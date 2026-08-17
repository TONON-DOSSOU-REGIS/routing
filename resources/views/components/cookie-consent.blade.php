{{-- GDPR cookie consent banner + preferences center. Included once, globally,
     in layouts.app so it appears on every page (public and authenticated). --}}
<div id="cookie-consent-root" data-cookie-consent-root>

    <div id="cookie-consent-banner" class="cookie-consent-banner" role="dialog" aria-live="polite" aria-label="{{ __('cookies.banner_title') }}" aria-hidden="true">
        <div class="cookie-consent-banner__inner">
            <div class="cookie-consent-banner__icon" aria-hidden="true">
                <i class="fas fa-cookie-bite"></i>
            </div>
            <div class="cookie-consent-banner__body">
                <p class="cookie-consent-banner__title">{{ __('cookies.banner_title') }}</p>
                <p class="cookie-consent-banner__text">
                    {{ __('cookies.banner_text') }}
                    <a href="{{ localized_route('support.politique-cookies', ['locale' => app()->getLocale()]) }}" class="cookie-consent-banner__link">{{ __('cookies.banner_learn_more') }}</a>
                </p>
            </div>
            <div class="cookie-consent-banner__actions">
                <button type="button" class="cookie-consent-btn cookie-consent-btn--ghost" data-cookie-action="customize">
                    {{ __('cookies.customize') }}
                </button>
                <button type="button" class="cookie-consent-btn cookie-consent-btn--outline" data-cookie-action="reject-all">
                    {{ __('cookies.reject_all') }}
                </button>
                <button type="button" class="cookie-consent-btn cookie-consent-btn--primary" data-cookie-action="accept-all">
                    {{ __('cookies.accept_all') }}
                </button>
            </div>
        </div>
    </div>

    <div id="cookie-consent-backdrop" class="cookie-consent-backdrop" data-cookie-action="close-preferences"></div>

    <div id="cookie-consent-preferences" class="cookie-consent-preferences" role="dialog" aria-modal="true" aria-label="{{ __('cookies.preferences_title') }}" aria-hidden="true">
        <div class="cookie-consent-preferences__panel">
            <div class="cookie-consent-preferences__head">
                <div>
                    <p class="cookie-consent-preferences__eyebrow"><i class="fas fa-shield-halved"></i> NEXALUNE BANK</p>
                    <h2 class="cookie-consent-preferences__title">{{ __('cookies.preferences_title') }}</h2>
                </div>
                <button type="button" class="cookie-consent-close" data-cookie-action="close-preferences" aria-label="{{ __('cookies.preferences_close') }}">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <p class="cookie-consent-preferences__intro">{{ __('cookies.preferences_intro') }}</p>

            <div class="cookie-consent-preferences__list">
                <div class="cookie-category">
                    <div class="cookie-category__head">
                        <div class="cookie-category__label">
                            <i class="fas fa-lock"></i>
                            <span>{{ __('cookies.category_necessary_title') }}</span>
                        </div>
                        <span class="cookie-category__badge">{{ __('cookies.category_necessary_badge') }}</span>
                    </div>
                    <p class="cookie-category__text">{{ __('cookies.category_necessary_text') }}</p>
                </div>

                <div class="cookie-category">
                    <div class="cookie-category__head">
                        <div class="cookie-category__label">
                            <i class="fas fa-chart-line"></i>
                            <span>{{ __('cookies.category_analytics_title') }}</span>
                        </div>
                        <label class="cookie-toggle">
                            <input type="checkbox" data-cookie-category="analytics">
                            <span class="cookie-toggle__track"><span class="cookie-toggle__thumb"></span></span>
                        </label>
                    </div>
                    <p class="cookie-category__text">{{ __('cookies.category_analytics_text') }}</p>
                </div>

                <div class="cookie-category">
                    <div class="cookie-category__head">
                        <div class="cookie-category__label">
                            <i class="fas fa-sliders"></i>
                            <span>{{ __('cookies.category_functional_title') }}</span>
                        </div>
                        <label class="cookie-toggle">
                            <input type="checkbox" data-cookie-category="functional">
                            <span class="cookie-toggle__track"><span class="cookie-toggle__thumb"></span></span>
                        </label>
                    </div>
                    <p class="cookie-category__text">{{ __('cookies.category_functional_text') }}</p>
                </div>

                <div class="cookie-category">
                    <div class="cookie-category__head">
                        <div class="cookie-category__label">
                            <i class="fas fa-bullhorn"></i>
                            <span>{{ __('cookies.category_marketing_title') }}</span>
                        </div>
                        <label class="cookie-toggle">
                            <input type="checkbox" data-cookie-category="marketing">
                            <span class="cookie-toggle__track"><span class="cookie-toggle__thumb"></span></span>
                        </label>
                    </div>
                    <p class="cookie-category__text">{{ __('cookies.category_marketing_text') }}</p>
                </div>
            </div>

            <div class="cookie-consent-preferences__foot">
                <button type="button" class="cookie-consent-btn cookie-consent-btn--outline" data-cookie-action="reject-all-preferences">
                    {{ __('cookies.reject_all') }}
                </button>
                <button type="button" class="cookie-consent-btn cookie-consent-btn--ghost-strong" data-cookie-action="save-preferences">
                    {{ __('cookies.preferences_save') }}
                </button>
                <button type="button" class="cookie-consent-btn cookie-consent-btn--primary" data-cookie-action="accept-all-preferences">
                    {{ __('cookies.preferences_accept_all') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .cookie-consent-banner,
    .cookie-consent-preferences,
    .cookie-consent-backdrop {
        display: none;
    }

    .cookie-consent-banner.is-visible,
    .cookie-consent-preferences.is-visible,
    .cookie-consent-backdrop.is-visible {
        display: block;
    }

    .cookie-consent-banner {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 99990;
        padding: 16px;
        animation: cookieSlideUp .45s cubic-bezier(.16,1,.3,1) both;
    }

    .cookie-consent-banner__inner {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 18px;
        max-width: 1180px;
        margin: 0 auto;
        padding: 20px 24px;
        border-radius: 24px;
        border: 1px solid rgba(148, 163, 184, .18);
        background: rgba(15, 23, 42, .96);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 -20px 60px rgba(2, 6, 23, .35), 0 0 0 1px rgba(255,255,255,.03);
        color: #e2e8f0;
    }

    .cookie-consent-banner__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #0b5cff, #00b8d9);
        color: #fff;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .cookie-consent-banner__body {
        flex: 1 1 320px;
        min-width: 0;
    }

    .cookie-consent-banner__title {
        margin: 0 0 4px;
        font-weight: 700;
        font-size: .95rem;
        color: #fff;
    }

    .cookie-consent-banner__text {
        margin: 0;
        font-size: .84rem;
        line-height: 1.55;
        color: #cbd5e1;
    }

    .cookie-consent-banner__link {
        color: #7dd3fc;
        font-weight: 600;
        text-decoration: underline;
        text-underline-offset: 2px;
        white-space: nowrap;
    }

    .cookie-consent-banner__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-left: auto;
    }

    .cookie-consent-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        border-radius: 999px;
        font-size: .84rem;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        border: 1px solid transparent;
        transition: transform .16s ease, background-color .16s ease, border-color .16s ease, box-shadow .16s ease;
    }

    .cookie-consent-btn:hover {
        transform: translateY(-1px);
    }

    .cookie-consent-btn--primary {
        background: linear-gradient(135deg, #0b5cff, #0047d6);
        color: #fff;
        box-shadow: 0 10px 24px rgba(11, 92, 255, .35);
    }

    .cookie-consent-btn--outline {
        background: transparent;
        border-color: rgba(226, 232, 240, .3);
        color: #e2e8f0;
    }

    .cookie-consent-btn--outline:hover {
        border-color: rgba(226, 232, 240, .55);
        background: rgba(226, 232, 240, .06);
    }

    .cookie-consent-btn--ghost {
        background: transparent;
        color: #94a3b8;
        text-decoration: underline;
        text-underline-offset: 3px;
        padding-left: 6px;
        padding-right: 6px;
    }

    .cookie-consent-btn--ghost:hover {
        color: #e2e8f0;
    }

    .cookie-consent-btn--ghost-strong {
        background: rgba(148, 163, 184, .12);
        color: #e2e8f0;
        border-color: rgba(148, 163, 184, .2);
    }

    .cookie-consent-btn--ghost-strong:hover {
        background: rgba(148, 163, 184, .2);
    }

    .cookie-consent-backdrop {
        position: fixed;
        inset: 0;
        z-index: 99991;
        background: rgba(2, 6, 23, .55);
        backdrop-filter: blur(4px);
        animation: cookieFadeIn .25s ease both;
    }

    .cookie-consent-preferences {
        position: fixed;
        inset: 0;
        z-index: 99992;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .cookie-consent-preferences.is-visible {
        display: flex;
    }

    .cookie-consent-preferences__panel {
        width: min(640px, 100%);
        max-height: min(88vh, 780px);
        overflow-y: auto;
        border-radius: 28px;
        background: #ffffff;
        box-shadow: 0 40px 100px rgba(2, 6, 23, .35);
        padding: 28px;
        animation: cookieScaleIn .3s cubic-bezier(.16,1,.3,1) both;
    }

    .cookie-consent-preferences__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .cookie-consent-preferences__eyebrow {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #0b5cff;
    }

    .cookie-consent-preferences__title {
        margin: 6px 0 0;
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
    }

    .cookie-consent-close {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        cursor: pointer;
        flex-shrink: 0;
        transition: background-color .15s ease, color .15s ease;
    }

    .cookie-consent-close:hover {
        background: #eef2f7;
        color: #0f172a;
    }

    .cookie-consent-preferences__intro {
        margin: 16px 0 0;
        font-size: .88rem;
        line-height: 1.6;
        color: #64748b;
    }

    .cookie-consent-preferences__list {
        display: grid;
        gap: 12px;
        margin-top: 22px;
    }

    .cookie-category {
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px 18px;
        background: #f8fafc;
    }

    .cookie-category__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .cookie-category__label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: .92rem;
        color: #0f172a;
    }

    .cookie-category__label i {
        color: #0b5cff;
        width: 18px;
        text-align: center;
    }

    .cookie-category__badge {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #059669;
        background: #d1fae5;
        padding: 4px 10px;
        border-radius: 999px;
    }

    .cookie-category__text {
        margin: 10px 0 0;
        font-size: .82rem;
        line-height: 1.55;
        color: #64748b;
    }

    .cookie-toggle {
        position: relative;
        display: inline-flex;
        flex-shrink: 0;
        cursor: pointer;
    }

    .cookie-toggle input {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
    }

    .cookie-toggle__track {
        width: 44px;
        height: 26px;
        border-radius: 999px;
        background: #cbd5e1;
        display: block;
        position: relative;
        transition: background-color .2s ease;
    }

    .cookie-toggle__thumb {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 2px 6px rgba(15, 23, 42, .25);
        transition: transform .2s ease;
    }

    .cookie-toggle input:checked + .cookie-toggle__track {
        background: #0b5cff;
    }

    .cookie-toggle input:checked + .cookie-toggle__track .cookie-toggle__thumb {
        transform: translateX(18px);
    }

    .cookie-toggle input:focus-visible + .cookie-toggle__track {
        box-shadow: 0 0 0 3px rgba(11, 92, 255, .3);
    }

    .cookie-consent-preferences__foot {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .cookie-consent-preferences__foot .cookie-consent-btn--outline {
        border-color: #e2e8f0;
        color: #475569;
    }

    .cookie-consent-preferences__foot .cookie-consent-btn--outline:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    @keyframes cookieSlideUp {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes cookieFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes cookieScaleIn {
        from { opacity: 0; transform: scale(.96) translateY(8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    @media (max-width: 640px) {
        .cookie-consent-banner {
            padding: 10px;
        }

        .cookie-consent-banner__inner {
            padding: 18px;
            border-radius: 20px;
        }

        .cookie-consent-banner__actions {
            width: 100%;
            margin-left: 0;
        }

        .cookie-consent-banner__actions .cookie-consent-btn {
            flex: 1 1 auto;
        }

        .cookie-consent-preferences__panel {
            padding: 20px;
            border-radius: 22px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .cookie-consent-banner,
        .cookie-consent-backdrop,
        .cookie-consent-preferences__panel {
            animation: none;
        }
    }
</style>

<script>
(() => {
    const STORAGE_KEY = 'nexalune_cookie_consent';
    const CATEGORIES = ['analytics', 'functional', 'marketing'];

    const root = document.getElementById('cookie-consent-root');
    if (!root || root.dataset.initialized === '1') return;
    root.dataset.initialized = '1';

    const banner = document.getElementById('cookie-consent-banner');
    const backdrop = document.getElementById('cookie-consent-backdrop');
    const preferences = document.getElementById('cookie-consent-preferences');
    const toggles = Array.from(document.querySelectorAll('[data-cookie-category]'));

    const readConsent = () => {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            return raw ? JSON.parse(raw) : null;
        } catch (error) {
            return null;
        }
    };

    const writeConsent = (categories) => {
        const payload = {
            necessary: true,
            ...categories,
            updatedAt: new Date().toISOString(),
        };

        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
        } catch (error) {
            // Storage unavailable (private mode): consent still applies for this
            // page view via the in-memory state, just won't persist.
        }

        document.dispatchEvent(new CustomEvent('nexalune:cookie-consent-updated', { detail: payload }));
        return payload;
    };

    const applyTogglesFromConsent = (consent) => {
        toggles.forEach((toggle) => {
            const category = toggle.getAttribute('data-cookie-category');
            toggle.checked = Boolean(consent && consent[category]);
        });
    };

    const collectTogglesState = () => {
        const state = {};
        toggles.forEach((toggle) => {
            state[toggle.getAttribute('data-cookie-category')] = toggle.checked;
        });
        return state;
    };

    const showBanner = () => {
        banner.classList.add('is-visible');
        banner.setAttribute('aria-hidden', 'false');
    };

    const hideBanner = () => {
        banner.classList.remove('is-visible');
        banner.setAttribute('aria-hidden', 'true');
    };

    const openPreferences = () => {
        const consent = readConsent();
        applyTogglesFromConsent(consent || {});
        backdrop.classList.add('is-visible');
        preferences.classList.add('is-visible');
        preferences.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
    };

    const closePreferences = () => {
        backdrop.classList.remove('is-visible');
        preferences.classList.remove('is-visible');
        preferences.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    };

    const acceptAll = () => {
        const all = {};
        CATEGORIES.forEach((category) => { all[category] = true; });
        writeConsent(all);
        hideBanner();
        closePreferences();
    };

    const rejectAll = () => {
        const none = {};
        CATEGORIES.forEach((category) => { none[category] = false; });
        writeConsent(none);
        hideBanner();
        closePreferences();
    };

    const savePreferences = () => {
        writeConsent(collectTogglesState());
        hideBanner();
        closePreferences();
    };

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-cookie-action]');
        if (!trigger) return;

        const action = trigger.getAttribute('data-cookie-action');

        if (action === 'accept-all' || action === 'accept-all-preferences') {
            acceptAll();
        } else if (action === 'reject-all' || action === 'reject-all-preferences') {
            rejectAll();
        } else if (action === 'customize') {
            openPreferences();
        } else if (action === 'save-preferences') {
            savePreferences();
        } else if (action === 'close-preferences') {
            closePreferences();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && preferences.classList.contains('is-visible')) {
            closePreferences();
        }
    });

    // Global hook: any page can open the preferences center, e.g. from a
    // "Manage my cookies" link in the footer or the cookie policy page.
    document.addEventListener('click', (event) => {
        const opener = event.target.closest('[data-cookie-open-preferences]');
        if (!opener) return;
        event.preventDefault();
        openPreferences();
    });

    const existingConsent = readConsent();
    if (!existingConsent) {
        showBanner();
    }
})();
</script>
