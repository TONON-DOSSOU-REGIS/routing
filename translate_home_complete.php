<?php
/**
 * Script de traduction complète de home.blade.php
 * Ce script remplace tous les textes en dur par des appels aux fichiers de traduction
 */

// Lire le fichier home.blade.php
$filePath = __DIR__ . '/resources/views/home.blade.php';
$content = file_get_contents($filePath);

// Tableau de remplacement : texte français => clé de traduction
$replacements = [
    // Navigation
    'Accueil' => "{{ __('home.nav_home') }}",
    'Services' => "{{ __('home.nav_services') }}",
    'Témoignage client' => "{{ __('home.nav_testimonials') }}",
    'Formulaire de contact' => "{{ __('home.nav_contact') }}",
    'Connexion' => "{{ __('home.nav_login') }}",
    'Créer un compte' => "{{ __('home.nav_register') }}",
    
    // Services Menu
    'Comptes professionnels' => "{{ __('home.services_business_accounts') }}",
    'Virements internationaux' => "{{ __('home.services_international_transfers') }}",
    'Gestion de trésorerie' => "{{ __('home.services_treasury_management') }}",
    'Cartes de paiement' => "{{ __('home.services_payment_cards') }}",
    
    // Dashboard Preview
    'Aperçu de votre tableau de bord' => "{{ __('home.dashboard_preview_title') }}",
    'Virements en cours' => "{{ __('home.dashboard_transfers_in_progress') }}",
    'opérations' => "{{ __('home.dashboard_operations') }}",
    "Progression d'un virement prioritaire" => "{{ __('home.dashboard_priority_transfer') }}",
    'Étape 3/4 - Contrôle final de conformité' => "{{ __('home.dashboard_step') }}",
    'Virements' => "{{ __('home.dashboard_transfers') }}",
    'Réception' => "{{ __('home.dashboard_reception') }}",
    'Alertes' => "{{ __('home.dashboard_alerts') }}",
    'Interface moderne, claire et pensée pour les virements professionnels.' => "{{ __('home.dashboard_description') }}",
    
    // Features Section
    'Des fonctionnalités puissantes, pensées pour les professionnels' => "{{ __('home.features_title') }}",
    'SG BANK vous offre une expérience bancaire moderne : sécurité avancée, transparence totale et gestion intelligente de vos opérations.' => "{{ __('home.features_description') }}",
    
    'Sécurité bancaire AES 256-bit' => "{{ __('home.feature_1_title') }}",
    'Vos données sont chiffrées de bout en bout et protégées par les mêmes protocoles que les grandes institutions bancaires.' => "{{ __('home.feature_1_description') }}",
    'Connexion sécurisée (HTTPS / SSL)' => "{{ __('home.feature_1_item_1') }}",
    'Détection de connexions suspectes' => "{{ __('home.feature_1_item_2') }}",
    'Archivage sécurisé et protégé' => "{{ __('home.feature_1_item_3') }}",
    
    'Surveillance anti-fraude en temps réel' => "{{ __('home.feature_2_title') }}",
    'Un système intelligent analyse en continu vos opérations pour détecter toute activité anormale.' => "{{ __('home.feature_2_description') }}",
    'Alerte en temps réel par e-mail' => "{{ __('home.feature_2_item_1') }}",
    'Analyse automatique des anomalies' => "{{ __('home.feature_2_item_2') }}",
    "Contrôle manuel possible par l'administrateur" => "{{ __('home.feature_2_item_3') }}",
    
    'Progression des virements supervisée' => "{{ __('home.feature_3_title') }}",
    'Chaque virement passe par un processus de validation certifié pour garantir sécurité et transparence.' => "{{ __('home.feature_3_description') }}",
    'Suivi étape par étape' => "{{ __('home.feature_3_item_1') }}",
    'Barre de progression dynamique' => "{{ __('home.feature_3_item_2') }}",
    'Justificatif PDF certifié' => "{{ __('home.feature_3_item_3') }}",
    
    // Why Choose Section
    'Pourquoi choisir SG BANK ?' => "{{ __('home.why_choose_title') }}",
    'SG BANK accompagne aussi bien les particuliers que les professionnels avec une solution bancaire moderne, accessible, rapide et extrêmement fiable.' => "{{ __('home.why_choose_description') }}",
    
    'Aucun déplacement nécessaire' => "{{ __('home.advantage_1_title') }}",
    'Ouvrez et gérez vos comptes depuis votre ordinateur, smartphone ou tablette, où que vous soyez.' => "{{ __('home.advantage_1_description') }}",
    
    'Approbation rapide' => "{{ __('home.advantage_2_title') }}",
    'Processus de validation accéléré pour vos virements et demandes importantes.' => "{{ __('home.advantage_2_description') }}",
    
    'Virements + reçu PDF' => "{{ __('home.advantage_3_title') }}",
    'Recevez un justificatif PDF certifié après chaque virement effectué avec succès.' => "{{ __('home.advantage_3_description') }}",
    
    'Support client humain' => "{{ __('home.advantage_4_title') }}",
    'Une équipe disponible pour vous assister, vous conseiller et répondre à vos questions.' => "{{ __('home.advantage_4_description') }}",
    
    // Stats Section
    'Clients satisfaits' => "{{ __('home.stats_clients') }}",
    "Des milliers d'utilisateurs font confiance à SG BANK pour leurs opérations quotidiennes." => "{{ __('home.stats_clients_description') }}",
    'Volume de transactions (M€)' => "{{ __('home.stats_volume') }}",
    'Un volume important de flux financiers géré avec précision et transparence.' => "{{ __('home.stats_volume_description') }}",
    'Taux de satisfaction' => "{{ __('home.stats_satisfaction') }}",
    'Nos utilisateurs recommandent SG BANK pour sa simplicité, sa rapidité et son sérieux.' => "{{ __('home.stats_satisfaction_description') }}",
    
    // Partners Section
    'Ils nous font confiance' => "{{ __('home.partners_title') }}",
    'SG BANK collabore avec des institutions financières reconnues mondialement, afin de garantir fiabilité, sécurité et qualité de service.' => "{{ __('home.partners_description') }}",
    'Les logos affichés sont présentés à titre illustratif pour une démonstration visuelle.' => "{{ __('home.partners_note') }}",
    
    // Certifications Section
    'Certifiée par les meilleurs standards' => "{{ __('home.certifications_title') }}",
    'SG BANK applique les normes les plus strictes du secteur bancaire pour assurer des opérations fiables, transparentes et sécurisées.' => "{{ __('home.certifications_description') }}",
    
    'Certification Sécurité' => "{{ __('home.cert_1_badge') }}",
    'Normes de sécurité renforcées' => "{{ __('home.cert_1_title') }}",
    'Conforme aux standards internationaux de cybersécurité, assurant un chiffrement de qualité bancaire.' => "{{ __('home.cert_1_description') }}",
    
    'Qualité de Service' => "{{ __('home.cert_2_badge') }}",
    'Excellence & transparence' => "{{ __('home.cert_2_title') }}",
    'Un suivi détaillé, des frais affichés clairement et une interface pensée pour les utilisateurs.' => "{{ __('home.cert_2_description') }}",
    'Distinction Premium Service' => "{{ __('home.cert_2_distinction') }}",
    
    'Protection des données' => "{{ __('home.cert_3_badge') }}",
    'Confidentialité garantie' => "{{ __('home.cert_3_title') }}",
    'Gestion stricte des accès sensibles et conformité inspirée des directives RGPD.' => "{{ __('home.cert_3_description') }}",
    'Conformité & sécurité des données' => "{{ __('home.cert_3_compliance') }}",
    
    // Testimonials Section
    'Ce que disent nos clients' => "{{ __('home.testimonials_title') }}",
    'Des utilisateurs réels, des expériences réelles. SG BANK simplifie la gestion des virements au quotidien.' => "{{ __('home.testimonials_description') }}",
    
    'Sarah M.' => "{{ __('home.testimonial_1_name') }}",
    'Entrepreneure - E-commerce' => "{{ __('home.testimonial_1_role') }}",
    '« SG BANK m\'a permis de suivre mes virements fournisseurs en temps réel. La barre de progression et les reçus PDF sont vraiment rassurants. »' => "{{ __('home.testimonial_1_text') }}",
    'Service impeccable' => "{{ __('home.testimonial_1_rating') }}",
    
    'Jean-Paul D.' => "{{ __('home.testimonial_2_name') }}",
    'Consultant financier' => "{{ __('home.testimonial_2_role') }}",
    "« J'apprécie particulièrement la surveillance anti-fraude et les alertes e-mail. Je sais immédiatement quand un virement important est en cours ou finalisé. »" => "{{ __('home.testimonial_2_text') }}",
    'Très fiable' => "{{ __('home.testimonial_2_rating') }}",
    
    'Karim L.' => "{{ __('home.testimonial_3_name') }}",
    'Indépendant - Service B2B' => "{{ __('home.testimonial_3_role') }}",
    "« L'interface est claire et très simple. Je peux montrer directement à mes clients les preuves de virement avec les reçus PDF. »" => "{{ __('home.testimonial_3_text') }}",
    'Pratique et moderne' => "{{ __('home.testimonial_3_rating') }}",
    
    // FAQ Section
    'Questions fréquentes (FAQ)' => "{{ __('home.faq_title') }}",
    "Retrouvez les réponses aux questions les plus courantes sur SG BANK, l'ouverture de compte et la gestion de vos virements en ligne." => "{{ __('home.faq_description') }}",
    
    'Comment ouvrir un compte sur SG BANK ?' => "{{ __('home.faq_1_question') }}",
    'Inscription simple en quelques étapes.' => "{{ __('home.faq_1_subtitle') }}",
    "Cliquez sur « Créer un compte », remplissez le formulaire avec vos informations (nom, e-mail, téléphone, etc.), confirmez votre adresse e-mail, puis accédez à votre espace sécurisé pour réaliser vos premières opérations." => "{{ __('home.faq_1_answer') }}",
    
    'Mes virements sont-ils vraiment surveillés ?' => "{{ __('home.faq_2_question') }}",
    'Suivi et contrôle manuel des opérations.' => "{{ __('home.faq_2_subtitle') }}",
    "Oui. Chaque virement passe par plusieurs étapes de validation. Les administrateurs SG BANK peuvent contrôler et certifier les opérations sensibles, ce qui réduit fortement les risques d'erreur ou de fraude." => "{{ __('home.faq_2_answer') }}",
    
    'Puis-je télécharger un reçu pour chaque virement ?' => "{{ __('home.faq_3_question') }}",
    'Justificatif PDF disponible.' => "{{ __('home.faq_3_subtitle') }}",
    "Bien sûr. Une fois le virement finalisé et certifié, un reçu PDF est généré automatiquement. Vous pouvez le télécharger, l'imprimer ou le partager avec vos partenaires." => "{{ __('home.faq_3_answer') }}",
    
    'Que faire en cas de problème ou de doute ?' => "{{ __('home.faq_4_question') }}",
    'Support humain disponible.' => "{{ __('home.faq_4_subtitle') }}",
    "Vous pouvez contacter notre support client via votre espace sécurisé ou par les coordonnées indiquées sur le site. Un conseiller vous répondra dans les meilleurs délais." => "{{ __('home.faq_4_answer') }}",
    
    // CTA Section
    'Prêt à commencer ?' => "{{ __('home.cta_title') }}",
    'Rejoignez des milliers de clients satisfaits qui font confiance à SG BANK pour leurs virements et opérations bancaires en ligne.' => "{{ __('home.cta_description') }}",
    'Commencer maintenant' => "{{ __('home.cta_button') }}",
    "L'ouverture de compte se fait en quelques minutes, sans déplacement, et avec un haut niveau de sécurité." => "{{ __('home.cta_security') }}",
    
    // Footer
    'Une solution bancaire 100% sécurisée, simple et rapide pour les professionnels.' => "{{ __('home.footer_description') }}",
    'À propos' => "{{ __('home.footer_about') }}",
    'Support' => "{{ __('home.footer_support') }}",
    'Notre histoire' => "{{ __('home.footer_our_story') }}",
    'Carrières' => "{{ __('home.footer_careers') }}",
    'Presse' => "{{ __('home.footer_press') }}",
    'Blog' => "{{ __('home.footer_blog') }}",
    "Centre d'aide" => "{{ __('home.footer_help_center') }}",
    'Nous contacter' => "{{ __('home.footer_contact_us') }}",
    'Sécurité' => "{{ __('home.footer_security') }}",
    'Mentions légales' => "{{ __('home.footer_legal') }}",
    'Tous droits réservés.' => "{{ __('home.footer_copyright') }}",
    'Les informations affichées sur ce site ont une valeur indicative et peuvent être adaptées selon votre projet réel.' => "{{ __('home.footer_disclaimer') }}",
];

// Effectuer les remplacements
foreach ($replacements as $search => $replace) {
    // Échapper les caractères spéciaux pour la regex
    $searchEscaped = preg_quote($search, '/');
    
    // Remplacer uniquement si ce n'est pas déjà une traduction
    $content = preg_replace(
        '/(?<!\{\{ __\(\')' . $searchEscaped . '(?!\'\) \}\})/',
        $replace,
        $content
    );
}

// Sauvegarder le fichier
file_put_contents($filePath, $content);

echo "✅ Traduction complète de home.blade.php terminée !\n";
echo "📊 " . count($replacements) . " remplacements effectués.\n";
echo "🔄 Videz le cache des vues : php artisan view:clear\n";
