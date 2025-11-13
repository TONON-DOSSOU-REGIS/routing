<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - BankPro</title>
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
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8fafc;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .password-box {
            background-color: #fff;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .password {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            font-family: monospace;
        }
        .warning {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BankPro</h1>
        <h2>Réinitialisation de votre mot de passe</h2>
    </div>

    <div class="content">
        <p>Bonjour <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>

        <p>Votre mot de passe a été réinitialisé par un administrateur pour des raisons de sécurité.</p>

        <div class="password-box">
            <p><strong>Votre nouveau mot de passe :</strong></p>
            <div class="password">{{ $newPassword }}</div>
        </div>

        <div class="warning">
            <strong>⚠️ Important :</strong>
            <ul>
                <li>Conservez ce mot de passe en lieu sûr</li>
                <li>Changez-le dès que possible après votre première connexion</li>
                <li>Ne partagez jamais votre mot de passe avec qui que ce soit</li>
            </ul>
        </div>

        <p>Si vous n'avez pas demandé cette réinitialisation ou si vous avez des questions, contactez immédiatement le support.</p>

        <p>Cordialement,<br>
        L'équipe BankPro</p>
    </div>

    <div class="footer">
        <p>Cet email a été envoyé automatiquement. Ne pas répondre à cet email.</p>
        <p>&copy; 2025 BankPro. Tous droits réservés.</p>
    </div>
</body>
</html>
