<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci pour votre message</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .bg-premium {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-premium-dark {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f0f;
            position: absolute;
            left: 50%;
            animation: confetti 5s ease-in-out -2s infinite;
        }
        
        @keyframes confetti {
            0% {
                transform: translateY(-100vh) rotateZ(0deg);
            }
            100% {
                transform: translateY(100vh) rotateZ(360deg);
            }
        }
        
        .confetti:nth-child(1) {
            left: 10%;
            animation-delay: 0;
            background-color: #f44336;
        }
        
        .confetti:nth-child(2) {
            left: 20%;
            animation-delay: -5s;
            background-color: #ff9800;
        }
        
        .confetti:nth-child(3) {
            left: 30%;
            animation-delay: -3s;
            background-color: #ffeb3b;
        }
        
        .confetti:nth-child(4) {
            left: 40%;
            animation-delay: -2.5s;
            background-color: #4caf50;
        }
        
        .confetti:nth-child(5) {
            left: 50%;
            animation-delay: -4s;
            background-color: #2196f3;
        }
        
        .confetti:nth-child(6) {
            left: 60%;
            animation-delay: -6s;
            background-color: #9c27b0;
        }
        
        .confetti:nth-child(7) {
            left: 70%;
            animation-delay: -1.5s;
            background-color: #00bcd4;
        }
        
        .confetti:nth-child(8) {
            left: 80%;
            animation-delay: -7s;
            background-color: #8bc34a;
        }
        
        .confetti:nth-child(9) {
            left: 90%;
            animation-delay: -2s;
            background-color: #ff5722;
        }
        
        .confetti:nth-child(10) {
            left: 95%;
            animation-delay: -4.5s;
            background-color: #607d8b;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-24 px-6">
    <!-- Confettis animés -->
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    
    <div id="thankyou-card" class="max-w-xl w-full bg-white shadow-2xl rounded-2xl p-10 opacity-0 translate-y-5 transition-all duration-700 transform">
        
        <!-- Icône animée -->
        <div class="flex justify-center mb-8">
            <div class="relative">
                <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-75"></div>
                <div class="relative bg-green-100 text-green-600 p-5 rounded-full shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2l4 -4m6 2c0 5.523 -4.477 10 -10 10S1 17.523 1 12S5.477 2 11 2s10 4.477 10 10z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Titre -->
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">
            Merci pour votre message !
        </h1>

        <!-- Texte -->
        <p class="text-lg text-gray-600 text-center leading-relaxed mb-10">
            Nous avons bien reçu votre demande et nous vous répondrons dans les plus brefs délais. Notre équipe travaille déjà sur votre requête.
        </p>
        
        <!-- Informations supplémentaires -->
        <div class="bg-blue-50 rounded-xl p-5 mb-10 border-l-4 border-blue-500">
            <div class="flex items-start">
                <div class="flex-shrink-0 text-blue-500 mt-1 mr-3">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <p class="text-blue-800 font-medium mb-1">À quoi s'attendre ensuite ?</p>
                    <p class="text-blue-700 text-sm">Vous recevrez une réponse par email dans les 24 à 48 heures. En cas d'urgence, n'hésitez pas à nous appeler directement.</p>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('support.nous-contacter') }}"
               class="inline-flex items-center justify-center bg-premium hover:bg-premium-dark text-white font-semibold px-8 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour au formulaire
            </a>
            <a href="/"
               class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold px-8 py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-home mr-2"></i>
                Page d'accueil
            </a>
        </div>
        
        <!-- Réseaux sociaux -->
        <div class="mt-10 pt-8 border-t border-gray-200 text-center">
            <p class="text-gray-600 mb-4">Suivez-nous sur les réseaux sociaux</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="text-gray-500 hover:text-blue-500 transition-colors duration-300">
                    <i class="fab fa-facebook-f text-xl"></i>
                </a>
                <a href="#" class="text-gray-500 hover:text-pink-500 transition-colors duration-300">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <a href="#" class="text-gray-500 hover:text-blue-400 transition-colors duration-300">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
                <a href="#" class="text-gray-500 hover:text-blue-700 transition-colors duration-300">
                    <i class="fab fa-linkedin-in text-xl"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Animation d'apparition du bloc
        document.addEventListener("DOMContentLoaded", () => {
            const card = document.getElementById("thankyou-card");
            setTimeout(() => {
                card.classList.remove("opacity-0", "translate-y-5");
            }, 150);
            
            // Animation du titre
            setTimeout(() => {
                const title = document.querySelector('h1');
                title.classList.add('animate-pulse');
                setTimeout(() => {
                    title.classList.remove('animate-pulse');
                }, 1000);
            }, 800);
        });
    </script>
</body>
</html>

