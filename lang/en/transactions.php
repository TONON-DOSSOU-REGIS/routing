<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Transaction Language Lines
    |--------------------------------------------------------------------------
    */

    // Page titles
    'page_title' => 'New Transfer - SG BANK',
    'new_transfer' => 'New Transfer',

    // Navigation
    'dashboard' => 'Dashboard',
    'logout' => 'Logout',

    // Headers
    'transfer_title' => 'New Transfer',
    'transfer_subtitle' => 'Make a secure transfer to a beneficiary',

    // Step indicators
    'step_information' => 'Information',
    'step_processing' => 'Processing',
    'step_confirmation' => 'Confirmation',

    //Sections montant
    'transfer_amount' => 'Transfer Amount',

    // Form sections
    'transfer_details' => 'Transfer Details',
    'beneficiary_info' => 'Enter beneficiary information',
    'banking_details' => 'Banking Details',
    'additional_info' => 'Additional Information',

    // Form labels
    'amount' => 'Transfer Amount',
    'recipient_name' => 'Beneficiary Name',
    'bank_name' => 'Bank Name',
    'recipient_iban' => 'Beneficiary IBAN',
    'recipient_bic' => 'Beneficiary BIC',
    'reason' => 'Transfer Reason (optional)',
    'activation_code' => 'Activation Code',

    // Placeholders
    'amount_placeholder' => '0.00',
    'recipient_name_placeholder' => 'John Doe',
    'bank_name_placeholder' => 'National Bank',
    'iban_placeholder' => 'FR76 1234 5678 9012 3456 7890 123',
    'bic_placeholder' => 'BNPAFRPP',
    'reason_placeholder' => 'Refund, gift...',
    'activation_code_placeholder' => 'Your personal activation code',

    // Buttons
    'cancel' => 'Cancel',
    'start_transfer' => 'Start Transfer',
    'processing' => 'Processing...',

    // Progress section
    'processing_in_progress' => 'Processing in Progress',
    'transfer_progress' => 'Transfer Progress',
    'processing_message' => 'Your transfer is being processed. Please wait...',

    // Flash messages
    'operation_interrupted' => 'Operation Interrupted',
    'operation_successful' => 'Operation Successful',
    'transfer_successful' => 'Transfer completed successfully! You will be redirected...',
    'understood' => 'I understand',

    // Error messages
    'amount_required' => 'The amount field is required.',
    'recipient_name_required' => 'The beneficiary name field is required.',
    'bank_name_required' => 'The bank name field is required.',
    'iban_required' => 'The IBAN field is required.',
    'bic_required' => 'The BIC field is required.',
    'activation_code_required' => 'The activation code field is required.',
    'reason_required' => 'The reason field is required.',

    // Validation messages
    'invalid_amount' => 'Please enter a valid amount.',
    'invalid_iban' => 'Please enter a valid IBAN.',
    'invalid_bic' => 'Please enter a valid BIC.',
    'invalid_activation_code' => 'Please enter a valid activation code.',

    // Status messages
    'transfer_pending' => 'Transfer pending security verification.',
    'connection_error' => 'Connection error during processing.',

    // History page
    'history_page_title' => 'Transaction History - SG BANK',
    'history_title' => 'Transaction History',
    'history_subtitle' => 'View all your financial operations',
    'history_overview' => 'Overview of your financial operations',
    
    // Export buttons
    'export_pdf' => 'Export PDF',
    'export_excel' => 'Export Excel',
    
    // Filters
    'filter_type' => 'Type',
    'filter_status' => 'Status',
    'filter_date_from' => 'Start Date',
    'filter_date_to' => 'End Date',
    'filter_apply' => 'Apply',
    
    // Filter options - Types
    'all_types' => 'All types',
    'type_transfer' => 'Transfer',
    'type_deposit' => 'Deposit',
    'type_withdrawal' => 'Withdrawal',
    
    // Filter options - Statuses
    'all_statuses' => 'All statuses',
    'status_pending' => 'Pending',
    'status_on_hold' => 'On Hold',
    'status_success' => 'Success',
    'status_failed' => 'Failed',
    
    // Table headers
    'table_transaction' => 'Transaction',
    'table_type' => 'Type',
    'table_amount' => 'Amount',
    'table_recipient' => 'Recipient',
    'table_status' => 'Status',
    'table_progress' => 'Progress',
    'table_date' => 'Date',
    'table_actions' => 'Actions',
    
    // Actions
    'action_receipt' => 'Receipt',
    'action_download_receipt' => 'Download receipt',
    
    // Empty messages
    'no_transactions' => 'No transactions found',
    'no_transactions_message' => 'No transactions match your search criteria.',
    'reset_filters' => 'Reset filters',
    
    // Pagination
    'showing_results' => 'Showing :first to :last of :total transactions',
    
    // JavaScript
    'generating' => 'Generating...',
];
