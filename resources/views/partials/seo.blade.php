@php
    use Illuminate\Support\Facades\Route;

    $seoBrand = 'Zuider Bank S.A';
    $seoLocale = app()->getLocale();
    $seoLocales = config('app.available_locales', ['fr', 'en']);
    $seoRouteName = Route::currentRouteName();
    $seoRouteParams = request()->route()?->parameters() ?? [];

    $seoPublicRoutes = [
        'home' => [
            'title' => __('home.page_title'),
            'description' => __('home.hero_description'),
        ],
        'about.notre-histoire' => [
            'title' => __('about.our_story_title') . ' - ' . $seoBrand,
            'description' => 'Découvrez l’histoire, la mission et les engagements de Zuider Bank S.A, banque en ligne moderne, sécurisée et orientée client.',
        ],
        'about.carrieres' => [
            'title' => __('about.careers_title') . ' - ' . $seoBrand,
            'description' => 'Rejoignez Zuider Bank S.A et contribuez à construire une banque digitale moderne, fiable et centrée sur l’expérience client.',
        ],
        'about.presse' => [
            'title' => __('about.press_title') . ' - ' . $seoBrand,
            'description' => 'Accédez aux informations presse, actualités et ressources officielles de Zuider Bank S.A.',
        ],
        'about.blog' => [
            'title' => __('about.blog_title') . ' - ' . $seoBrand,
            'description' => 'Conseils, analyses et actualités de Zuider Bank S.A pour mieux comprendre la banque en ligne, la sécurité et les services financiers.',
        ],
        'services.comptes-professionnels' => [
            'title' => __('services.business_page_title'),
            'description' => __('services.business_cta_desc'),
        ],
        'services.gestion-tresorerie' => [
            'title' => __('services.treasury_page_title'),
            'description' => __('services.treasury_cta_desc'),
        ],
        'services.cartes-paiement' => [
            'title' => __('services.cards_page_title'),
            'description' => __('services.cards_cta_desc'),
        ],
        'services.virements-internationaux' => [
            'title' => __('services.intl_page_title'),
            'description' => __('services.intl_cta_desc'),
        ],
        'support.securite' => [
            'title' => __('support.security_page_title'),
            'description' => __('support.security_cta_desc'),
        ],
        'support.mentions-legales' => [
            'title' => __('support.legal_mentions_title'),
            'description' => 'Consultez les mentions légales, informations réglementaires et conditions d’utilisation de Zuider Bank S.A.',
        ],
        'support.centre-aide' => [
            'title' => __('support.help_center_title'),
            'description' => 'Trouvez rapidement de l’aide sur l’ouverture de compte, la sécurité, les virements et les services Zuider Bank S.A.',
        ],
        'support.nous-contacter' => [
            'title' => __('support.contact_title'),
            'description' => __('support.contact_hero_subtitle'),
        ],
    ];

    $seoIndexableRoutes = array_keys($seoPublicRoutes);
    $seoIsIndexable = request()->isMethod('GET') && in_array($seoRouteName, $seoIndexableRoutes, true);
    $seoData = $seoPublicRoutes[$seoRouteName] ?? [];

    $seoTitleFromSection = trim($__env->yieldContent('seo_title'));
    $seoTitleFromTitle = trim($__env->yieldContent('title'));
    $seoTitle = $seoTitleFromSection !== ''
        ? $seoTitleFromSection
        : ($seoData['title'] ?? ($seoTitleFromTitle !== '' ? $seoTitleFromTitle . ' - ' . $seoBrand : $seoBrand));

    $seoDescription = trim($__env->yieldContent('seo_description')) ?: ($seoData['description'] ?? 'Zuider Bank S.A propose une banque en ligne moderne, sécurisée et pensée pour gérer vos comptes, cartes et virements avec clarté.');
    $seoDescription = str($seoDescription)->squish()->limit(165, '')->toString();

    $seoRobotsOverride = trim($__env->yieldContent('seo_robots'));
    $seoRobots = $seoRobotsOverride !== ''
        ? $seoRobotsOverride
        : ($seoIsIndexable ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' : 'noindex, nofollow');

    $seoCanonical = trim($__env->yieldContent('seo_canonical')) ?: ($seoIsIndexable ? url()->current() : null);
    $seoOgImage = trim($__env->yieldContent('seo_image')) ?: asset('images/zuider-logo-transparent.png');
    $seoOgType = $seoRouteName === 'home' ? 'website' : 'article';

    $seoAlternates = [];
    if ($seoIsIndexable && $seoRouteName) {
        foreach ($seoLocales as $alternateLocale) {
            try {
                $alternateParams = $seoRouteParams;
                $alternateParams['locale'] = $alternateLocale;
                $seoAlternates[$alternateLocale] = route($seoRouteName, $alternateParams);
            } catch (Throwable $exception) {
                $seoAlternates = [];
                break;
            }
        }
    }

    $seoDefaultLocale = config('app.locale', 'fr');
    $seoOrganizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BankOrCreditUnion',
        'name' => $seoBrand,
        'url' => localized_route('home', ['locale' => $seoDefaultLocale]),
        'logo' => asset('images/zuider-logo-transparent.png'),
        'sameAs' => [],
    ];

    $seoWebsiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $seoBrand,
        'url' => localized_route('home', ['locale' => $seoDefaultLocale]),
        'inLanguage' => $seoLocales,
    ];
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="robots" content="{{ $seoRobots }}">
<meta http-equiv="content-language" content="{{ $seoLocale }}">
@if($seoCanonical)
    <link rel="canonical" href="{{ $seoCanonical }}">
@endif
@foreach($seoAlternates as $alternateLocale => $alternateUrl)
    <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $alternateUrl }}">
@endforeach
@if($seoIsIndexable && isset($seoAlternates[$seoDefaultLocale]))
    <link rel="alternate" hreflang="x-default" href="{{ $seoAlternates[$seoDefaultLocale] }}">
@endif
<meta property="og:site_name" content="{{ $seoBrand }}">
<meta property="og:type" content="{{ $seoOgType }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:locale" content="{{ str_replace('-', '_', $seoLocale) }}">
<meta property="og:image" content="{{ $seoOgImage }}">
@if($seoCanonical)
    <meta property="og:url" content="{{ $seoCanonical }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoOgImage }}">
@if($seoIsIndexable)
    <script type="application/ld+json">
        @json($seoOrganizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    </script>
    @if($seoRouteName === 'home')
        <script type="application/ld+json">
            @json($seoWebsiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        </script>
    @endif
@endif
