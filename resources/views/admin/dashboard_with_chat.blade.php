<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - SG BANK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* ... The existing styles from the original admin dashboard ... */
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
        
        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateX(-20px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }
        
        .fade-in-up { 
            animation: fadeInUp 0.6s ease-out forwards; 
        }
        
        .slide-in { 
            animation: slideIn 0.5s ease-out forwards; 
        }
        
        .stagger-item {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .stagger-item:nth-child(1) { animation-delay: 0.1s; }
        .stagger-item:nth-child(2) { animation-delay: 0.2s; }
        .stagger-item:nth-child(3) { animation-delay: 0.3s; }
        .stagger-item:nth-child(4) { animation-delay: 0.4s; }
        .stagger-item:nth-child(5) { animation-delay: 0.5s; }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .gradient-card-1 { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        }
        
        .gradient-card-2 { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
        }
        
        .gradient-card-3 { 
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); 
        }
        
        .gradient-card-4 { 
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); 
        }
        
        .gradient-card-5 { 
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); 
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .action-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
            }
            50% { 
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.8);
            }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }
        /* Additional styles for chat widget to avoid collision */
        #chat-widget {
            z-index: 1050;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen">
        <!-- Existing admin dashboard content here -->
        {{-- Paste the full admin dashboard content here as in original file --}}

        <!-- Chat widget removed as per user request -->
        {{-- Chat widget inclusion removed --}}
    </div>

    <script>
        // Existing scripts of admin dashboard, e.g. mobile menu toggle and chart.js initialization
        // Paste existing scripts here as in original file

        // Additional chat widget JS is inside the component itself
    </script>
</body>
</html>


