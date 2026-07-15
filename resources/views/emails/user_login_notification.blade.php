<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification de Connexion - Zuider Bank S.A</title>
    @include('partials.favicon')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .alert h3 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 18px;
        }
        .user-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
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
        .security-notice {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
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
        .action-button {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .action-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🔔 Notification de Connexion</h1>
            <p>{{ __('mail_body.monitoring_system') }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert">
                <h3>{{ __('mail_body.security_alert') }}</h3>
                <p>{{ __('mail_body.client_login_text') }}</p>
            </div>

            <!-- User Information -->
            <div class="user-info">
                <h3 style="margin-top: 0; color: #495057;">Informations du Client</h3>

                <div class="info-row">
                    <span class="label">{{ __('mail_body.full_name') }}:</span>
                    <span class="value">{{ $user->first_name }} {{ $user->last_name }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Adresse email:</span>
                    <span class="value">{{ $user->email }}</span>
                </div>

                @if($user->phone)
                <div class="info-row">
                    <span class="label">{{ __('mail_body.phone') }}:</span>
                    <span class="value">{{ $user->phone }}</span>
                </div>
                @endif

                <div class="info-row">
                    <span class="label">{{ __('mail_body.registration_date') }}</span>
                    <span class="value">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>

            <!-- Login Details -->
            <div class="user-info">
                <h3 style="margin-top: 0; color: #495057;">{{ __('mail_body.login_details') }}</h3>

                <div class="info-row">
                    <span class="label">Date et heure:</span>
                    <span class="value">{{ $loginTime->format('d/m/Y H:i:s') }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Adresse IP:</span>
                    <span class="value">{{ $ipAddress }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Navigateur/Appareil:</span>
                    <span class="value">{{ $userAgent }}</span>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <strong>{{ __('mail_body.security_notice') }}</strong><br>
                {{ __('mail_body.login_notice_text') }}
            </div>

            <!-- Action Buttons -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ localized_route('admin.users') }}" class="action-button">
                    {{ __('mail_body.view_all_users') }}
                </a>
                <a href="{{ localized_route('admin.dashboard') }}" class="action-button">
                    {{ __('mail_body.go_dashboard') }}
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ __('mail_body.secure_banking_system') }}</strong></p>
            <p>{{ __('mail_body.generated_notification', ['date' => now()->format('d/m/Y H:i:s')]) }}</p>
            <p>{{ __('mail_body.automatic_notification_no_reply') }}</p>
        </div>
    </div>
</body>
</html>

