<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de contact - SG BANK</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8fafc;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .logo-subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }
        
        .intro {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        .details-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #667eea;
        }
        
        .details-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .details-list {
            list-style: none;
        }
        
        .details-list li {
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
        }
        
        .details-list li:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #475569;
            min-width: 120px;
        }
        
        .detail-value {
            color: #1e293b;
            flex: 1;
        }
        
        .message-preview {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
            font-style: italic;
            color: #475569;
            border-left: 3px solid #cbd5e1;
        }
        
        .assurance {
            background: #dbeafe;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
        }
        
        .assurance-icon {
            font-size: 24px;
            margin-bottom: 15px;
            color: #3b82f6;
        }
        
        .assurance-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 10px;
        }
        
        .assurance-text {
            color: #374151;
            font-size: 15px;
        }
        
        .next-steps {
            margin: 30px 0;
        }
        
        .steps-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
        }
        
        .steps-list {
            list-style: none;
            counter-reset: step-counter;
        }
        
        .steps-list li {
            counter-increment: step-counter;
            padding: 15px 0 15px 50px;
            position: relative;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .steps-list li:before {
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 15px;
            width: 32px;
            height: 32px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
        
        .footer {
            background: #1e293b;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }
        
        .footer-link {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .social-icon:hover {
            background: #475569;
        }
        
        .copyright {
            font-size: 14px;
            color: #94a3b8;
            margin-top: 20px;
        }
        
        .highlight {
            color: #667eea;
            font-weight: 600;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .details-list li {
                flex-direction: column;
                gap: 5px;
            }
            
            .detail-label {
                min-width: auto;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- En-tête -->
        <div class="header">
            <div class="logo">SG BANK</div>
            <div class="logo-subtitle">Votre partenaire financier de confiance</div>
        </div>
        
        <!-- Contenu principal -->
        <div class="content">
            <h1 class="greeting">Bonjour {{ $contact->first_name }},</h1>
            
            <p class="intro">
                Nous avons bien reçu votre message et vous en remercions. Votre demande a été transmise à notre équipe qui en prendra connaissance dans les plus brefs délais.
            </p>
            
            <!-- Carte des détails -->
            <div class="details-card">
                <h2 class="details-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Récapitulatif de votre demande
                </h2>
                
                <ul class="details-list">
                    <li>
                        <span class="detail-label">Nom complet :</span>
                        <span class="detail-value">{{ $contact->first_name }} {{ $contact->last_name }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Email :</span>
                        <span class="detail-value">{{ $contact->email }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Téléphone :</span>
                        <span class="detail-value">{{ $contact->phone ?? 'Non fourni' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Sujet :</span>
                        <span class="detail-value">{{ $contact->subject }}</span>
                    </li>
                </ul>
                
                <div class="message-preview">
                    <strong>Votre message :</strong><br>
                    {{ $contact->message }}
                </div>
            </div>
            
            <!-- Section d'assurance -->
            <div class="assurance">
                <div class="assurance-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 12L11 14L15 10M12 3L4 9V21L12 17L20 21V9L12 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="assurance-title">Votre demande est entre de bonnes mains</h3>
                <p class="assurance-text">
                    Notre équipe d'experts traite votre demande avec la plus grande attention. Nous nous engageons à vous répondre dans les <span class="highlight">24 à 48 heures</span>.
                </p>
            </div>
            
            <!-- Étapes suivantes -->
            <div class="next-steps">
                <h3 class="steps-title">Prochaines étapes</h3>
                <ol class="steps-list">
                    <li>Notre équipe analyse votre demande pour vous apporter la réponse la plus adaptée</li>
                    <li>Vous recevrez une réponse personnalisée par email</li>
                    <li>Si nécessaire, nous organiserons un appel pour discuter de vos besoins en détail</li>
                </ol>
            </div>
            
            <p style="color: #64748b; margin-top: 30px;">
                Cordialement,<br>
                <strong>L'équipe SG BANK</strong>
            </p>
        </div>
        
        <!-- Pied de page -->
        <div class="footer">
            <div class="social-links">
                <a href="#" class="social-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 2H15C13.6739 2 12.4021 2.52678 11.4645 3.46447C10.5268 4.40215 10 5.67392 10 7V10H7V14H10V22H14V14H17L18 10H14V7C14 6.73478 14.1054 6.48043 14.2929 6.29289C14.4804 6.10536 14.7348 6 15 6H18V2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="#" class="social-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23 3C22.0424 3.67548 20.9821 4.19211 19.86 4.53C19.2577 3.83751 18.4573 3.34669 17.567 3.12393C16.6767 2.90116 15.7395 2.9572 14.8821 3.28445C14.0247 3.61171 13.2884 4.1944 12.773 4.95372C12.2575 5.71303 11.9877 6.61234 12 7.53V8.53C10.2426 8.57557 8.50127 8.18581 6.93101 7.39545C5.36074 6.60508 4.01032 5.43864 3 4C3 4 -1 13 8 17C5.94053 18.398 3.48716 19.0989 1 19C10 24 21 19 21 7.5C20.9991 7.22145 20.9723 6.94359 20.92 6.67C21.9406 5.66349 22.6608 4.39271 23 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="#" class="social-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 8C17.5913 8 19.1174 8.63214 20.2426 9.75736C21.3679 10.8826 22 12.4087 22 14V21H18V14C18 13.4696 17.7893 12.9609 17.4142 12.5858C17.0391 12.2107 16.5304 12 16 12C15.4696 12 14.9609 12.2107 14.5858 12.5858C14.2107 12.9609 14 13.4696 14 14V21H10V14C10 12.4087 10.6321 10.8826 11.7574 9.75736C12.8826 8.63214 14.4087 8 16 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 9H2V21H6V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 6C5.10457 6 6 5.10457 6 4C6 2.89543 5.10457 2 4 2C2.89543 2 2 2.89543 2 4C2 5.10457 2.89543 6 4 6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            
            <div class="footer-links">
                <a href="#" class="footer-link">Notre site web</a>
                <a href="#" class="footer-link">Contactez-nous</a>
                <a href="#" class="footer-link">Politique de confidentialité</a>
            </div>
            
            <p class="copyright">
                © 2023 SG BANK. Tous droits réservés.<br>
                Cet email a été envoyé à {{ $contact->email }}
            </p>
        </div>
    </div>
</body>
</html>

