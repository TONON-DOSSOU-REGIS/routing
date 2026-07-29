{{-- Shared mobile menu behaviour for the public navbar. --}}
<script>
    (function () {
        const toggle = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const close = document.getElementById('mobile-menu-close');
        const backdrop = document.getElementById('mobile-menu-backdrop');

        if (!toggle || !menu || toggle.dataset.menuInitialized === 'true') {
            return;
        }

        toggle.dataset.menuInitialized = 'true';

        const setMobileMenu = function (isOpen) {
            menu.classList.toggle('open', isOpen);
            backdrop?.classList.toggle('open', isOpen);
            document.body.classList.toggle('mobile-menu-active', isOpen);
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            menu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

            const icon = toggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars', !isOpen);
                icon.classList.toggle('fa-times', isOpen);
            }
        };

        toggle.addEventListener('click', function () {
            setMobileMenu(!menu.classList.contains('open'));
        });

        close?.addEventListener('click', function () {
            setMobileMenu(false);
        });

        backdrop?.addEventListener('click', function () {
            setMobileMenu(false);
        });

        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                setMobileMenu(false);
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setMobileMenu(false);
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 1080) {
                setMobileMenu(false);
            }
        });
    })();
</script>
