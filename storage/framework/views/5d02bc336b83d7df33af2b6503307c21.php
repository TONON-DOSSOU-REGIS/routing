<?php
$currentLocale = app()->getLocale();
$languages = [
    'en' => ['name' => 'English', 'flag' => 'gb', 'code' => 'EN'],
    'fr' => ['name' => 'Francais', 'flag' => 'fr', 'code' => 'FR'],
    'de' => ['name' => 'Deutsch', 'flag' => 'de', 'code' => 'DE'],
    'nl' => ['name' => 'Nederlands', 'flag' => 'nl', 'code' => 'NL'],
    'es' => ['name' => 'Espanol', 'flag' => 'es', 'code' => 'ES'],
    'pl' => ['name' => 'Polski', 'flag' => 'pl', 'code' => 'PL'],
    'it' => ['name' => 'Italiano', 'flag' => 'it', 'code' => 'IT'],
];
$currentLanguage = $languages[$currentLocale] ?? $languages['fr'];
$uniqueId = 'lang-selector-' . uniqid();
?>

<div class="language-selector" id="<?php echo e($uniqueId); ?>">
    <div class="language-dropdown">
        <button class="language-btn" type="button" onclick="toggleLanguageMenu(event, '<?php echo e($uniqueId); ?>')">
            <span class="flag flag-<?php echo e($currentLanguage['flag'] ?? 'fr'); ?>" aria-hidden="true"></span>
            <span class="lang-code"><?php echo e($currentLanguage['code'] ?? strtoupper($currentLocale)); ?></span>
            <svg class="chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
        <ul class="language-menu">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <form action="<?php echo e(route('language.switch', ['locale' => $code])); ?>" method="POST" style="margin: 0;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="language-item <?php echo e($code === $currentLocale ? 'active' : ''); ?>">
                            <span class="flag flag-<?php echo e($language['flag']); ?>" aria-hidden="true"></span>
                            <span class="lang-name"><?php echo e($language['name']); ?></span>
                            <span class="lang-pill"><?php echo e($language['code'] ?? strtoupper($code)); ?></span>
                            <?php if($code === $currentLocale): ?>
                                <span class="check-mark">✓</span>
                            <?php endif; ?>
                        </button>
                    </form>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>

<style>
.language-selector {
    position: relative;
    display: inline-block;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    z-index: 10000;
}

.language-selector .language-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.55rem 0.9rem;
    border: 1px solid rgba(15, 23, 42, 0.12);
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.85));
    color: #0f172a;
    box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    cursor: pointer;
    backdrop-filter: blur(6px);
}

.language-selector .language-btn:hover {
    transform: translateY(-1px);
    border-color: rgba(37, 99, 235, 0.35);
    box-shadow: 0 14px 26px rgba(37, 99, 235, 0.18);
}

.language-selector .flag {
    width: 1.45rem;
    height: 1.05rem;
    display: inline-block;
    border-radius: 4px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
    background-size: cover;
    background-position: center;
    flex-shrink: 0;
}

