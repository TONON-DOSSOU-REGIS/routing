<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Transaction - BankPro</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
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
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .transaction-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .value {
            color: #212529;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #d4edda;
            border-radius: 8px;
            border: 2px solid #c3e6cb;
        }
        .status {
            text-align: center;
            margin: 20px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status-success {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-on_hold {
            background: #f8d7da;
            color: #721c24;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            font-size: 12px;
            color: #6c757d;
        }
        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #856404;
        }
        .bank-details {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .transaction-id {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>BankPro</h1>
            <p>Système Bancaire Sécurisé</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Transaction ID -->
            <div class="transaction-id">
                Transaction #{{ $transaction->id }}
            </div>

            <!-- Transaction Amount -->
            <div class="amount">
                {{ number_format($transaction->amount, 2) }} €
            </div>

            <!-- Status -->
            <div class="status">
                <span class="status-badge
                    @if($transaction->status == 'success') status-success
                    @elseif($transaction->status == 'pending') status-pending
                    @else status-on_hold @endif">
                    @if($transaction->status == 'success')
                        Transaction Réussie
                    @elseif($transaction->status == 'pending')
                        En Cours de Traitement
                    @else
                        Transaction Suspendue
                    @endif
                </span>
            </div>

            <!-- Transaction Details -->
            <div class="transaction-info">
                <h3 style="margin-top: 0; color: #495057; border-bottom: 2px solid #007bff; padding-bottom: 10px;">
                    Détails de la Transaction
                </h3>

                <div class="info-row">
                    <span class="label">Type de Transaction:</span>
                    <span class="value">{{ ucfirst($transaction->type) }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Date et Heure:</span>
                    <span class="value">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</span>
                </div>

                @if($transaction->recipient_name)
                <div class="info-row">
                    <span class="label">Bénéficiaire:</span>
                    <span class="value">{{ $transaction->recipient_name }}</span>
                </div>
                @endif

                @if($transaction->recipient_iban)
                <div class="info-row">
                    <span class="label">IBAN Bénéficiaire:</span>
                    <span class="value">{{ $transaction->recipient_iban }}</span>
                </div>
                @endif

                @if($transaction->recipient_bic)
                <div class="info-row">
                    <span class="label">BIC Bénéficiaire:</span>
                    <span class="value">{{ $transaction->recipient_bic }}</span>
                </div>
                @endif

                @if($transaction->bank_name)
                <div class="info-row">
                    <span class="label">Banque Bénéficiaire:</span>
                    <span class="value">{{ $transaction->bank_name }}</span>
                </div>
                @endif

                @if($transaction->reason)
                <div class="info-row">
                    <span class="label">Motif:</span>
                    <span class="value">{{ $transaction->reason }}</span>
                </div>
                @endif

                @if($transaction->activation_code)
                <div class="info-row">
                    <span class="label">Code d'Activation:</span>
                    <span class="value">****</span>
                </div>
                @endif

                <div class="info-row">
                    <span class="label">Progression:</span>
                    <span class="value">{{ $transaction->progress }}%</span>
                </div>
            </div>

            <!-- User Information -->
            <div class="bank-details">
                <h4 style="margin-top: 0; color: #495057;">Informations Client</h4>
                <div class="info-row" style="border: none; margin-bottom: 5px;">
                    <span class="label">Nom:</span>
                    <span class="value">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</span>
                </div>
                <div class="info-row" style="border: none; margin-bottom: 5px;">
                    <span class="label">Email:</span>
                    <span class="value">{{ $transaction->user->email }}</span>
                </div>
                @if($transaction->user->phone)
                <div class="info-row" style="border: none; margin-bottom: 0;">
                    <span class="label">Téléphone:</span>
                    <span class="value">{{ $transaction->user->phone }}</span>
                </div>
                @endif
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <strong>⚠️ Avis de Sécurité:</strong> Ce reçu est généré électroniquement et constitue une preuve officielle de votre transaction.
                Conservez-le en lieu sûr. En cas de contestation, contactez immédiatement le service client de BankPro.
            </div>

            @if($transaction->status == 'on_hold' && $transaction->message)
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; padding: 15px; margin: 20px 0; color: #721c24;">
                <strong>Message de l'Administrateur:</strong><br>
                {{ $transaction->message }}
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>BankPro - Système Bancaire Sécurisé</strong></p>
            <p>Ce document a été généré automatiquement le {{ now()->format('d/m/Y à H:i:s') }}</p>
            <p>Pour toute question, contactez notre service client</p>
        </div>
    </div>
</body>
</html>
