<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport des Transactions - Valtrix Bank</title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            color: #333;
        }

        .report-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }

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

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
            position: relative;
        }

        .header .subtitle {
            font-size: 18px;
            opacity: 0.9;
            position: relative;
        }

        .report-info {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 30px 40px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-item {
            text-align: center;
        }

        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .info-value {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
        }

        .table-container {
            padding: 40px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        thead {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        th {
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 20px 16px;
            text-align: left;
            border: none;
            position: relative;
        }

        th::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
        }

        th:last-child::after {
            display: none;
        }

        tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 16px;
            border: none;
            font-size: 14px;
            color: #475569;
        }

        .transaction-id {
            font-weight: 600;
            color: #1e293b;
            font-family: 'Courier New', monospace;
        }

        .user-name {
            font-weight: 500;
            color: #1e293b;
        }

        .type-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-transfer {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .type-deposit {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .type-withdrawal {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .amount {
            font-weight: 700;
            font-size: 16px;
            text-align: right;
        }

        .amount-positive {
            color: #10b981;
        }

        .amount-negative {
            color: #ef4444;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .status-on_hold {
            background: linear-gradient(135deg, #fecaca, #fca5a5);
            color: #991b1b;
        }

        .status-failed {
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
            color: #374151;
        }

        .progress-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .progress-bar {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 3px;
            transition: all 0.5s ease;
        }

        .progress-100 {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .progress-70 {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .progress-50 {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .progress-30 {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .progress-text {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            min-width: 30px;
            text-align: right;
        }

        .date-cell {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #64748b;
        }

        .footer {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .generated-info {
            font-size: 14px;
            color: #64748b;
        }

        .page-info {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
        }

        .copyright {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        /* Print styles */
        @media print {
            body {
                background: white !important;
                padding: 0;
            }
            
            .report-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .header {
                background: #2563eb !important;
                -webkit-print-color-adjust: exact;
            }
            
            thead {
                background: #1e293b !important;
                -webkit-print-color-adjust: exact;
            }
            
            .type-badge, .status-badge {
                -webkit-print-color-adjust: exact;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 28px;
            }
            
            .report-info {
                padding: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .table-container {
                padding: 20px;
            }
            
            th, td {
                padding: 12px 8px;
                font-size: 12px;
            }
            
            .footer-info {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- En-tête du rapport -->
        <div class="header">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-building-columns"></i>
                </div>
            </div>
            <h1>Rapport des Transactions</h1>
            <div class="subtitle">Valtrix Bank - Analyse complète des opérations financières</div>
        </div>

        <!-- Informations du rapport -->
        <div class="report-info">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-calendar"></i>
                        Période du rapport
                    </div>
                    <div class="info-value"><?php echo e(now()->format('d/m/Y')); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-exchange-alt"></i>
                        Total des transactions
                    </div>
                    <div class="info-value"><?php echo e($transactions->count()); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-euro-sign"></i>
                        Volume total
                    </div>
                    <div class="info-value"><?php echo e(number_format($transactions->sum('amount'), 2)); ?> €</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-check-circle"></i>
                        Taux de réussite
                    </div>
                    <div class="info-value">
                        <?php echo e($transactions->where('status', 'success')->count()); ?>/<?php echo e($transactions->count()); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des transactions -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Transaction</th>
                        <th>Utilisateur</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Progression</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="transaction-id">#<?php echo e($transaction->id); ?></td>
                        <td class="user-name"><?php echo e($transaction->user->first_name); ?> <?php echo e($transaction->user->last_name); ?></td>
                        <td>
                            <span class="type-badge type-<?php echo e($transaction->type); ?>">
                                <?php echo e($transaction->type); ?>

                            </span>
                        </td>
                        <td class="amount <?php echo e($transaction->type == 'deposit' ? 'amount-positive' : 'amount-negative'); ?>">
                            <?php echo e(number_format($transaction->amount, 2)); ?> €
                        </td>
                        <td>
                            <span class="status-badge status-<?php echo e($transaction->status); ?>">
                                <?php echo e($transaction->status); ?>

                            </span>
                        </td>
                        <td>
                            <div class="progress-container">
                                <div class="progress-bar">
                                    <div class="progress-fill 
                                        <?php if($transaction->progress >= 100): ?> progress-100
                                        <?php elseif($transaction->progress >= 70): ?> progress-70
                                        <?php elseif($transaction->progress >= 50): ?> progress-50
                                        <?php else: ?> progress-30 <?php endif; ?>"
                                        style="width: <?php echo e($transaction->progress); ?>%">
                                    </div>
                                </div>
                                <span class="progress-text"><?php echo e($transaction->progress); ?>%</span>
                            </div>
                        </td>
                        <td class="date-cell"><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <div class="footer-info">
                <div class="generated-info">
                    <i class="fas fa-clock"></i>
                    Généré le <?php echo e(now()->format('d/m/Y à H:i')); ?>

                </div>
                <div class="page-info">
                    Page 1 sur 1
                </div>
            </div>
            <div class="copyright">
                &copy; 2025 Valtrix Bank. Tous droits réservés. | Rapport confidentiel
            </div>
        </div>
    </div>

    <!-- Font Awesome pour les icônes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
        // Script pour l'impression
        function printReport() {
            window.print();
        }

        // Auto-print option (décommentez si nécessaire)
        // window.addEventListener('load', function() {
        //     setTimeout(printReport, 1000);
        // });

        // Ajout d'un bouton d'impression (optionnel)
        document.addEventListener('DOMContentLoaded', function() {
            const printButton = document.createElement('button');
            printButton.innerHTML = '<i class="fas fa-print"></i> Imprimer le rapport';
            printButton.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: white;
                border: none;
                padding: 12px 24px;
                border-radius: 12px;
                font-family: 'Inter', sans-serif;
                font-weight: 600;
                cursor: pointer;
                box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
                transition: all 0.3s ease;
                z-index: 1000;
            `;
            printButton.onmouseover = function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 6px 20px rgba(37, 99, 235, 0.4)';
            };
            printButton.onmouseout = function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 15px rgba(37, 99, 235, 0.3)';
            };
            printButton.onclick = printReport;
            document.body.appendChild(printButton);
        });
    </script>
</body>
</html>


<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/admin/exports/transactions_pdf.blade.php ENDPATH**/ ?>