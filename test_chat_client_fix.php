<?php
/**
 * Test de vérification de la correction du chatbot client
 * 
 * Ce script vérifie que les routes de chat sont correctement configurées
 * et que le widget client utilise les routes nommées.
 */

echo "=== Test de la correction du chatbot client ===\n\n";

// 1. Vérifier que le fichier widget a été modifié
echo "1. Vérification du widget client...\n";
$widgetPath = __DIR__ . '/resources/views/components/client-chat-widget.blade.php';

if (!file_exists($widgetPath)) {
    echo "   ❌ ERREUR: Le fichier widget n'existe pas\n";
    exit(1);
}

$widgetContent = file_get_contents($widgetPath);

// Vérifier que route() est utilisé au lieu de url()
$hasRouteMessages = strpos($widgetContent, "route(\"chat.messages\")") !== false;
$hasRouteSend = strpos($widgetContent, "route(\"chat.send\")") !== false;
$hasRouteUnread = strpos($widgetContent, "route(\"chat.unread-count\")") !== false;

// Vérifier qu'il n'y a plus d'url() pour les routes de chat
$hasUrlMessages = strpos($widgetContent, 'url("/chat/messages")') !== false;
$hasUrlSend = strpos($widgetContent, 'url("/chat/send")') !== false;
$hasUrlUnread = strpos($widgetContent, 'url("/chat/unread-count")') !== false;

if ($hasRouteMessages && $hasRouteSend && $hasRouteUnread) {
    echo "   ✅ Le widget utilise correctement route() pour toutes les routes de chat\n";
} else {
    echo "   ❌ ERREUR: Le widget n'utilise pas route() pour toutes les routes\n";
    if (!$hasRouteMessages) echo "      - Manque route(\"chat.messages\")\n";
    if (!$hasRouteSend) echo "      - Manque route(\"chat.send\")\n";
    if (!$hasRouteUnread) echo "      - Manque route(\"chat.unread-count\")\n";
}

if ($hasUrlMessages || $hasUrlSend || $hasUrlUnread) {
    echo "   ⚠️  ATTENTION: Le widget contient encore des url() pour les routes de chat\n";
    if ($hasUrlMessages) echo "      - Trouvé url(\"/chat/messages\")\n";
    if ($hasUrlSend) echo "      - Trouvé url(\"/chat/send\")\n";
    if ($hasUrlUnread) echo "      - Trouvé url(\"/chat/unread-count\")\n";
} else {
    echo "   ✅ Aucun url() trouvé pour les routes de chat\n";
}

// 2. Vérifier les routes dans web.php
echo "\n2. Vérification des routes web.php...\n";
$routesPath = __DIR__ . '/routes/web.php';

if (!file_exists($routesPath)) {
    echo "   ❌ ERREUR: Le fichier routes/web.php n'existe pas\n";
    exit(1);
}

$routesContent = file_get_contents($routesPath);

// Vérifier que les routes de chat sont dans le groupe avec locale
$hasChatRoutes = strpos($routesContent, "Route::prefix('chat')->name('chat.')->group") !== false;
$hasSendRoute = strpos($routesContent, "Route::post('/send', [ChatController::class, 'sendMessage'])->name('send')") !== false;
$hasMessagesRoute = strpos($routesContent, "Route::get('/messages/{userId?}', [ChatController::class, 'getMessages'])->name('messages')") !== false;
$hasUnreadRoute = strpos($routesContent, "Route::get('/unread-count', [ChatController::class, 'getUnreadCount'])->name('unread-count')") !== false;

if ($hasChatRoutes && $hasSendRoute && $hasMessagesRoute && $hasUnreadRoute) {
    echo "   ✅ Toutes les routes de chat sont correctement définies\n";
} else {
    echo "   ❌ ERREUR: Certaines routes de chat sont manquantes\n";
    if (!$hasChatRoutes) echo "      - Manque le groupe de routes chat\n";
    if (!$hasSendRoute) echo "      - Manque la route send\n";
    if (!$hasMessagesRoute) echo "      - Manque la route messages\n";
    if (!$hasUnreadRoute) echo "      - Manque la route unread-count\n";
}

// 3. Vérifier que les routes sont dans le groupe avec locale
$localeGroupPattern = '/Route::prefix\(\'\{locale\}\'\)->where.*?->group\(function.*?\{/s';
if (preg_match($localeGroupPattern, $routesContent, $matches)) {
    $localeGroupStart = strpos($routesContent, $matches[0]);
    $chatRoutesPos = strpos($routesContent, "Route::prefix('chat')");
    
    if ($chatRoutesPos > $localeGroupStart) {
        echo "   ✅ Les routes de chat sont dans le groupe avec préfixe de locale\n";
    } else {
        echo "   ⚠️  ATTENTION: Les routes de chat ne semblent pas être dans le groupe avec locale\n";
    }
} else {
    echo "   ⚠️  ATTENTION: Impossible de vérifier le groupe de locale\n";
}

// 4. Vérifier la documentation
echo "\n3. Vérification de la documentation...\n";
$docPath = __DIR__ . '/CHAT_CLIENT_ROUTE_FIX.md';

if (file_exists($docPath)) {
    echo "   ✅ Documentation créée: CHAT_CLIENT_ROUTE_FIX.md\n";
} else {
    echo "   ⚠️  Documentation manquante: CHAT_CLIENT_ROUTE_FIX.md\n";
}

// Résumé
echo "\n=== RÉSUMÉ ===\n";
$allGood = $hasRouteMessages && $hasRouteSend && $hasRouteUnread && 
           !$hasUrlMessages && !$hasUrlSend && !$hasUrlUnread &&
           $hasChatRoutes && $hasSendRoute && $hasMessagesRoute && $hasUnreadRoute;

if ($allGood) {
    echo "✅ Tous les tests sont passés avec succès!\n";
    echo "\nLe chatbot client devrait maintenant fonctionner correctement.\n";
    echo "Les URLs générées incluront automatiquement le préfixe de locale:\n";
    echo "  - /fr/chat/send (pour le français)\n";
    echo "  - /en/chat/send (pour l'anglais)\n";
    echo "  - etc.\n";
    echo "\nPour tester:\n";
    echo "1. Connectez-vous en tant qu'utilisateur client\n";
    echo "2. Accédez au tableau de bord\n";
    echo "3. Cliquez sur l'icône du chatbot en bas à droite\n";
    echo "4. Essayez d'envoyer un message\n";
    echo "5. Le message devrait être envoyé sans erreur\n";
} else {
    echo "❌ Certains tests ont échoué. Veuillez vérifier les erreurs ci-dessus.\n";
}

echo "\n";
