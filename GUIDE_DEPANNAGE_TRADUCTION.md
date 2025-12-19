# 🔧 GUIDE DE DÉPANNAGE - TRADUCTION NE FONCTIONNE PAS

## ⚠️ ÉTAPES CRITIQUES À SUIVRE

### 1. REDÉMARRER LE SERVEUR WEB (OBLIGATOIRE)

Le middleware a été ajouté dans `bootstrap/app.php`. Laravel doit être redémarré pour prendre en compte ce changement.

#### Si vous utilisez `php artisan serve`:
```bash
# Arrêter le serveur (Ctrl+C)
# Puis relancer:
php artisan serve
```

#### Si vous utilisez XAMPP:
1. Arrêter Apache dans le panneau de contrôle XAMPP
2. Attendre 5 secondes
3. Redémarrer Apache

#### Si vous utilisez un autre serveur:
- Redémarrez complètement le serveur web

### 2. VIDER TOUS LES CACHES

```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 3. VIDER LE CACHE DU NAVIGATEUR

**Chrome/Edge:**
- Ctrl + Shift + Delete
- Cocher "Images et fichiers en cache"
- Cliquer sur "Effacer les données"

**Firefox:**
- Ctrl + Shift + Delete
- Cocher "Cache"
- Cliquer sur "Effacer maintenant"

**OU utilisez le mode navigation privée/incognito**

### 4. VÉRIFIER QUE LES MODIFICATIONS SONT BIEN PRISES EN COMPTE

Ouvrez `bootstrap/app.php` et vérifiez que vous avez bien:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        \App\Http\Middleware\SetLocale::class,  // ← CETTE LIGNE DOIT ÊTRE LÀ
    ]);
    
    $middleware->alias([
        'admin' => \App\Http\Middleware\IsAdmin::class,
        'isAdmin' => \App\Http\Middleware\IsAdmin::class,
    ]);
})
```

### 5. TESTER LE CHANGEMENT DE LANGUE

1. Ouvrez votre site dans un **nouvel onglet en mode privé**
2. Cliquez sur le sélecteur de langue (drapeau en haut à droite)
3. Sélectionnez une langue (par exemple Deutsch/DE)
4. La page devrait se recharger avec la nouvelle langue

### 6. VÉRIFIER LES SESSIONS EN BASE DE DONNÉES

```bash
php artisan tinker
```

Puis dans tinker:
```php
DB::table('sessions')->count();  // Doit retourner un nombre > 0
DB::table('sessions')->latest('last_activity')->first();  // Voir la dernière session
```

## 🐛 PROBLÈMES COURANTS

### Problème 1: "La page reste en français"

**Solution:**
1. Vérifiez que le serveur a été redémarré
2. Videz le cache du navigateur (ou utilisez mode privé)
3. Vérifiez que `bootstrap/app.php` contient bien le middleware

### Problème 2: "Le sélecteur de langue n'apparaît pas"

**Solution:**
Vérifiez que `resources/views/home.blade.php` contient:
```blade
<x-language-selector />
```

### Problème 3: "Erreur 500 après changement de langue"

**Solution:**
```bash
php artisan optimize:clear
tail -f storage/logs/laravel.log  # Voir les erreurs
```

### Problème 4: "Les traductions affichent les clés (home.hero_title_1)"

**Solution:**
Vérifiez que les fichiers de traduction existent:
```bash
ls -la lang/de/home.php
ls -la lang/nl/home.php
ls -la lang/es/home.php
ls -la lang/pl/home.php
ls -la lang/it/home.php
```

## 🧪 TEST MANUEL COMPLET

### Test 1: Vérifier que le middleware est chargé

```bash
php artisan route:list | grep language
```

Vous devriez voir:
```
POST  language/{locale} ... language.switch
```

### Test 2: Tester manuellement le changement

1. Ouvrez votre navigateur en mode privé
2. Allez sur votre site (ex: http://localhost/cerveau/public)
3. Ouvrez les outils de développement (F12)
4. Allez dans l'onglet "Network"
5. Cliquez sur une langue dans le sélecteur
6. Vérifiez que:
   - Une requête POST est envoyée vers `/language/de` (ou autre)
   - La page se recharge
   - Le contenu change de langue

### Test 3: Vérifier la session

Dans les outils de développement:
1. Onglet "Application" (Chrome) ou "Stockage" (Firefox)
2. Cookies → votre domaine
3. Cherchez le cookie `laravel_session`
4. Il doit exister et avoir une valeur

## 📋 CHECKLIST FINALE

Avant de dire que ça ne fonctionne pas, vérifiez:

- [ ] Le serveur web a été redémarré
- [ ] Le cache Laravel a été vidé (`php artisan optimize:clear`)
- [ ] Le cache du navigateur a été vidé (ou mode privé utilisé)
- [ ] Le fichier `bootstrap/app.php` contient le middleware SetLocale
- [ ] Les fichiers de traduction existent pour toutes les langues
- [ ] La table `sessions` existe en base de données
- [ ] Le sélecteur de langue est visible sur la page

## 🆘 SI ÇA NE FONCTIONNE TOUJOURS PAS

Exécutez ce script de diagnostic:

```bash
php test_language_debug.php
```

Et envoyez-moi le résultat complet, en particulier la ligne:
```
7. Middleware SetLocale: Enregistré dans 'web': ✅ ou ❌
```

Si c'est ❌, le middleware n'est pas enregistré correctement.
Si c'est ✅, le problème vient d'ailleurs (cache navigateur, serveur non redémarré, etc.)

## 💡 SOLUTION RAPIDE

Si vous êtes pressé, essayez cette séquence:

```bash
# 1. Vider tous les caches
php artisan optimize:clear

# 2. Redémarrer le serveur (si php artisan serve)
# Ctrl+C puis:
php artisan serve

# 3. Ouvrir en mode privé
# Chrome: Ctrl+Shift+N
# Firefox: Ctrl+Shift+P

# 4. Tester le changement de langue
```

---

**Note importante:** Les modifications dans `bootstrap/app.php` nécessitent TOUJOURS un redémarrage du serveur web. C'est le fichier de bootstrap de Laravel qui est chargé au démarrage de l'application.
