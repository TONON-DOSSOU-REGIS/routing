<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de virement - SG BANK</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .email-container {
            max-width: 650px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 50px 40px;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: cover;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
            position: relative;
        }

        .header h2 {
            font-size: 20px;
            font-weight: 400;
            opacity: 0.95;
            position: relative;
        }

        .content {
            padding: 50px 40px;
            background: #ffffff;
        }

        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .greeting::before {
            content: '👋';
            font-size: 28px;
        }

        .success-banner {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 2px solid #10b981;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            position: relative;
            animation: successPulse 2s ease-in-out infinite;
        }

        @keyframes successPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
            }
            50% {
                transform: scale(1.01);
                box-shadow: 0 12px 35px rgba(16, 185, 129, 0.25);
            }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: white;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .success-title {
            font-size: 24px;
            font-weight: 700;
            color: #065f46;
            margin-bottom: 8px;
        }

        .success-subtitle {
            color: #047857;
            font-size: 16px;
        }

        .transaction-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            padding: 0;
            margin: 40px 0;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .card-header h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .transaction-details {
            padding: 30px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .detail-row:hover {
            background: rgba(255, 255, 255, 0.5);
            padding-left: 15px;
            padding-right: 15px;
            border-radius: 12px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .label i {
            width: 20px;
            text-align: center;
            color: #6b7280;
        }

        .value {
            color: #6b7280;
            text-align: right;
            font-size: 14px;
        }

        .amount-section {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 25px 30px;
            text-align: center;
            color: white;
        }

        .amount-label {
            font-size: 16px;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .amount {
            font-size: 42px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .info-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #0ea5e9;
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
        }

        .info-title {
            font-size: 16px;
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-title::before {
            content: '💡';
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            padding: 8px 0;
            color: #0369a1;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-list li::before {
            content: '→';
            color: #0ea5e9;
            font-weight: bold;
            flex-shrink: 0;
        }

        .support-section {
            background: #f8fafc;
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
            border-left: 4px solid #10b981;
        }

        .support-title {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
        }

        .support-contact {
            color: #10b981;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
        }

        .closing {
            margin: 40px 0 30px;
            text-align: center;
        }

        .signature {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .team {
            color: #6b7280;
            font-size: 15px;
        }

        .footer {
            background: #f8fafc;
            padding: 35px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            color: #9ca3af;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .security-notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 12px;
            padding: 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #92400e;
        }

        .copyright {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 12px;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            body {
                padding: 15px;
            }

            .email-container {
                border-radius: 20px;
            }

            .header {
                padding: 40px 25px;
            }

            .header h1 {
                font-size: 28px;
            }

            .header h2 {
                font-size: 18px;
            }

            .content {
                padding: 40px 25px;
            }

            .logo-icon {
                width: 50px;
                height: 50px;
                font-size: 24px;
            }

            .amount {
                font-size: 36px;
            }

            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                text-align: left;
            }

            .value {
                text-align: left;
            }

            .transaction-details {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- En-tête -->
        <div class="header">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-building-columns"></i>
                </div>
            </div>
            <h1>SG BANK</h1>
            <h2>Confirmation de virement</h2>
        </div>

        <!-- Contenu principal -->
        <div class="content">
            <!-- Salutation personnalisée -->
            <div class="greeting">
                Bonjour <strong><?php echo e($transaction->user->first_name); ?> <?php echo e($transaction->user->last_name); ?></strong>,
            </div>

            <!-- Bannière de succès -->
            <div class="success-banner">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="success-title">Virement effectué avec succès !</div>
                <div class="success-subtitle">Votre transaction a été traitée et votre compte a été débité</div>
            </div>

            <!-- Carte de transaction -->
            <div class="transaction-card">
                <div class="card-header">
                    <h3>Détails de la transaction</h3>
                    <p>Référence : #<?php echo e($transaction->id); ?></p>
                </div>
                
                <div class="amount-section">
                    <div class="amount-label">Montant du virement</div>
                    <div class="amount"><?php echo e(number_format($transaction->amount, 2, ',', ' ')); ?> €</div>
                </div>

                <div class="transaction-details">
                    <div class="detail-row">
                        <span class="label">
                            <i class="fas fa-user"></i>
                            Bénéficiaire
                        </span>
                        <span class="value"><?php echo e($transaction->recipient_name); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">
                            <i class="fas fa-credit-card"></i>
                            IBAN du bénéficiaire
                        </span>
                        <span class="value"><?php echo e($transaction->recipient_iban); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">
                            <i class="fas fa-university"></i>
                            Banque du bénéficiaire
                        </span>
                        <span class="value"><?php echo e($transaction->bank_name); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">
                            <i class="fas fa-comment"></i>
                            Motif du virement
                        </span>
                        <span class="value"><?php echo e($transaction->reason); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">
                            <i class="fas fa-calendar"></i>
                            Date et heure
                        </span>
                        <span class="value"><?php echo e($transaction->created_at->format('d/m/Y à H:i')); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">
                            <i class="fas fa-hashtag"></i>
                            Référence
                        </span>
                        <span class="value">#<?php echo e($transaction->id); ?></span>
                    </div>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="info-section">
                <div class="info-title">Informations importantes</div>
                <ul class="info-list">
                    <li>Vous pouvez consulter le détail de cette transaction dans votre historique de virements</li>
                    <li>Le débit de votre compte est effectif immédiatement</li>
                    <li>Le crédit sur le compte du bénéficiaire peut prendre 1 à 2 jours ouvrés</li>
                    <li>Conservez cette confirmation pour vos archives</li>
                </ul>
            </div>

            <!-- Support -->
            <div class="support-section">
                <div class="support-title">Des questions sur cette transaction ?</div>
                <p>Notre équipe de support est à votre disposition pour vous aider.</p>
                <a href="mailto:support@SG BANK.com" class="support-contact">support@SG BANK.com</a>
            </div>

            <!-- Signature -->
            <div class="closing">
                <div class="signature">Cordialement,</div>
                <div class="team">L'équipe SG BANK</div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Cet email a été envoyé automatiquement. Ne pas répondre à cet email.</p>
            <div class="security-notice">
                <strong>🛡️ Sécurité :</strong> SG BANK ne vous demandera jamais vos informations personnelles par email.
            </div>
            <div class="copyright">
                &copy; 2025 SG BANK. Tous droits réservés.<br>
                Votre confiance est notre priorité.
            </div>
        </div>
    </div>

    <!-- Font Awesome pour les icônes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>


<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/emails/transfer_confirmation.blade.php ENDPATH**/ ?>