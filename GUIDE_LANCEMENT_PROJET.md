# 🚀 Guide de Lancement du Projet Cerveau

## 📋 Informations sur le Projet

**Type:** Application Laravel 12  
**Framework Frontend:** Vite + Tailwind CSS 4  
**Base de données:** Configuration dans .env  
**Fonctionnalités principales:**
- Système multilingue (FR, EN, DE, ES, IT, NL, PL)
- Gestion des transactions
- Dashboard analytique
- Chat en temps réel
- Notifications
- Système d'authentification avec approbation admin

## ✅ Prérequis Vérifiés

- ✅ Composer installé (dépendances dans /vendor)
- ✅ NPM installé (dépendances dans /node_modules)
- ✅ Fichier .env présent
- ✅ Laravel 12 configuré

## 🎯 Plan de Lancement

### Étape 1: Vérification de la Configuration
- Vérifier la configuration de la base de données dans .env
- Vérifier l'APP_KEY

### Étape 2: Préparation de la Base de Données
- Exécuter les migrations
- Optionnel: Exécuter les seeders pour données de test

### Étape 3: Optimisation Laravel
- Nettoyer le cache
- Optimiser l'autoloader

### Étape 4: Compilation des Assets
- Compiler les assets frontend avec Vite

### Étape 5: Lancement des Serveurs
- Démarrer le serveur Laravel
- Démarrer Vite pour le hot reload
- Optionnel: Démarrer la queue pour les jobs

## 🔧 Commandes de Lancement

### Option 1: Lancement Rapide (Recommandé)
Le projet dispose d'un script composer pour tout lancer en une commande:

```bash
composer run dev
```

Cette commande lance simultanément:
- Le serveur Laravel (php artisan serve)
- La queue Laravel (php artisan queue:listen)
- Vite dev server (npm run dev)

### Option 2: Lancement Manuel Étape par Étape

#### 1. Vérifier et générer l'APP_KEY (si nécessaire)
```bash
php artisan key:generate
```

#### 2. Exécuter les migrations
```bash
php artisan migrate
```

#### 3. Nettoyer le cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

#### 4. Compiler les assets
```bash
npm run build
```

#### 5. Lancer le serveur (dans des terminaux séparés)

Terminal 1 - Serveur Laravel:
```bash
php artisan serve
```

Terminal 2 - Vite (optionnel, pour développement):
```bash
npm run dev
```

Terminal 3 - Queue (optionnel, pour les jobs):
```bash
php artisan queue:listen
```

## 🌐 Accès à l'Application

Une fois lancé, l'application sera accessible à:
- **URL principale:** http://localhost:8000
- **URL avec locale:** http://localhost:8000/fr (ou /en, /de, /es, /it, /nl, /pl)

## 📝 Comptes de Test

Si vous avez besoin de créer un compte administrateur:
```bash
php artisan tinker
```

Puis dans tinker:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@cerveau.com';
$user->password = bcrypt('password');
$user->is_admin = true;
$user->is_approved = true;
$user->save();
```

## 🔍 Vérifications Post-Lancement

1. ✅ La page d'accueil se charge correctement
2. ✅ Le sélecteur de langue fonctionne
3. ✅ Les traductions s'affichent correctement
4. ✅ Le système d'authentification fonctionne
5. ✅ Les assets CSS/JS sont chargés

## 🐛 Dépannage

### Erreur de base de données
- Vérifier les credentials dans .env
- Vérifier que MySQL/PostgreSQL est démarré
- Exécuter `php artisan migrate:fresh` (⚠️ supprime toutes les données)

### Erreur de permissions
```bash
chmod -R 775 storage bootstrap/cache
```

### Assets non chargés
```bash
npm run build
php artisan config:clear
```

### Erreur APP_KEY
```bash
php artisan key:generate
```

## 📚 Documentation Complémentaire

- MULTILINGUAL_SYSTEM_FINAL_REPORT.md - Système multilingue
- IMPLEMENTATION_STATUS_FINAL.md - État des fonctionnalités
- BUGS_FIXED_COMPLETE.md - Corrections effectuées
- GUIDE_MIGRATION.md - Guide de migration

## 🎉 Prochaines Étapes

Après le lancement réussi:
1. Créer un compte administrateur
2. Configurer les paramètres de l'application
3. Tester les fonctionnalités principales
4. Consulter les TODO pour les améliorations futures

---

**Note:** Ce projet utilise XAMPP. Assurez-vous que Apache et MySQL sont démarrés dans le panneau de contrôle XAMPP.
