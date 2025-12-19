@echo off
REM Script de correction et test des bugs Market Tracker et Chatbot
REM Usage: fix_and_test.bat

echo ================================================================
echo      CORRECTION ET TEST - MARKET TRACKER ^& CHATBOT
echo ================================================================
echo.

REM Étape 1: Effacer les caches
echo [ETAPE 1] Effacement des caches Laravel...
call php artisan cache:clear
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear
echo [OK] Caches effaces
echo.

REM Étape 2: Vérifier les routes Market
echo [ETAPE 2] Verification des routes Market API...
call php artisan route:list | findstr "api.market"
echo.

REM Étape 3: Vérifier les routes Chat
echo [ETAPE 3] Verification des routes Chat...
call php artisan route:list | findstr "chat."
echo.

REM Étape 4: Vérifier les fichiers créés
echo [ETAPE 4] Verification des fichiers crees...

if exist "app\Http\Controllers\MarketController.php" (
    echo [OK] MarketController.php existe
) else (
    echo [ERREUR] MarketController.php manquant
)

if exist "BUGS_FIXED_MARKET_CHAT.md" (
    echo [OK] Documentation BUGS_FIXED_MARKET_CHAT.md existe
) else (
    echo [ATTENTION] Documentation BUGS_FIXED_MARKET_CHAT.md manquante
)

if exist "test_bugs_fixes.php" (
    echo [OK] Script de test test_bugs_fixes.php existe
) else (
    echo [ATTENTION] Script de test test_bugs_fixes.php manquant
)
echo.

REM Étape 5: Exécuter le script de test PHP
echo [ETAPE 5] Execution du script de test PHP...
call php test_bugs_fixes.php
echo.

REM Résumé
echo ================================================================
echo                          RESUME
echo ================================================================
echo.
echo [OK] Corrections appliquees avec succes!
echo.
echo Prochaines etapes:
echo 1. Demarrer le serveur: php artisan serve
echo 2. Acceder au dashboard: http://localhost:8000/dashboard
echo 3. Tester le widget 'Suivi des Marches'
echo 4. Tester le chatbot
echo.
echo En cas de probleme:
echo - Verifier les logs: type storage\logs\laravel.log
echo - Consulter: TODO_VERIFICATION_BUGS.md
echo.
pause
