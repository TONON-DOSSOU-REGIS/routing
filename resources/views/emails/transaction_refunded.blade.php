<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remboursement de virement - Zuider Bank S.A</title>
    @include('partials.favicon')
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .success-icon {
            text-align: center;
            font-size: 60px;
            margin: 20px 0;
        }
        .info-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #10b981;
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
            color: #10b981;
            display: inline-block;
            width: 180px;
        }
        .value {
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            font-size: 16px;
        }
        .button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .alert-success {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>💰 Remboursement Effectué</h1>
        <p>Votre virement a été remboursé</p>
    </div>
    
    <div class="content">
        <div class="success-icon">
            ✅
        </div>
        
        <p>Bonjour <strong>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</strong>,</p>
        
        <p>Nous vous informons que votre virement a été remboursé sur votre compte Zuider Bank S.A.</p>
        
        <div class="info-box">
            <h3 style="margin-top: 0; color: #10b981;">📋 Détails du remboursement</h3>
            
            <div class="info-row">
                <span class="label">Montant remboursé:</span>
                <span class="value"><strong>{{ number_format($transaction->amount, 2, ',', ' ') }} €</strong></span>
            </div>
            
            <div class="info-row">
                <span class="label">Transaction originale:</span>
                <span class="value">#{{ $transaction->id }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Bénéficiaire initial:</span>
                <span class="value">{{ $transaction->recipient_name }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Date du virement:</span>
                <span class="value">{{ $transaction->created_at->format('d/m/Y à H:i') }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Date du remboursement:</span>
                <span class="value">{{ now()->format('d/m/Y à H:i') }}</span>
            </div>
            
            @if($refundReason)
            <div class="info-row">
                <span class="label">Motif du remboursement:</span>
                <span class="value">{{ $refundReason }}</span>
            </div>
            @endif
        </div>
        
        <div class="alert-success">
            <strong>✅ Fonds crédités:</strong> Le montant de {{ number_format($transaction->amount, 2, ',', ' ') }} € a été recrédité sur votre compte.
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/dashboard') }}" class="button">
                Voir mon compte
            </a>
        </div>
        
        <p style="margin-top: 30px; color: #666; font-size: 14px;">
            Votre nouveau solde est disponible immédiatement. Vous pouvez consulter votre compte pour vérifier le remboursement.
        </p>
        
        <p style="color: #666; font-size: 14px;">
            Si vous avez des questions concernant ce remboursement, n'hésitez pas à contacter notre service client.
        </p>
    </div>
    
    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p>© {{ date('Y') }} Zuider Bank S.A. Tous droits réservés.</p>
    </div>
</body>
</html>



