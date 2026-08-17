<style>
    /* Never intercept taps: the overlay is decorative only, so even if a slow
       device delays its dismissal the page underneath stays interactive. */
    #site-launch-loader { position: fixed; inset: 0; z-index: 99999; pointer-events: none; display: grid; place-items: center; overflow: hidden; background: radial-gradient(circle at 50% 35%, rgba(0, 184, 217, .18), transparent 28%), linear-gradient(145deg, #03101f 0%, #071d35 52%, #0b5cff 150%); opacity: 1; visibility: visible; transition: opacity .5s ease, visibility .5s ease; }
    #site-launch-loader.is-ready { opacity: 0; visibility: hidden; }
    .site-launch-loader__glow { position: absolute; width: min(70vw, 26rem); aspect-ratio: 1; border-radius: 999px; background: radial-gradient(circle, rgba(0, 184, 217, .16), transparent 70%); filter: blur(4px); animation: siteLoaderPulse 2.4s ease-in-out infinite; }
    .site-launch-loader__content { position: relative; display: flex; flex-direction: column; align-items: center; gap: 1.1rem; padding: 2rem; color: #fff; text-align: center; }
    .site-launch-loader__mark { position: relative; display: grid; width: 11rem; place-items: center; animation: siteLoaderFloat 2.4s ease-in-out infinite; }
    .site-launch-loader__mark img { width: 100%; height: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, .3)); }
    .site-launch-loader__spinner { width: 2.1rem; height: 2.1rem; border-radius: 999px; border: 3px solid rgba(255, 255, 255, .18); border-top-color: #72e8ff; animation: siteLoaderSpin .8s linear infinite; }
    .site-launch-loader__status { margin: 0; color: rgba(226, 244, 255, .72); font: 700 .72rem/1.2 Manrope, sans-serif; letter-spacing: .22em; text-transform: uppercase; }
    @keyframes siteLoaderSpin { to { transform: rotate(360deg); } }
    @keyframes siteLoaderFloat { 50% { transform: translateY(-6px); } }
    @keyframes siteLoaderPulse { 50% { transform: scale(1.08); opacity: .5; } }
    @media (prefers-reduced-motion: reduce) { #site-launch-loader, .site-launch-loader__glow, .site-launch-loader__mark, .site-launch-loader__spinner { animation: none; } }
</style>

<div id="site-launch-loader" data-launch-loader role="status" aria-live="polite" aria-label="Chargement du site">
    <div class="site-launch-loader__glow" aria-hidden="true"></div>
    <div class="site-launch-loader__content">
        <div class="site-launch-loader__mark"><img src="{{ asset('images/nexalune-logo-white.png') }}" alt="NEXALUNE BANK"></div>
        <div class="site-launch-loader__spinner" aria-hidden="true"></div>
        <p class="site-launch-loader__status">Initialisation sécurisée</p>
    </div>
</div>

<script>
    (() => {
        const loader = document.querySelector('[data-launch-loader]');
        if (!loader) return;

        // Brand intro plays once per browsing session. Coming back to the home
        // page later in the same session skips it entirely.
        let alreadyPlayed = false;
        try {
            alreadyPlayed = sessionStorage.getItem('nexalune_launch_intro') === '1';
            sessionStorage.setItem('nexalune_launch_intro', '1');
        } catch (error) {
            // Private mode / storage disabled: just play it.
        }

        if (alreadyPlayed) {
            loader.remove();
            return;
        }

        let dismissed = false;
        const hideLoader = () => {
            if (dismissed) return;
            dismissed = true;
            loader.classList.add('is-ready');
            window.setTimeout(() => loader.remove(), 700);
        };

        // Independent safety nets: whichever fires first dismisses the overlay,
        // so a throttled rAF or a stalled asset can never freeze the screen.
        const hardTimeout = window.setTimeout(hideLoader, 2500);
        const settle = () => {
            window.clearTimeout(hardTimeout);
            window.setTimeout(hideLoader, 250);
        };

        if (document.readyState === 'complete') {
            settle();
        } else {
            window.addEventListener('load', settle, { once: true });
            document.addEventListener('DOMContentLoaded', () => window.setTimeout(settle, 600), { once: true });
        }

        window.addEventListener('pageshow', hideLoader);
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') hideLoader();
        });
    })();
</script>
