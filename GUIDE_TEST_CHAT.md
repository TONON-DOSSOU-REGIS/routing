# 🧪 Guide de Test - Système de Chat SG BANK

## Prérequis

1. ✅ Serveur Laravel en cours d'exécution (`php artisan serve`)
2. ✅ Base de données configurée et migrations exécutées
3. ✅ Compte admin créé (admin@SG BANK.com / admin123)
4. ✅ Au moins un compte utilisateur créé et approuvé

---

## 📋 Tests à Effectuer

### Test 1: Vérification de l'Installation

```bash
# Vérifier que la migration a été exécutée
php artisan migrate:status

# Devrait afficher:
# ✓ 2025_11_28_000000_create_chat_messages_table
```

**Résultat attendu:** ✅ Migration présente et exécutée

---

### Test 2: Connexion Utilisateur et Widget Chat

1. **Créer un utilisateur de test:**
   ```bash
   php test_registration.php
   ```

2. **Se connecter en tant qu'admin:**
   - URL: http://localhost:8000/login
   - Email: admin@SG BANK.com
   - Password: admin123

3. **Approuver l'utilisateur:**
   - Aller sur: http://localhost:8000/admin/users
   - Trouver l'utilisateur avec statut "pending"
   - Cliquer sur "Valider"

4. **Se connecter en tant qu'utilisateur:**
   - Se déconnecter de l'admin
   - Se connecter avec le compte utilisateur créé
   - Aller sur: http://localhost:8000/profile

5. **Vérifier le widget chat:**
   - ✅ Un bouton de chat bleu devrait apparaître en bas à droite
   - ✅ Cliquer dessus devrait ouvrir une fenêtre de chat
   - ✅ Le message de bienvenue devrait s'afficher

**Résultat attendu:** Widget visible et fonctionnel

---

### Test 3: Envoi de Message Utilisateur → Admin

1. **En tant qu'utilisateur connecté:**
   - Ouvrir le widget de chat
   - Taper un message: "Bonjour, j'ai besoin d'aide"
   - Appuyer sur Entrée ou cliquer sur le bouton d'envoi

2. **Vérifier dans la console du navigateur:**
   - Ouvrir les DevTools (F12)
   - Onglet Console
   - Vérifier qu'il n'y a pas d'erreurs

3. **Vérifier dans la base de données:**
   ```bash
   php artisan tinker
   ```
   ```php
   \App\Models\ChatMessage::latest()->first()
   // Devrait afficher le message envoyé
   ```

**Résultat attendu:** 
- ✅ Message envoyé sans erreur
- ✅ Message visible dans le chat
- ✅ Message enregistré en base de données

---

### Test 4: Réception de Message par l'Admin

1. **Se connecter en tant qu'admin:**
   - URL: http://localhost:8000/login
   - Email: admin@SG BANK.com
   - Password: admin123

2. **Aller sur le dashboard admin:**
   - URL: http://localhost:8000/admin/dashboard

3. **Vérifier le widget admin:**
   - ✅ Un bouton de chat violet devrait apparaître en bas à droite
   - ✅ Un badge rouge avec le nombre de messages non lus devrait être visible
   - ✅ Cliquer dessus devrait ouvrir la liste des conversations

4. **Ouvrir la conversation:**
   - Cliquer sur la conversation de l'utilisateur
   - ✅ Le message "Bonjour, j'ai besoin d'aide" devrait être visible

**Résultat attendu:** 
- ✅ Badge de notification visible
- ✅ Liste des conversations affichée
- ✅ Message de l'utilisateur visible

---

### Test 5: Réponse de l'Admin

1. **En tant qu'admin dans la conversation:**
   - Taper une réponse: "Bonjour ! Comment puis-je vous aider ?"
   - Envoyer le message

2. **Vérifier:**
   - ✅ Le message apparaît immédiatement dans la conversation
   - ✅ Le message est aligné à droite (message admin)
   - ✅ Le message a une couleur différente (violet pour admin)

**Résultat attendu:** Message envoyé et affiché correctement

---

### Test 6: Réception par l'Utilisateur

1. **Retourner sur le compte utilisateur:**
   - Se déconnecter de l'admin
   - Se reconnecter en tant qu'utilisateur
   - Aller sur le profil

2. **Ouvrir le widget de chat:**
   - ✅ Un badge rouge devrait indiquer 1 nouveau message
   - Ouvrir le chat
   - ✅ La réponse de l'admin devrait être visible

3. **Vérifier le marquage comme lu:**
   - Après ouverture du chat, le badge devrait disparaître

**Résultat attendu:** 
- ✅ Notification de nouveau message
- ✅ Message de l'admin visible
- ✅ Badge disparaît après lecture

---

### Test 7: Conversation Continue

1. **Envoyer plusieurs messages:**
   - Utilisateur: "J'ai un problème avec mon compte"
   - Admin: "Quel est le problème exactement ?"
   - Utilisateur: "Je ne peux pas faire de virement"
   - Admin: "Je vais vérifier votre compte"

2. **Vérifier:**
   - ✅ Tous les messages s'affichent dans l'ordre
   - ✅ Le scroll automatique fonctionne
   - ✅ Les messages sont bien différenciés (utilisateur vs admin)
   - ✅ Les horodatages sont corrects