.language-selector .flag-gb { background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='18'><rect width='24' height='18' fill='%23012a4a'/><path d='M0 0 L24 18 M24 0 L0 18' stroke='%23ffffff' stroke-width='4'/><path d='M0 0 L24 18 M24 0 L0 18' stroke='%23c8102e' stroke-width='2'/><rect x='10' width='4' height='18' fill='%23ffffff'/><rect y='7' width='24' height='4' fill='%23ffffff'/><rect x='11' width='2' height='18' fill='%23c8102e'/><rect y='8' width='24' height='2' fill='%23c8102e'/></svg>"); }
.language-selector .flag-fr { background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='18'><rect width='8' height='18' fill='%230055a4'/><rect x='8' width='8' height='18' fill='%23ffffff'/><rect x='16' width='8' height='18' fill='%23ef4135'/></svg>"); }
.language-selector .flag-de { background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='18'><rect width='24' height='6' fill='%23000000'/><rect y='6' width='24' height='6' fill='%23dd0000'/><rect y='12' width='24' height='6' fill='%23ffce00'/></svg>"); }
.language-selector .flag-nl { background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='18'><rect width='24' height='6' fill='%23ae1c28'/><rect y='6' width='24' height='6' fill='%23ffffff'/><rect y='12' width='24' height='6' fill='%2321468b'/></svg>"); }
.language-selector .flag-es { background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='18'><rect width='24' height='4' fill='%23aa151b'/><rect y='4' width='24' height='10' fill='%23f1bf00'/><rect y='14' width='24' height='4' fill='%23aa151b'/></svg>"); }
.language-selector .flag-pl { background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='18'><rect width='24' height='9' fill='%23ffffff'/><rect y='9' width='24' height='9' fill='%23dc143c'/></svg>"); }
.language-selector .flag-it { background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='18'><rect width='8' height='18' fill='%23009846'/><rect x='8' width='8' height='18' fill='%23ffffff'/><rect x='16' width='8' height='18' fill='%23ce2b37'/></svg>"); }

.language-selector .lang-code {
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #1e293b;
    background: rgba(15, 23, 42, 0.06);
    padding: 0.2rem 0.45rem;
    border-radius: 999px;
}

.language-selector .chevron {
    transition: transform 0.3s ease;
    color: #475569;
}

.language-selector .language-btn.open .chevron {
    transform: rotate(180deg);
}

.language-selector .language-menu {
    position: absolute;
    top: calc(100% + 0.6rem);
    right: 0;
    min-width: 230px;
    padding: 0.4rem 0;
    border-radius: 16px;
    border: 1px solid rgba(148, 163, 184, 0.25);
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.2);
    background: #ffffff;
    list-style: none;
    margin: 0;
    display: none;
    z-index: 10001;
    overflow: hidden;
}

.language-selector .language-menu.show {
    display: block;
    animation: slideDown 0.25s ease;
}

.language-selector .language-menu li {
    margin: 0;
    padding: 0;
}

.language-selector .language-menu form {
    width: 100%;
}

.language-selector .language-item {
    display: grid;
    grid-template-columns: auto 1fr auto auto;
    align-items: center;
    gap: 0.75rem;
    padding: 0.7rem 1rem;
    width: 100%;
    border: none;
    background: none;
    color: #0f172a;
    text-align: left;
    transition: background 0.2s ease, transform 0.2s ease;
    cursor: pointer;
    font-family: inherit;
    font-size: 0.95rem;
}

.language-selector .language-item:hover {
    background: #f8fafc;
    transform: translateX(4px);
}

.language-selector .language-item.active {
    background: linear-gradient(90deg, rgba(37, 99, 235, 0.12), rgba(14, 165, 233, 0.08));
    color: #1d4ed8;
    font-weight: 600;
}

.language-selector .language-item .flag {
    font-size: 1.25rem;
}

.language-selector .language-item .lang-name {
    font-size: 0.95rem;
}

.language-selector .language-item .lang-pill {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: #0f172a;
    background: rgba(15, 23, 42, 0.08);
    padding: 0.15rem 0.45rem;
    border-radius: 999px;
}

.language-selector .language-item .check-mark {
    color: #2563eb;
    font-weight: 700;
    font-size: 1rem;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .language-selector { width: 100%; }

    .language-selector .language-btn {
        width: 100%;
        justify-content: center;
        padding: 0.6rem 1rem;
    }

    .language-selector .language-menu {
        position: fixed;
        top: auto;
        bottom: 0;
        left: 0;
        right: 0;
        min-width: 100%;
        max-height: 70vh;
        overflow-y: auto;
        border-radius: 20px 20px 0 0;
        padding: 0.8rem 0;
        z-index: 9999;
    }

    .language-selector .language-item {
        padding: 0.9rem 1.2rem;
        font-size: 1rem;
    }

    .language-selector .language-menu.show::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.45);
        z-index: -1;
    }
}
</style>

<script>
// Fonction globale pour toggle le menu de langue
function toggleLanguageMenu(event, selectorId) {
    event.stopPropagation();
    
    const selector = document.getElementById(selectorId);
    if (!selector) return;
    
    const btn = selector.querySelector('.language-btn');
    const menu = selector.querySelector('.language-menu');
    
    if (!btn || !menu) return;
    
    // Fermer tous les autres menus de langue ouverts
    document.querySelectorAll('.language-menu.show').forEach(function(otherMenu) {
        if (otherMenu !== menu) {
            otherMenu.classList.remove('show');
            const otherBtn = otherMenu.closest('.language-selector').querySelector('.language-btn');
            if (otherBtn) otherBtn.classList.remove('open');
        }
    });
    
    // Toggle le menu actuel
    menu.classList.toggle('show');
    btn.classList.toggle('open');
}

// Fermer tous les menus en cliquant à l'extérieur
document.addEventListener('click', function(event) {
    if (!event.target.closest('.language-selector')) {
        document.querySelectorAll('.language-menu.show').forEach(function(menu) {
            menu.classList.remove('show');
            const btn = menu.closest('.language-selector').querySelector('.language-btn');
            if (btn) btn.classList.remove('open');
        });
    }
});
</script>

<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/language-selector.blade.php ENDPATH**/ ?>