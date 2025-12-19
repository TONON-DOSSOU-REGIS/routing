@php
$currentLocale = app()->getLocale();
$languages = [
    'en' => ['name' => 'English', 'flag' => '🇬🇧'],
    'fr' => ['name' => 'Français', 'flag' => '🇫🇷'],
    'de' => ['name' => 'Deutsch', 'flag' => '🇩🇪'],
    'nl' => ['name' => 'Nederlands', 'flag' => '🇳🇱'],
    'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
    'pl' => ['name' => 'Polski', 'flag' => '🇵🇱'],
    'it' => ['name' => 'Italiano', 'flag' => '🇮🇹'],
];
$currentLanguage = $languages[$currentLocale] ?? $languages['fr'];
$uniqueId = 'lang-selector-' . uniqid();
@endphp

<div class="language-selector" id="{{ $uniqueId }}">
    <div class="language-dropdown">
        <button class="language-btn" type="button" onclick="toggleLanguageMenu(event, '{{ $uniqueId }}')">
            <span class="flag">{{ $currentLanguage['flag'] }}</span>
            <span class="lang-code">{{ strtoupper($currentLocale) }}</span>
            <svg class="chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
        <ul class="language-menu">
            @foreach($languages as $code => $language)
                <li>
                    <form action="{{ route('language.switch', ['locale' => $code]) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="language-item {{ $code === $currentLocale ? 'active' : '' }}">
                            <span class="flag">{{ $language['flag'] }}</span>
                            <span class="lang-name">{{ $language['name'] }}</span>
                            @if($code === $currentLocale)
                                <span class="check-mark">✓</span>
                            @endif
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>
.language-selector {
    position: relative;
    display: inline-block;
}

.language-selector .language-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    background-color: #fff;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.language-selector .language-btn:hover {
    background-color: #f8f9fa;
    border-color: #adb5bd;
    color: #212529;
}

.language-selector .flag {
    font-size: 1.5rem;
    line-height: 1;
}

.language-selector .lang-code {
    font-weight: 600;
    font-size: 0.875rem;
    letter-spacing: 0.05em;
}

.language-selector .chevron {
    transition: transform 0.3s ease;
}

.language-selector .language-btn.open .chevron {
    transform: rotate(180deg);
}

.language-selector .language-menu {
    position: absolute;
    top: calc(100% + 0.5rem);
    right: 0;
    min-width: 200px;
    padding: 0.5rem 0;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    background-color: #fff;
    list-style: none;
    margin: 0;
    display: none;
    z-index: 1000;
}

.language-selector .language-menu.show {
    display: block;
    animation: slideDown 0.3s ease;
}

.language-selector .language-menu li {
    margin: 0;
    padding: 0;
}

.language-selector .language-menu form {
    width: 100%;
}

.language-selector .language-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    width: 100%;
    border: none;
    background: none;
    color: #495057;
    text-decoration: none;
    text-align: left;
    transition: all 0.2s ease;
    position: relative;
    cursor: pointer;
    font-family: inherit;
    font-size: inherit;
}

.language-selector .language-item:hover {
    background-color: #f8f9fa;
    color: #212529;
    transform: translateX(5px);
}

.language-selector .language-item.active {
    background-color: #e7f3ff;
    color: #0d6efd;
    font-weight: 600;
}

.language-selector .language-item .flag {
    font-size: 1.25rem;
}

.language-selector .language-item .lang-name {
    flex: 1;
    font-size: 0.9375rem;
}

.language-selector .language-item .check-mark {
    color: #0d6efd;
    font-weight: bold;
    font-size: 1.125rem;
}

/* Animation pour le dropdown */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .language-selector {
        width: 100%;
    }
    
    .language-selector .language-btn {
        padding: 0.5rem 0.75rem;
        width: 100%;
        justify-content: center;
    }
    
    .language-selector .lang-code {
        display: inline;
        font-size: 0.875rem;
    }
    
    .language-selector .flag {
        font-size: 1.5rem;
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
        border-radius: 1rem 1rem 0 0;
        box-shadow: 0 -0.5rem 2rem rgba(0, 0, 0, 0.3);
        padding: 1rem 0;
        z-index: 9999;
    }
    
    .language-selector .language-menu.show {
        animation: slideUp 0.3s ease;
    }
    
    .language-selector .language-item {
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }
    
    .language-selector .language-item .flag {
        font-size: 1.5rem;
    }
    
    .language-selector .language-item .lang-name {
        font-size: 1rem;
    }
    
    /* Overlay pour mobile */
    .language-selector .language-menu.show::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }
}

/* Animation pour mobile */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(100%);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Dark mode support (optionnel) */
@media (prefers-color-scheme: dark) {
    .language-selector .language-btn {
        background-color: #212529;
        border-color: #495057;
        color: #f8f9fa;
    }
    
    .language-selector .language-btn:hover {
        background-color: #343a40;
        border-color: #6c757d;
    }
    
    .language-selector .language-menu {
        background-color: #212529;
        border-color: #495057;
    }
    
    .language-selector .language-item {
        color: #f8f9fa;
    }
    
    .language-selector .language-item:hover {
        background-color: #343a40;
        color: #fff;
    }
    
    .language-selector .language-item.active {
        background-color: #0d47a1;
        color: #fff;
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
