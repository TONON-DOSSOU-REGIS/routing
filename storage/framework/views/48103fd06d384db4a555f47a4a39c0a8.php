<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle inscription - Valtrix Bank</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io11/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io11/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io11/favicon-16x16.png">
  <link rel="manifest" href="/favicon_io11/site.webmanifest">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .info-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .info-row {
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #667eea;
            display: inline-block;
            width: 150px;
        }
        .value {
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 Nouvelle Inscription</h1>
        <p>Un nouvel utilisateur attend votre validation</p>
    </div>
    
    <div class="content">
        <p>Bonjour Administrateur,</p>
        
        <p>Un nouvel utilisateur vient de s'inscrire sur Valtrix Bank et attend votre validation pour accéder à son compte.</p>
        
        <div class="info-box">
            <h3 style="margin-top: 0; color: #667eea;">📋 Informations de l'utilisateur</h3>
            
            <div class="info-row">
                <span class="label">Nom complet:</span>
                <span class="value"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></span>
            </div>
            
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value"><?php echo e($user->email); ?></span>
            </div>
            
            <?php if($user->phone): ?>
            <div class="info-row">
                <span class="label">Téléphone:</span>
                <span class="value"><?php echo e($user->phone); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if($user->country): ?>
            <div class="info-row">
                <span class="label">Pays:</span>
                <span class="value"><?php echo e($user->country); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if($user->city): ?>
            <div class="info-row">
                <span class="label">Ville:</span>
                <span class="value"><?php echo e($user->city); ?></span>
            </div>
            <?php endif; ?>
            
            <div class="info-row">
                <span class="label">Date d'inscription:</span>
                <span class="value"><?php echo e($registrationTime->format('d/m/Y à H:i')); ?></span>
            </div>
            
            <div class="info-row">
                <span class="label">Adresse IP:</span>
                <span class="value"><?php echo e($ipAddress); ?></span>
            </div>
        </div>
        
        <div class="alert">
            <strong>⚠️ Action requise:</strong> Cet utilisateur ne pourra pas se connecter tant que vous n'aurez pas validé son compte.
        </div>
        
        <div style="text-align: center;">
            <a href="<?php echo e(url('/admin/users')); ?>" class="button">
                Gérer les utilisateurs
            </a>
        </div>
        
        <p style="margin-top: 30px; color: #666; font-size: 14px;">
            Pour valider cet utilisateur, connectez-vous à votre panneau d'administration et cliquez sur le bouton "Valider" à côté de son compte.
        </p>
    </div>
    
    <div class="footer">
        <p>Cet email a été envoyé automatiquement par Valtrix Bank.</p>
        <p>© <?php echo e(date('Y')); ?> Valtrix Bank. Tous droits réservés.</p>
    </div>
</body>
</html>




<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\emails\user_registration_notification.blade.php ENDPATH**/ ?>