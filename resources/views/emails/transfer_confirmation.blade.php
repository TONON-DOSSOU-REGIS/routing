<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de virement - BankPro</title>
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
            background-color: #10b981;
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
        .transaction-details {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f3f4f6;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #374151;
        }
        .value {
            color: #6b7280;
        }
        .amount {
            font-size: 18px;
            font-weight: bold;
            color: #10b981;
        }
        .success-message {
            background-color: #d1fae5;
            border: 1px solid #10b981;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
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
        <h2>Confirmation de virement</h2>
    </div>

    <div class="content">
        <p>Bonjour <strong>{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</strong>,</p>

        <div class="success-message">
            <strong>✅ Votre virement a été effectué avec succès !</strong>
        </div>

        <p>Votre transaction a été traitée et votre compte a été débité du montant indiqué ci-dessous.</p>

        <div class="transaction-details">
            <div class="detail-row">
                <span class="label">Montant :</span>
                <span class="value amount">{{ number_format($transaction->amount, 2, ',', ' ') }} €</span>
            </div>
            <div class="detail-row">
                <span class="label">Bénéficiaire :</span>
                <span class="value">{{ $transaction->recipient_name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">IBAN du bénéficiaire :</span>
                <span class="value">{{ $transaction->recipient_iban }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Banque du bénéficiaire :</span>
                <span class="value">{{ $transaction->bank_name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Motif :</span>
                <span class="value">{{ $transaction->reason }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Date et heure :</span>
                <span class="value">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Référence transaction :</span>
                <span class="value">#{{ $transaction->id }}</span>
            </div>
        </div>

        <p>Vous pouvez consulter le détail de cette transaction dans votre historique de virements.</p>

        <p>Si vous avez des questions concernant cette transaction, n'hésitez pas à contacter notre service client.</p>

        <p>Cordialement,<br>
        L'équipe BankPro</p>
    </div>

    <div class="footer">
        <p>Cet email a été envoyé automatiquement. Ne pas répondre à cet email.</p>
        <p>&copy; 2025 BankPro. Tous droits réservés.</p>
    </div>
</body>
</html>
