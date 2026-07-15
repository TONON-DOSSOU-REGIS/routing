<?php
$data = require __DIR__ . '/../fr/public_pages.php';
$data['shared'] = [
    'nav_home'=>'Inicio','nav_services'=>'Servicios','nav_about'=>'Nosotros','nav_support'=>'Soporte','client_area'=>'Área cliente','open_account'=>'Abrir cuenta',
    'first_name'=>'Nombre','last_name'=>'Apellido','email'=>'Correo electrónico','phone'=>'Teléfono','subject'=>'Asunto','choose_subject'=>'Elegir un asunto',
    'subject_support'=>'Soporte al cliente','subject_commercial'=>'Apertura de cuenta','subject_partnership'=>'Colaboración','subject_press'=>'Prensa','subject_other'=>'Otra solicitud',
    'message'=>'Mensaje','message_placeholder'=>'Explíquenos su necesidad. Responderemos con información clara y útil.',
    'privacy_notice'=>'Acepto que Zuider Bank S.A use esta información para responder a mi solicitud.','send_request'=>'Enviar mi solicitud','rights'=>'Todos los derechos reservados.',
];
$t = [
    'services_business'=>['Cuenta profesional','Una cuenta profesional para decidir rápido, pagar con claridad y mantener el control.','Un espacio bancario claro y seguro para operaciones diarias y decisiones sensibles.','Crear mi cuenta profesional','Una base bancaria sólida para su actividad.','Construya su base bancaria profesional.'],
    'services_international'=>['Pagos internacionales','Transferencias internacionales seguidas, documentadas y comprensibles.','Sus transferencias conservan un rastro claro antes, durante y después del proceso.','Preparar una transferencia','Cada transferencia conserva un registro claro.','Envíe transferencias internacionales con más visibilidad.'],
    'services_treasury'=>['Gestión de tesorería','Una tesorería que se lee rápido y se gestiona con calma.','Saldo, historial, documentos y alertas son más fáciles de utilizar.','Gestionar mi tesorería','La claridad financiera se convierte en ventaja.','Convierta su cuenta en una herramienta de control.'],
    'services_cards'=>['Tarjetas de pago','Tarjetas modernas para pagar, seguir y justificar.','Una tarjeta bancaria seria conectada a una experiencia clara y segura.','Solicitar mi tarjeta','Una tarjeta solo es útil si sigue siendo controlable.','Dé a sus pagos una tarjeta a la altura.'],
    'about_story'=>['Nuestra historia','Un banco creado para devolver claridad a la finanza digital.','Zuider Bank S.A moderniza la banca sin perder seriedad.','Abrir mi espacio','Confianza, claridad y seguridad.','Descubra un banco que avanza con método.'],
    'about_careers'=>['Carreras','Construya un banco más claro, seguro y humano.','Buscamos perfiles que valoren productos bien hechos y decisiones responsables.','Enviar mi candidatura','Un equipo que prefiere precisión al ruido.','¿Quiere construir un banco más claro?'],
    'about_press'=>['Prensa y medios','Recursos de prensa para entender la evolución de Zuider Bank S.A.','Encuentre nuestro posicionamiento, temas clave e información oficial.','Contactar prensa','Un banco digital que asume su seriedad.','¿Necesita información de prensa fiable?'],
    'about_blog'=>['Blog bancario','Artículos para entender mejor la banca online.','Guías sobre seguridad, transferencias, recibos, tarjetas y tesorería.','Abrir mi cuenta','Lectura útil para decidir mejor.','Pase de la lectura a la acción.'],
    'support_help'=>['Centro de ayuda','Un centro de ayuda para encontrar respuestas, no perderse.','Respuestas esenciales sobre cuenta, seguridad, transferencias y recibos.','Contactar soporte','Respuestas breves, útiles y orientadas a la acción.','¿Necesita una respuesta personalizada?'],
    'support_contact'=>['Contacto','Una pregunta bancaria merece una respuesta clara.','Explique su solicitud de soporte, cuenta, colaboración, prensa o administración.','Escribir al soporte','Un formulario diseñado para acelerar el tratamiento.','¿Su solicitud está lista?'],
    'support_security'=>['Seguridad bancaria','La seguridad debe verse en cada etapa.','Zuider Bank S.A protege accesos, operaciones sensibles y pruebas verificables.','Abrir una cuenta segura','Seguridad pensada para el uso real.','Proteja sus operaciones con pruebas visibles.'],
    'support_legal'=>['Aviso legal','Un marco legal legible para usar Zuider Bank S.A con confianza.','Información esencial sobre editor, uso, datos y responsabilidades.','Contactar Zuider Bank S.A','El cumplimiento empieza con información comprensible.','¿Pregunta sobre el marco legal?'],
];
foreach ($t as $key => $v) { $data['pages'][$key]['eyebrow']=$v[0]; $data['pages'][$key]['title']=$v[1]; $data['pages'][$key]['subtitle']=$v[2]; $data['pages'][$key]['primary_cta']=$v[3]; $data['pages'][$key]['hero_card_title']=$v[4]; $data['pages'][$key]['cta_title']=$v[5]; }
$localizePublicPages = require __DIR__ . '/../public_pages_localizer.php';
return $localizePublicPages($data, 'es');
