<?php

return [
    'api' => [
        'not_found' => 'Notificacion no encontrada.',
        'marked_read' => 'Notificacion marcada como leida.',
        'all_marked_read' => 'Todas las notificaciones fueron marcadas como leidas.',
        'all_read_deleted' => 'Todas las notificaciones leidas fueron eliminadas.',
    ],

    'transaction_types' => [
        'deposit' => 'deposito',
        'withdrawal' => 'retiro',
        'transfer' => 'transferencia',
        'credit' => 'credito',
        'debit' => 'debito',
        'operation' => 'operacion',
    ],

    'account_statuses' => [
        'pending' => 'pendiente',
        'active' => 'activo',
        'suspended' => 'suspendido',
        'blocked' => 'bloqueado',
    ],

    'transaction_statuses' => [
        'pending' => 'pendiente',
        'success' => 'exitosa',
        'failed' => 'fallida',
        'on_hold' => 'en espera',
        'refunded' => 'reembolsada',
        'processing' => 'en proceso',
        'cancelled' => 'cancelada',
    ],

    'titles' => [
        'transaction_new' => 'Nueva transaccion',
        'message_new' => 'Nuevo mensaje',
        'account_status_changed' => 'Cambio de estado de cuenta',
        'account_approved' => 'Cuenta aprobada',
        'security_alert' => 'Alerta de seguridad',
        'deposit_completed' => 'Deposito realizado',
        'transaction_refunded' => 'Transaccion reembolsada',
        'admin_user_login' => 'Conexion de usuario',
        'user_login_success' => 'Conexion exitosa',
        'admin_user_registration' => 'Nuevo registro',
        'admin_user_logout' => 'Desconexion de usuario',
        'admin_transfer_success' => 'Nueva transferencia',
        'admin_transfer_started' => 'Transferencia iniciada',
        'admin_transfer_failed' => 'Transferencia fallida',
        'admin_user_message' => 'Nuevo mensaje de usuario',
        'admin_transaction_activity' => 'Nueva operacion de cliente',
        'admin_deposit_completed' => 'Deposito realizado',
    ],

    'messages' => [
        'transaction_new' => 'Se realizo un :type de :amount en su cuenta.',
        'message_new' => 'Recibio un nuevo mensaje de soporte.',
        'account_status_changed' => "El estado de su cuenta cambio de ':old_status' a ':new_status'.",
        'account_approved' => 'Su cuenta fue aprobada y ahora esta activa.',
        'deposit_completed' => 'Un deposito de :amount fue acreditado en su cuenta.',
        'transaction_refunded' => 'La transaccion #:transaction_id por :amount fue reembolsada.',
        'admin_user_login' => 'El usuario :user_name (:user_email) inicio sesion desde :ip_address. Navegador: :user_agent.',
        'user_login_success' => 'Inicio de sesion correcto desde :ip_address.',
        'admin_user_registration' => 'Nuevo usuario registrado: :user_name (:user_email) desde :ip_address. Estado: :status.',
        'admin_user_logout' => 'El usuario :user_name (:user_email) cerro sesion desde :ip_address.',
        'admin_transfer_success' => ':user_name (:user_email) realizo una transferencia de :amount a :recipient_name.',
        'admin_transfer_started' => 'Nueva solicitud: :user_name (:user_email) inicio una transferencia de :amount a :recipient_name.',
        'admin_transfer_failed' => 'Transferencia fallida para :user_name (:user_email): :amount a :recipient_name.',
        'admin_transfer_failed_with_reason' => 'Transferencia fallida para :user_name (:user_email): :amount a :recipient_name. Motivo: :reason.',
        'admin_user_message' => 'Mensaje de :user_name (:user_email): :preview',
        'admin_transaction_activity' => ':user_name (:user_email) realizo un :type de :amount. Estado: :status.',
        'admin_deposit_completed' => 'Deposito admin: :amount acreditado en la cuenta de :user_name (:user_email).',
        'attachment_preview' => 'Adjunto: :name',
        'empty_message_preview' => '(sin texto)',
    ],
];
