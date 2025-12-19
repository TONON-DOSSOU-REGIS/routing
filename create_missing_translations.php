<?php

// Script pour créer tous les fichiers de traduction manquants
// Langues à créer: ES, PL, IT

$translations = [
    'es' => [
        'home' => [
            // Hero Section
            'hero_badge' => 'Plataforma bancaria 100% segura',
            'hero_title_1' => 'Su banco en línea',
            'hero_title_2' => 'profesional y certificado',
            'hero_description' => 'Abra su cuenta en minutos, siga sus transferencias en tiempo real y reciba comprobantes oficiales certificados por SG BANK.',
            'hero_feature_1' => 'Registro 100% en línea, sin necesidad de viajar.',
            'hero_feature_2' => 'Seguimiento paso a paso de transferencias con barra de progreso.',
            'hero_feature_3' => 'Notificaciones por correo electrónico para cada transacción.',
            'hero_feature_4' => 'Comprobantes PDF seguros archivados en su área de cliente.',
            'hero_cta_register' => 'Crear mi cuenta',
            'hero_cta_login' => 'Acceder a mi espacio',
            'hero_security_note' => 'SG BANK cumple con los estándares de seguridad más estrictos para proteger sus datos financieros.',
            
            // Dashboard Preview
            'dashboard_preview_title' => 'Vista previa de su panel',
            'dashboard_transfers_in_progress' => 'Transferencias en curso',
            'dashboard_operations' => 'operaciones',
            'dashboard_priority_transfer' => 'Progreso de transferencia prioritaria',
            'dashboard_step' => 'Paso 3/4 - Verificación final de cumplimiento',
            'dashboard_transfers' => 'Transferencias',
            'dashboard_reception' => 'Recepción',
            'dashboard_alerts' => 'Alertas',
            'dashboard_description' => 'Interfaz moderna y clara diseñada para transferencias profesionales.',
            
            // Navigation
            'nav_home' => 'Inicio',
            'nav_services' => 'Servicios',
            'nav_testimonials' => 'Testimonios de clientes',
            'nav_faq' => 'FAQ',
            'nav_contact' => 'Formulario de contacto',
            'nav_login' => 'Iniciar sesión',
            'nav_register' => 'Crear cuenta',
            
            // Services Menu
            'services_business_accounts' => 'Cuentas empresariales',
            'services_international_transfers' => 'Transferencias internacionales',
            'services_treasury_management' => 'Gestión de tesorería',
            'services_payment_cards' => 'Tarjetas de pago',
            
            // Features Section
            'features_title' => 'Funciones potentes diseñadas para profesionales',
            'features_description' => 'SG BANK le ofrece una experiencia bancaria moderna: seguridad avanzada, transparencia total y gestión inteligente de sus operaciones.',
            
            'feature_1_title' => 'Seguridad bancaria AES de 256 bits',
            'feature_1_description' => 'Sus datos están cifrados de extremo a extremo y protegidos por los mismos protocolos que las grandes instituciones bancarias.',
            'feature_1_item_1' => 'Conexión segura (HTTPS / SSL)',
            'feature_1_item_2' => 'Detección de conexiones sospechosas',
            'feature_1_item_3' => 'Archivo seguro y protegido',
            
            'feature_2_title' => 'Monitoreo antifraude en tiempo real',
            'feature_2_description' => 'Un sistema inteligente analiza continuamente sus operaciones para detectar cualquier actividad anormal.',
            'feature_2_item_1' => 'Alertas por correo electrónico en tiempo real',
            'feature_2_item_2' => 'Análisis automático de anomalías',
            'feature_2_item_3' => 'Control manual posible por el administrador',
            
            'feature_3_title' => 'Progreso de transferencia supervisado',
            'feature_3_description' => 'Cada transferencia pasa por un proceso de validación certificado para garantizar seguridad y transparencia.',
            'feature_3_item_1' => 'Seguimiento paso a paso',
            'feature_3_item_2' => 'Barra de progreso dinámica',
            'feature_3_item_3' => 'Comprobante PDF certificado',
            
            // Why Choose Section
            'why_choose_title' => '¿Por qué elegir SG BANK?',
            'why_choose_description' => 'SG BANK apoya tanto a particulares como a profesionales con una solución bancaria moderna, accesible, rápida y extremadamente confiable.',
            
            'advantage_1_title' => 'Sin necesidad de viajar',
            'advantage_1_description' => 'Abra y gestione sus cuentas desde su computadora, smartphone o tablet, donde quiera que esté.',
            
            'advantage_2_title' => 'Aprobación rápida',
            'advantage_2_description' => 'Proceso de validación acelerado para sus transferencias y solicitudes importantes.',
            
            'advantage_3_title' => 'Transferencias + comprobante PDF',
            'advantage_3_description' => 'Reciba un comprobante PDF certificado después de cada transferencia exitosa.',
            
            'advantage_4_title' => 'Soporte al cliente humano',
            'advantage_4_description' => 'Un equipo disponible para ayudarle, asesorarle y responder a sus preguntas.',
            
            // Stats Section
            'stats_clients' => 'Clientes satisfechos',
            'stats_clients_description' => 'Miles de usuarios confían en SG BANK para sus operaciones diarias.',
            'stats_volume' => 'Volumen de transacciones (M€)',
            'stats_volume_description' => 'Un volumen significativo de flujos financieros gestionados con precisión y transparencia.',
            'stats_satisfaction' => 'Tasa de satisfacción',
            'stats_satisfaction_description' => 'Nuestros usuarios recomiendan SG BANK por su simplicidad, velocidad y confiabilidad.',
            
            // Partners Section
            'partners_title' => 'Confían en nosotros',
            'partners_description' => 'SG BANK colabora con instituciones financieras reconocidas mundialmente para garantizar confiabilidad, seguridad y calidad de servicio.',
            'partners_note' => 'Los logotipos mostrados se presentan con fines ilustrativos para una demostración visual.',
            
            // Certifications Section
            'certifications_title' => 'Certificado por los mejores estándares',
            'certifications_description' => 'SG BANK aplica los estándares más estrictos del sector bancario para garantizar operaciones confiables, transparentes y seguras.',
            
            'cert_1_badge' => 'Certificación de seguridad',
            'cert_1_title' => 'Estándares de seguridad mejorados',
            'cert_1_description' => 'Conforme con los estándares internacionales de ciberseguridad, garantizando cifrado de grado bancario.',
            
            'cert_2_badge' => 'Calidad de servicio',
            'cert_2_title' => 'Excelencia y transparencia',
            'cert_2_description' => 'Seguimiento detallado, tarifas claramente mostradas y una interfaz diseñada para usuarios.',
            'cert_2_distinction' => 'Premio al servicio premium',
            
            'cert_3_badge' => 'Protección de datos',
            'cert_3_title' => 'Confidencialidad garantizada',
            'cert_3_description' => 'Gestión estricta de accesos sensibles y cumplimiento inspirado en las directivas RGPD.',
            'cert_3_compliance' => 'Cumplimiento y seguridad de datos',
            
            // Testimonials Section
            'testimonials_title' => 'Lo que dicen nuestros clientes',
            'testimonials_description' => 'Usuarios reales, experiencias reales. SG BANK simplifica la gestión diaria de transferencias.',
            
            'testimonial_1_name' => 'Sarah M.',
            'testimonial_1_role' => 'Empresaria - E-commerce',
            'testimonial_1_text' => 'SG BANK me permitió seguir mis transferencias a proveedores en tiempo real. La barra de progreso y los comprobantes PDF son realmente tranquilizadores.',
            'testimonial_1_rating' => 'Servicio impecable',
            
            'testimonial_2_name' => 'Jean-Paul D.',
            'testimonial_2_role' => 'Consultor financiero',
            'testimonial_2_text' => 'Aprecio especialmente el monitoreo antifraude y las alertas por correo electrónico. Sé inmediatamente cuando una transferencia importante está en curso o finalizada.',
            'testimonial_2_rating' => 'Muy confiable',
            
            'testimonial_3_name' => 'Karim L.',
            'testimonial_3_role' => 'Freelancer - Servicio B2B',
            'testimonial_3_text' => 'La interfaz es clara y muy simple. Puedo mostrar directamente a mis clientes pruebas de transferencia con comprobantes PDF.',
            'testimonial_3_rating' => 'Práctico y moderno',
            
            // FAQ Section
            'faq_title' => 'Preguntas frecuentes (FAQ)',
            'faq_description' => 'Encuentre respuestas a las preguntas más comunes sobre SG BANK, apertura de cuenta y gestión de sus transferencias en línea.',
            
            'faq_1_question' => '¿Cómo abrir una cuenta en SG BANK?',
            'faq_1_subtitle' => 'Registro simple en pocos pasos.',
            'faq_1_answer' => 'Haga clic en "Crear cuenta", complete el formulario con su información (nombre, correo electrónico, teléfono, etc.), confirme su dirección de correo electrónico y luego acceda a su espacio seguro para realizar sus primeras operaciones.',
            
            'faq_2_question' => '¿Mis transferencias están realmente monitoreadas?',
            'faq_2_subtitle' => 'Seguimiento y control manual de operaciones.',
            'faq_2_answer' => 'Sí. Cada transferencia pasa por varios pasos de validación. Los administradores de SG BANK pueden controlar y certificar operaciones sensibles, lo que reduce en gran medida el riesgo de error o fraude.',
            
            'faq_3_question' => '¿Puedo descargar un comprobante para cada transferencia?',
            'faq_3_subtitle' => 'Comprobante PDF disponible.',
            'faq_3_answer' => 'Por supuesto. Una vez que la transferencia está finalizada y certificada, se genera automáticamente un comprobante PDF. Puede descargarlo, imprimirlo o compartirlo con sus socios.',
            
            'faq_4_question' => '¿Qué hacer en caso de problema o duda?',
            'faq_4_subtitle' => 'Soporte humano disponible.',
            'faq_4_answer' => 'Puede contactar a nuestro soporte al cliente a través de su espacio seguro o mediante los datos de contacto indicados en el sitio. Un asesor le responderá lo antes posible.',
            
            // CTA Section
            'cta_title' => '¿Listo para comenzar?',
            'cta_description' => 'Únase a miles de clientes satisfechos que confían en SG BANK para sus transferencias y operaciones bancarias en línea.',
            'cta_button' => 'Comenzar ahora',
            'cta_security' => 'La apertura de cuenta se realiza en pocos minutos, sin viajar y con un alto nivel de seguridad.',
            
            // Footer
            'footer_description' => 'Una solución bancaria 100% segura, simple y rápida para profesionales.',
            'footer_services' => 'Servicios',
            'footer_about' => 'Acerca de',
            'footer_support' => 'Soporte',
            'footer_our_story' => 'Nuestra historia',
            'footer_careers' => 'Carreras',
            'footer_press' => 'Prensa',
            'footer_blog' => 'Blog',
            'footer_help_center' => 'Centro de ayuda',
            'footer_contact_us' => 'Contáctenos',
            'footer_security' => 'Seguridad',
            'footer_legal' => 'Avisos legales',
            'footer_copyright' => 'Todos los derechos reservados.',
            'footer_disclaimer' => 'La información mostrada en este sitio es indicativa y puede adaptarse según su proyecto real.',
        ],
        'common' => [
            // Actions
            'save' => 'Guardar',
            'cancel' => 'Cancelar',
            'delete' => 'Eliminar',
            'edit' => 'Editar',
            'create' => 'Crear',
            'update' => 'Actualizar',
            'submit' => 'Enviar',
            'search' => 'Buscar',
            'filter' => 'Filtrar',
            'export' => 'Exportar',
            'import' => 'Importar',
            'download' => 'Descargar',
            'upload' => 'Subir',
            'view' => 'Ver',
            'back' => 'Atrás',
            'next' => 'Siguiente',
            'previous' => 'Anterior',
            'close' => 'Cerrar',
            'confirm' => 'Confirmar',
            'send' => 'Enviar',
            'refresh' => 'Actualizar',
            'reset' => 'Restablecer',
            'clear' => 'Limpiar',
            'apply' => 'Aplicar',
            
            // Status
            'status' => 'Estado',
            'active' => 'Activo',
            'inactive' => 'Inactivo',
            'pending' => 'Pendiente',
            'approved' => 'Aprobado',
            'rejected' => 'Rechazado',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
            'processing' => 'Procesando',
            'failed' => 'Fallido',
            'success' => 'Éxito',
            
            // Common words
            'yes' => 'Sí',
            'no' => 'No',
            'all' => 'Todos',
            'none' => 'Ninguno',
            'other' => 'Otro',
            'total' => 'Total',
            'amount' => 'Cantidad',
            'date' => 'Fecha',
            'time' => 'Hora',
            'description' => 'Descripción',
            'details' => 'Detalles',
            'actions' => 'Acciones',
            'options' => 'Opciones',
            'settings' => 'Configuración',
            'loading' => 'Cargando...',
            'no_data' => 'No hay datos disponibles',
            'error' => 'Error',
            'warning' => 'Advertencia',
            'info' => 'Información',
            'required' => 'Requerido',
            'optional' => 'Opcional',
            
            // Messages
            'success_message' => '¡Operación completada con éxito!',
            'error_message' => 'Se produjo un error. Por favor, inténtelo de nuevo.',
            'confirm_delete' => '¿Está seguro de que desea eliminar este elemento?',
            'no_results' => 'No se encontraron resultados.',
            'please_wait' => 'Por favor espere...',
            'language_changed' => '¡Idioma cambiado con éxito!',
            
            // Time
            'today' => 'Hoy',
            'yesterday' => 'Ayer',
            'tomorrow' => 'Mañana',
            'this_week' => 'Esta semana',
            'this_month' => 'Este mes',
            'this_year' => 'Este año',
            
            // Currency
            'currency' => 'Moneda',
            'eur' => 'Euro (EUR)',
            'usd' => 'Dólar estadounidense (USD)',
            'gbp' => 'Libra esterlina (GBP)',
            'chf' => 'Franco suizo (CHF)',
        ]
    ]
];

// Créer les fichiers
foreach ($translations as $lang => $files) {
    foreach ($files as $filename => $content) {
        $dir = __DIR__ . "/lang/{$lang}";
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $filepath = "{$dir}/{$filename}.php";
        $phpContent = "<?php\n\nreturn " . var_export($content, true) . ";\n";
        file_put_contents($filepath, $phpContent);
        echo "Created: {$filepath}\n";
    }
}

echo "\nDone! All translation files created successfully.\n";