**Résultat attendu:** Conversation fluide et bien formatée

---

### Test 8: Polling en Temps Réel

1. **Ouvrir deux navigateurs différents:**
   - Navigateur 1: Connecté en tant qu'utilisateur
   - Navigateur 2: Connecté en tant qu'admin

2. **Ouvrir les chats dans les deux navigateurs**

3. **Envoyer un message depuis le navigateur 1 (utilisateur)**

4. **Observer le navigateur 2 (admin):**
   - ✅ Le message devrait apparaître dans les 3-5 secondes
   - ✅ Le badge de notification devrait se mettre à jour

5. **Répondre depuis le navigateur 2 (admin)**

6. **Observer le navigateur 1 (utilisateur):**
   - ✅ La réponse devrait apparaître dans les 3 secondes

**Résultat attendu:** Mise à jour automatique des messages

---

### Test 9: Multiples Conversations (Admin)

1. **Créer 2-3 utilisateurs supplémentaires:**
   ```bash
   php test_registration.php
   # Répéter 2-3 fois avec des emails différents
   ```

2. **Approuver tous les utilisateurs**

3. **Envoyer des messages depuis chaque utilisateur**

4. **En tant qu'admin:**
   - Ouvrir le widget de chat
   - ✅ Toutes les conversations devraient être listées
   - ✅ Le compteur de messages non lus devrait être correct pour chaque conversation
   - ✅ Cliquer sur une conversation devrait ouvrir le chat avec cet utilisateur

**Résultat attendu:** Gestion correcte de multiples conversations

---

### Test 10: Persistance des Données

1. **Envoyer quelques messages**

2. **Fermer le navigateur complètement**

3. **Rouvrir et se reconnecter**

4. **Ouvrir le chat:**
   - ✅ Tous les messages précédents devraient être visibles
   - ✅ L'historique complet devrait être chargé

**Résultat attendu:** Historique des messages conservé

---

## 🔍 Vérifications Techniques

### Vérifier les Routes

```bash
php artisan route:list | grep chat
```

**Devrait afficher:**
```
POST   chat/send ........................... chat.send
GET    chat/messages/{userId?} ............. chat.messages
GET    chat/unread-count ................... chat.unread
POST   chat/mark-read/{userId} ............. chat.markRead
```

---

### Vérifier la Base de Données

```bash
php artisan tinker
```

```php
// Compter les messages
\App\Models\ChatMessage::count()

// Voir les derniers messages
\App\Models\ChatMessage::with(['sender', 'receiver'])->latest()->take(5)->get()

// Voir les messages non lus
\App\Models\ChatMessage::unread()->count()
```

---

### Vérifier les Logs

```bash
tail -f storage/logs/laravel.log
```

Envoyer un message et vérifier qu'il n'y a pas d'erreurs dans les logs.

---

## 🐛 Dépannage

### Problème: Le widget ne s'affiche pas

**Solutions:**
1. Vérifier que le fichier existe: `resources/views/components/chat-widget.blade.php`
2. Vérifier que l'include est présent dans la vue: `@include('components.chat-widget')`
3. Vider le cache: `php artisan view:clear`

---

### Problème: Erreur 404 sur les routes chat

**Solutions:**
1. Vérifier les routes: `php artisan route:list | grep chat`
2. Vider le cache des routes: `php artisan route:clear`
3. Vérifier que le middleware auth est appliqué

---

### Problème: Messages ne s'affichent pas

**Solutions:**
1. Ouvrir la console du navigateur (F12) et vérifier les erreurs
2. Vérifier que le CSRF token est correct
3. Vérifier les permissions de la base de données
4. Tester la route manuellement: `curl http://localhost:8000/chat/messages`

---

### Problème: Polling ne fonctionne pas

**Solutions:**
1. Vérifier la console du navigateur pour les erreurs JavaScript
2. Vérifier que le serveur Laravel est en cours d'exécution
3. Augmenter l'intervalle de polling si nécessaire (dans le code JavaScript)

---

## ✅ Checklist Finale

- [ ] Migration exécutée avec succès
- [ ] Widget utilisateur visible sur le profil
- [ ] Widget admin visible sur le dashboard admin
- [ ] Envoi de message utilisateur → admin fonctionne
- [ ] Réception de message par l'admin fonctionne
- [ ] Réponse de l'admin → utilisateur fonctionne
- [ ] Badge de notification fonctionne
- [ ] Polling en temps réel fonctionne
- [ ] Multiples conversations gérées correctement
- [ ] Historique des messages persistant
- [ ] Aucune erreur dans les logs
- [ ] Aucune erreur dans la console du navigateur

---

## 📊 Métriques de Performance

### À surveiller:
- Temps de réponse des requêtes AJAX (< 200ms)
- Utilisation CPU pendant le polling (< 5%)
- Taille des réponses JSON (< 50KB)
- Nombre de requêtes par minute (max 20 par utilisateur)

---

## 🎉 Conclusion

Si tous les tests passent, le système de chat est **100% fonctionnel** et prêt pour la production !

**Note:** Pour une utilisation en production, considérez l'implémentation de WebSockets (Laravel Echo + Pusher) pour remplacer le polling et améliorer les performances.

---

**Testé par:** _________________
**Date:** _________________
**Résultat:** ✅ PASS / ❌ FAIL
**Notes:** _________________

