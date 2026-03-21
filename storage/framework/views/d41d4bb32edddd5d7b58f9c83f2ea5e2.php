<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('support.legal_mentions_title')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-gradient { background: linear-gradient(90deg, #1e3a8a 0%, #1e40af 100%); }
        .text-premium { color: #1e3a8a; }
        .btn-premium { background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%); color: white; transition: all 0.3s ease; }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3); }
        .premium-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    </style>
</head>
<body class="bg-gray-50">
  <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <nav class="nav-gradient shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"><img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-9 h-9" alt=""></a>
                    </div>
                    <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="text-2xl font-bold text-white"><span class="sr-only">Valtrix Bank</span></a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__('support.login')); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-6 py-3 rounded-lg font-semibold"><?php echo e(__('support.create_account')); ?></a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700 hidden">
                <div class="px-4 py-6 space-y-4">
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="block text-white py-3 text-center"><?php echo e(__('support.login')); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="block text-white py-3 text-center"><?php echo e(__('support.create_account')); ?></a>
                </div>
            </div>
        </div>
    </nav>

    <section class="support-hero relative pt-32 pb-20 text-white" data-support-hero data-hero-tone="slate">
        <?php echo $__env->make('components.support-hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="support-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6"><?php echo e(__('support.legal_mentions')); ?></h1>
                <p class="text-xl mb-8 text-gray-100 leading-relaxed"><?php echo e(__('support.legal_mentions_description')); ?></p>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg max-w-none">

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">1. <?php echo e(__('support.site_editor')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><strong><?php echo e(__('support.site_editor_company_name')); ?></strong></p>
                        <p><?php echo e(__('support.site_editor_company_type')); ?></p>
                        <p><?php echo e(__('support.site_editor_rcs')); ?></p>
                        <p><?php echo e(__('support.site_editor_vat')); ?></p>
                        <p><?php echo e(__('support.site_editor_address')); ?></p>
                        <p><?php echo e(__('support.site_editor_phone')); ?></p>
                        <p><?php echo e(__('support.site_editor_email')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">2. <?php echo e(__('support.publication_director')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><strong><?php echo e(__('support.publication_director_name')); ?></strong></p>
                        <p><?php echo e(__('support.publication_director_title')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">3. <?php echo e(__('support.hosting')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><strong><?php echo e(__('support.hosting_company')); ?></strong></p>
                        <p><?php echo e(__('support.hosting_company_type')); ?></p>
                        <p><?php echo e(__('support.hosting_rcs')); ?></p>
                        <p><?php echo e(__('support.hosting_address')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">4. <?php echo e(__('support.approvals_and_authorizations')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.approvals_description')); ?></p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li><?php echo e(__('support.approvals_registration_number')); ?></li>
                            <li><?php echo e(__('support.approvals_payment_service')); ?></li>
                            <li><?php echo e(__('support.approvals_garantee_fund')); ?></li>
                        </ul>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">5. <?php echo e(__('support.general_terms_of_use')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.general_terms_description')); ?></p>
                        <h3 class="text-xl font-semibold mt-6 mb-3"><?php echo e(__('support.terms_acceptance_title')); ?></h3>
                        <p><?php echo e(__('support.terms_acceptance_description')); ?></p>
                        <h3 class="text-xl font-semibold mt-6 mb-3"><?php echo e(__('support.terms_services_title')); ?></h3>
                        <p><?php echo e(__('support.terms_services_description')); ?></p>
                        <h3 class="text-xl font-semibold mt-6 mb-3"><?php echo e(__('support.terms_responsibility_title')); ?></h3>
                        <p><?php echo e(__('support.terms_responsibility_description')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">6. <?php echo e(__('support.personal_data_protection')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.personal_data_gdpr')); ?></p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li><?php echo e(__('support.personal_data_collect_necessary')); ?></li>
                            <li><?php echo e(__('support.personal_data_process_lawful')); ?></li>
                            <li><?php echo e(__('support.personal_data_security')); ?></li>
                            <li><?php echo e(__('support.personal_data_rights')); ?></li>
                            <li><?php echo e(__('support.personal_data_retention')); ?></li>
                        </ul>
                        <h3 class="text-xl font-semibold mt-6 mb-3"><?php echo e(__('support.personal_data_collected_title')); ?></h3>
                        <p><?php echo e(__('support.personal_data_collected_description')); ?></p>
                        <h3 class="text-xl font-semibold mt-6 mb-3"><?php echo e(__('support.personal_data_purposes_title')); ?></h3>
                        <p><?php echo e(__('support.personal_data_purposes_description')); ?></p>
                        <h3 class="text-xl font-semibold mt-6 mb-3"><?php echo e(__('support.personal_data_recipients_title')); ?></h3>
                        <p><?php echo e(__('support.personal_data_recipients_description')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">7. <?php echo e(__('support.cookies')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.cookies_description')); ?></p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li><?php echo e(__('support.cookies_technical')); ?></li>
                            <li><?php echo e(__('support.cookies_analytics')); ?></li>
                            <li><?php echo e(__('support.cookies_functional')); ?></li>
                        </ul>
                        <p><?php echo e(__('support.cookies_management')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">8. <?php echo e(__('support.intellectual_property')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.intellectual_property_description')); ?></p>
                        <p><?php echo e(__('support.intellectual_property_brand')); ?></p>
                        <p><?php echo e(__('support.intellectual_property_reproduction')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">9. <?php echo e(__('support.responsibility')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.responsibility_availability')); ?></p>
                        <p><?php echo e(__('support.responsibility_liability')); ?></p>
                        <p><?php echo e(__('support.responsibility_user')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">10. <?php echo e(__('support.applicable_law_and_jurisdiction')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.jurisdiction_french_law')); ?></p>
                        <p><?php echo e(__('support.jurisdiction_courts')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">11. <?php echo e(__('support.modification_of_legal_mentions')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.modification_right')); ?></p>
                        <p><?php echo e(__('support.modification_effect')); ?></p>
                        <p><?php echo e(__('support.modification_acceptance')); ?></p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">12. <?php echo e(__('support.contact')); ?></h2>
                    <div class="space-y-4 text-gray-700">
                        <p><?php echo e(__('support.contact_description')); ?></p>
                        <ul class="list-none space-y-2">
                            <li><i class="fas fa-envelope mr-2 text-blue-600"></i> <?php echo e(__('support.site_editor_email')); ?></li>
                            <li><i class="fas fa-phone mr-2 text-blue-600"></i> <?php echo e(__('support.site_editor_phone')); ?></li>
                            <li><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> <?php echo e(__('support.site_editor_address')); ?></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6"><div class="text-center"><p>&copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. <?php echo e(__('support.all_rights_reserved')); ?></p></div></div>
    </footer>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\support\mentions-legales.blade.php ENDPATH**/ ?>