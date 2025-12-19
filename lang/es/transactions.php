<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Líneas de Lenguaje de Transacciones
    |--------------------------------------------------------------------------
    */

    // Títulos de página
    'page_title' => 'Nueva transferencia - SG BANK',
    'new_transfer' => 'Nueva transferencia',

    // Navegación
    'dashboard' => 'Panel de control',
    'logout' => 'Cerrar sesión',

    // Encabezados
    'transfer_title' => 'Nueva transferencia',
    'transfer_subtitle' => 'Realice una transferencia segura hacia un beneficiario',

    // Indicadores de pasos
    'step_information' => 'Información',
    'step_processing' => 'Procesamiento',
    'step_confirmation' => 'Confirmación',

    // Secciones del formulario
    'transfer_details' => 'Detalles de la transferencia',
    'beneficiary_info' => 'Ingrese la información del beneficiario',
    'banking_details' => 'Datos bancarios',
    'additional_info' => 'Información adicional',

    // Etiquetas del formulario
    'amount' => 'Importe de la transferencia',
    'recipient_name' => 'Nombre del beneficiario',
    'bank_name' => 'Nombre del banco',
    'recipient_iban' => 'IBAN del beneficiario',
    'recipient_bic' => 'BIC del beneficiario',
    'reason' => 'Motivo de la transferencia (opcional)',
    'activation_code' => 'Código de activación',

    // Marcadores de posición
    'amount_placeholder' => '0.00',
    'recipient_name_placeholder' => 'Juan Pérez',
    'bank_name_placeholder' => 'Banco Nacional',
    'iban_placeholder' => 'ES91 2100 0418 4502 0005 1332',
    'bic_placeholder' => 'CAIXESBBXXX',
    'reason_placeholder' => 'Reembolso, regalo...',
    'activation_code_placeholder' => 'Su código de activación personal',

    // Botones
    'cancel' => 'Cancelar',
    'start_transfer' => 'Iniciar transferencia',
    'processing' => 'Procesando...',

    // Sección de progreso
    'processing_in_progress' => 'Procesamiento en curso',
    'transfer_progress' => 'Progreso de la transferencia',
    'processing_message' => 'Su transferencia está siendo procesada. Por favor espere...',

    // Mensajes flash
    'operation_interrupted' => 'Operación interrumpida',
    'operation_successful' => 'Operación exitosa',
    'transfer_successful' => 'Transferencia realizada con éxito. Será redirigido...',
    'understood' => 'Entendido',

    // Mensajes de error
    'amount_required' => 'El campo importe es obligatorio.',
    'recipient_name_required' => 'El campo nombre del beneficiario es obligatorio.',
    'bank_name_required' => 'El campo nombre del banco es obligatorio.',
    'iban_required' => 'El campo IBAN es obligatorio.',
    'bic_required' => 'El campo BIC es obligatorio.',
    'activation_code_required' => 'El campo código de activación es obligatorio.',
    'reason_required' => 'El campo motivo es obligatorio.',

    // Mensajes de validación
    'invalid_amount' => 'Por favor ingrese un importe válido.',
    'invalid_iban' => 'Por favor ingrese un IBAN válido.',
    'invalid_bic' => 'Por favor ingrese un BIC válido.',
    'invalid_activation_code' => 'Por favor ingrese un código de activación válido.',

    // Mensajes de estado
    'transfer_pending' => 'Transferencia pendiente de verificación de seguridad.',
    'connection_error' => 'Error de conexión durante el procesamiento.',

    // Claves adicionales del formulario
    'transfer_amount' => 'Importe de la Transferencia',
    'recipient_iban_placeholder' => 'ES91 2100 0418 4502 0005 1332',
    'recipient_bic_placeholder' => 'CAIXESBBXXX',
    'transfer_reason' => 'Motivo de la Transferencia',
    'transfer_reason_placeholder' => 'Reembolso, regalo...',
    'activation_code_placeholder' => 'Su código de activación personal',

    // Mensajes de JavaScript
    'error_starting_transfer' => 'Error al iniciar la transferencia.',
    'connection_error_processing' => 'Error de conexión durante el procesamiento.',
    'transaction_on_hold' => 'Transacción en espera.',
    'transfer_success_message' => '¡Transferencia completada exitosamente!',
    'operation_success' => 'Operación Exitosa',

    // Etiquetas de progreso
    'progress_label' => 'Progreso',

    // Página de historial
    'history_page_title' => 'Historial de transacciones - SG BANK',
    'history_title' => 'Historial de transacciones',
    'history_subtitle' => 'Consulte todas sus operaciones financieras',
    'history_overview' => 'Resumen de sus operaciones financieras',
    
    // Botones de exportación
    'export_pdf' => 'Exportar PDF',
    'export_excel' => 'Exportar Excel',
    
    // Filtros
    'filter_type' => 'Tipo',
    'filter_status' => 'Estado',
    'filter_date_from' => 'Fecha de inicio',
    'filter_date_to' => 'Fecha de fin',
    'filter_apply' => 'Aplicar',
    
    // Opciones de filtros - Tipos
    'all_types' => 'Todos los tipos',
    'type_transfer' => 'Transferencia',
    'type_deposit' => 'Depósito',
    'type_withdrawal' => 'Retiro',
    
    // Opciones de filtros - Estados
    'all_statuses' => 'Todos los estados',
    'status_pending' => 'Pendiente',
    'status_on_hold' => 'En espera',
    'status_success' => 'Exitoso',
    'status_failed' => 'Fallido',
    
    // Encabezados de tabla
    'table_transaction' => 'Transacción',
    'table_type' => 'Tipo',
    'table_amount' => 'Importe',
    'table_recipient' => 'Beneficiario',
    'table_status' => 'Estado',
    'table_progress' => 'Progreso',
    'table_date' => 'Fecha',
    'table_actions' => 'Acciones',
    
    // Acciones
    'action_receipt' => 'Recibo',
    'action_download_receipt' => 'Descargar recibo',
    
    // Mensajes vacíos
    'no_transactions' => 'No se encontraron transacciones',
    'no_transactions_message' => 'Ninguna transacción coincide con sus criterios de búsqueda.',
    'reset_filters' => 'Restablecer filtros',
    
    // Paginación
    'showing_results' => 'Mostrando :first a :last de :total transacciones',
    
    // JavaScript
    'generating' => 'Generando...',
];
