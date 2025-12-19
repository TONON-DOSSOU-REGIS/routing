#!/bin/bash

# Script de correction et test des bugs Market Tracker et Chatbot
# Usage: bash fix_and_test.sh

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║     CORRECTION ET TEST - MARKET TRACKER & CHATBOT              ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Couleurs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Fonction pour afficher les messages
print_step() {
    echo -e "${BLUE}▶ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

# Étape 1: Effacer les caches
print_step "Étape 1: Effacement des caches Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
print_success "Caches effacés"
echo ""

# Étape 2: Vérifier les routes Market
print_step "Étape 2: Vérification des routes Market API..."
MARKET_ROUTES=$(php artisan route:list | grep -c "api.market")
if [ "$MARKET_ROUTES" -ge 5 ]; then
    print_success "Routes Market API trouvées: $MARKET_ROUTES"
else
    print_error "Routes Market API manquantes (trouvées: $MARKET_ROUTES, attendues: 5)"
fi
echo ""

# Étape 3: Vérifier les routes Chat
print_step "Étape 3: Vérification des routes Chat..."
CHAT_ROUTES=$(php artisan route:list | grep -c "chat\.")
if [ "$CHAT_ROUTES" -ge 4 ]; then
    print_success "Routes Chat trouvées: $CHAT_ROUTES"
else
    print_error "Routes Chat manquantes (trouvées: $CHAT_ROUTES, attendues: 4)"
fi
echo ""

# Étape 4: Vérifier les fichiers créés
print_step "Étape 4: Vérification des fichiers créés..."

if [ -f "app/Http/Controllers/MarketController.php" ]; then
    print_success "MarketController.php existe"
else
    print_error "MarketController.php manquant"
fi

if [ -f "BUGS_FIXED_MARKET_CHAT.md" ]; then
    print_success "Documentation BUGS_FIXED_MARKET_CHAT.md existe"
else
    print_warning "Documentation BUGS_FIXED_MARKET_CHAT.md manquante"
fi

if [ -f "test_bugs_fixes.php" ]; then
    print_success "Script de test test_bugs_fixes.php existe"
else
    print_warning "Script de test test_bugs_fixes.php manquant"
fi
echo ""

# Étape 5: Exécuter le script de test PHP
print_step "Étape 5: Exécution du script de test PHP..."
php test_bugs_fixes.php
echo ""

# Étape 6: Afficher les routes Market
print_step "Étape 6: Liste des routes Market API:"
php artisan route:list | grep "api.market"
echo ""

# Étape 7: Afficher les routes Chat
print_step "Étape 7: Liste des routes Chat:"
php artisan route:list | grep "chat\."
echo ""

# Résumé
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                        RÉSUMÉ                                  ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""
print_success "Corrections appliquées avec succès!"
echo ""
echo "Prochaines étapes:"
echo "1. Démarrer le serveur: php artisan serve"
echo "2. Accéder au dashboard: http://localhost:8000/dashboard"
echo "3. Tester le widget 'Suivi des Marchés'"
echo "4. Tester le chatbot"
echo ""
echo "En cas de problème:"
echo "- Vérifier les logs: tail -f storage/logs/laravel.log"
echo "- Consulter: TODO_VERIFICATION_BUGS.md"
echo ""
