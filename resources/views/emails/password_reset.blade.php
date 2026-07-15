<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - Zuider Bank S.A</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.favicon')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
        }

        .header h2 {
            font-size: 18px;
            font-weight: 400;
            opacity: 0.9;
            position: relative;
        }

        .content {
            padding: 40px 30px;
            background: #ffffff;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .greeting::before {
            content: '👋';
            font-size: 24px;
        }

        .message {
            color: #6b7280;
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .password-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px dashed #0ea5e9;
            border-radius: 20px;
            padding: 32px;
            margin: 32px 0;
            text-align: center;
            position: relative;
        }

        .password-section::before {
            content: '🔒';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .password-label {
            font-size: 16px;
            font-weight: 600;
            color: #0369a1;
            margin-bottom: 16px;
        }

        .password {
            font-size: 32px;
            font-weight: 700;
            color: #dc2626;
            font-family: 'Courier New', monospace;
            background: rgba(255, 255, 255, 0.8);
            padding: 16px 24px;
            border-radius: 12px;
            border: 2px solid #fecaca;
            letter-spacing: 2px;
            margin: 16px 0;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.1);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 12px rgba(220, 38, 38, 0.1);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 6px 20px rgba(220, 38, 38, 0.2);
            }
        }

        .warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fef7cd 100%);
            border: 2px solid #f59e0b;
            border-radius: 16px;
            padding: 24px;
            margin: 32px 0;
            position: relative;
        }

        .warning::before {
            content: '⚠️';
            position: absolute;
            top: -16px;
            left: 24px;
            background: #fef3c7;
            padding: 8px 12px;
            border-radius: 50px;
            font-size: 18px;
            border: 2px solid #f59e0b;
        }

        .warning-title {
            font-size: 16px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .warning-list {
            list-style: none;
            padding: 0;
        }

        .warning-list li {
            padding: 8px 0;
            color: #92400e;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .warning-list li::before {
            content: '•';
            color: #f59e0b;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }

        .security-tips {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #16a34a;
            border-radius: 16px;
            padding: 24px;
            margin: 24px 0;
        }

        .security-title {
            font-size: 16px;
            font-weight: 700;
            color: #166534;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-title::before {
            content: '🛡️';
        }

        .security-list {
            list-style: none;
            padding: 0;
        }

        .security-list li {
            padding: 8px 0;
            color: #166534;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .security-list li::before {
            content: '✓';
            color: #16a34a;
            font-weight: bold;
            font-size: 14px;
            background: rgba(22, 163, 74, 0.1);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .support {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
            text-align: center;
            border-left: 4px solid #2563eb;
        }

        .support p {
            color: #6b7280;
            margin-bottom: 8px;
        }

        .support-contact {
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
        }

        .closing {
            margin: 32px 0;
            text-align: center;
        }

        .signature {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .team {
            color: #6b7280;
            font-size: 14px;
        }

        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            color: #9ca3af;
            font-size: 12px;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .copyright {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 11px;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .email-container {
                margin: 10px;
                border-radius: 16px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .password {
                font-size: 24px;
                padding: 12px 20px;
            }

            .password-section,
            .warning,
            .security-tips {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- En-tête -->
        <div class="header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-building-columns"></i>
                </div>
            </div>
            <h1>Zuider Bank S.A</h1>
            <h2>Réinitialisation de votre mot de passe</h2>
        </div>

        <!-- Contenu principal -->
        <div class="content">
            <!-- Salutation personnalisée -->
            <div class="greeting">
                Bonjour <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,
            </div>

            <!-- Message d'introduction -->
            <div class="message">
                Votre mot de passe a été réinitialisé par un administrateur pour des raisons de sécurité. 
                Voici votre nouveau mot de passe temporaire :
            </div>

            <!-- Section du mot de passe -->
            <div class="password-section">
                <div class="password-label">Votre nouveau mot de passe :</div>
                <div class="password">{{ $newPassword }}</div>
                <div style="color: #6b7280; font-size: 14px; margin-top: 8px;">
                    Mot de passe temporaire - À changer dès la première connexion
                </div>
            </div>

            <!-- Avertissements de sécurité -->
            <div class="warning">
                <div class="warning-title">
                    Important - Consignes de sécurité
                </div>
                <ul class="warning-list">
                    <li>Conservez ce mot de passe en lieu sûr et confidentiel</li>
                    <li>Changez-le dès que possible après votre première connexion</li>
                    <li>Ne partagez jamais votre mot de passe avec qui que ce soit</li>
                    <li>Utilisez un mot de passe unique que vous n'utilisez nulle part ailleurs</li>
                </ul>
            </div>

            <!-- Conseils de sécurité -->
            <div class="security-tips">
                <div class="security-title">
                    Pour votre sécurité
                </div>
                <ul class="security-list">
                    <li>Activez l'authentification à deux facteurs si disponible</li>
                    <li>Vérifiez régulièrement l'activité de votre compte</li>
                    <li>Signalez toute activité suspecte immédiatement</li>
                    <li>Évitez d'utiliser des réseaux Wi-Fi publics pour accéder à votre compte</li>
                </ul>
            </div>

            <!-- Support -->
            <div class="support">
                <p>Si vous n'avez pas demandé cette réinitialisation ou si vous avez des questions,</p>
                <p>contactez immédiatement notre support :</p>
                <a href="mailto:support@zuiderbank.com" class="support-contact">support@zuiderbank.com</a>
            </div>

            <!-- Signature -->
            <div class="closing">
                <div class="signature">Cordialement,</div>
                <div class="team">L'équipe Zuider Bank S.A</div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Cet email a été envoyé automatiquement. Ne pas répondre à cet email.</p>
            <p>Pour votre sécurité, ne transférez jamais cet email à qui que ce soit.</p>
            <div class="copyright">
                &copy; 2025 Zuider Bank S.A. Tous droits réservés.<br>
                Votre sécurité est notre priorité.
            </div>
        </div>
    </div>

    <!-- Font Awesome pour les icônes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>

