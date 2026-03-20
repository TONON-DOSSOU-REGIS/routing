<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt reçu</title>
    @include('partials.favicon')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .amount-box {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
        }
        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .amount-value {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        .transaction-details {
            background-color: #f9fafb;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .transaction-details h3 {
            margin-top: 0;
            color: #667eea;
            font-size: 16px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #6b7280;
            font-weight: 500;
        }
        .detail-value {
            color: #111827;
            font-weight: 600;
        }
        .message {
            color: #4b5563;
            line-height: 1.8;
            margin: 20px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 6px;
            margin: 25px 0;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(102, 126, 234, 0.4);
        }
        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 5px;
            }
            .content {
                padding: 25px 20px;
            }
            .amount-value {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">💰</div>
            <h1>Dépôt Reçu</h1>
        </div>
        
        <div class="content">
            <p class="greeting">Bonjour {{ $user->first_name }} {{ $user->last_name }},</p>
            
            <p class="message">
                Nous avons le plaisir de vous informer qu'un dépôt a été effectué avec succès sur votre compte.
            </p>
            
            <div class="amount-box">
                <div class="amount-label">Montant crédité</div>
                <div class="amount-value">{{ $amount }}</div>
            </div>
            
            <div class="transaction-details">
                <h3>📋 Détails de la transaction</h3>
                <div class="detail-row">
                    <span class="detail-label">Numéro de transaction</span>
                    <span class="detail-value">#{{ $transaction->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Type</span>
                    <span class="detail-value">Dépôt</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Statut</span>
                    <span class="detail-value" style="color: #10b981;">✓ Réussi</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date</span>
                    <span class="detail-value">{{ $transaction->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                @if($transaction->reason)
                <div class="detail-row">
                    <span class="detail-label">Motif</span>
                    <span class="detail-value">{{ $transaction->reason }}</span>
                </div>
                @endif
            </div>
            
            <p class="message">
                Le montant est maintenant disponible sur votre compte et vous pouvez l'utiliser immédiatement pour vos transactions.
            </p>
            
            <center>
                <a href="{{ url('/dashboard') }}" class="cta-button">
                    Voir mon compte
                </a>
            </center>
            
            <p class="message" style="margin-top: 30px; font-size: 14px; color: #6b7280;">
                <strong>Note de sécurité :</strong> Si vous n'êtes pas à l'origine de cette transaction ou si vous avez des questions, 
                veuillez contacter immédiatement notre service client.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>Cerveau Banking</strong></p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>© {{ date('Y') }} Cerveau Banking. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
