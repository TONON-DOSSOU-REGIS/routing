<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('mail_body.account_validated_title') }}</title>
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
        .features {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .feature-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .feature-item:last-child {
            border-bottom: none;
        }
        .feature-icon {
            color: #10b981;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('mail_body.account_validated_heading') }}</h1>
        <p>{{ __('mail_body.welcome_bank') }}</p>
    </div>
    
    <div class="content">
        <div class="success-icon">
            🎉
        </div>
        
        <p>Bonjour <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
        
        <p>{{ __('mail_body.account_validated_text') }}</p>
        
        <div class="info-box">
            <h3 style="margin-top: 0; color: #10b981;">{{ __('mail_body.account_active') }}</h3>
            <p style="margin-bottom: 0;">{{ __('mail_body.account_access_ready') }}</p>
        </div>
        
        <div class="features">
            <h3 style="margin-top: 0; color: #333;">📋 Services disponibles :</h3>
            
            <div class="feature-item">
                <span class="feature-icon">💳</span>
                <strong>{{ __('mail_body.account_management_feature') }}</strong> - {{ __('mail_body.account_management_text') }}
            </div>
            
            <div class="feature-item">
                <span class="feature-icon">💸</span>
                <strong>{{ __('mail_body.transfers_feature') }}</strong> - {{ __('mail_body.transfers_feature_text') }}
            </div>
            
            <div class="feature-item">
                <span class="feature-icon">📊</span>
                <strong>{{ __('mail_body.history_feature') }}</strong> - {{ __('mail_body.history_text') }}
            </div>
            
            <div class="feature-item">
                <span class="feature-icon">🔒</span>
                <strong>{{ __('mail_body.security_feature') }}</strong> - {{ __('mail_body.security_feature_text') }}
            </div>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" class="button">
                Se connecter maintenant
            </a>
        </div>
        
        <div style="background: #e0f2fe; border: 1px solid #0ea5e9; color: #0c4a6e; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <strong>{{ __('mail_body.tip') }}</strong> {{ __('mail_body.login_tip_text', ['email' => $user->email]) }}
        </div>
        
        <p style="margin-top: 30px; color: #666; font-size: 14px;">
            {{ __('mail_body.support_questions') }}
        </p>
    </div>
    
    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p>© {{ date('Y') }} Zuider Bank S.A. {{ __('admin_dashboard.footer_rights') }}</p>
    </div>
</body>
</html>

