<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('support.help_center_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.favicon')
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-gradient { background: linear-gradient(90deg, #1e3a8a 0%, #1e40af 100%); }
        .text-premium { color: #1e3a8a; }
        .btn-premium { background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%); color: white; transition: all 0.3s ease; }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3); }
        .premium-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .faq-item { border-radius: 0.75rem; border: 1px solid #e5e7eb; background-color: #ffffff; overflow: hidden; transition: box-shadow 0.3s ease, transform 0.3s ease, border-color 0.3s ease; }
        .faq-item.active { box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12); border-color: #1e40af; transform: translateY(-2px); }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
        .faq-answer.open { max-height: 500px; }
    </style>
</head>
<body class="bg-gray-50">
  @include('components.background-slider')

    <nav class="nav-gradient shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt=""></a>
                    </div>
                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-2xl font-bold text-white"><span class="sr-only">Valtrix Bank</span></a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="text-white hover:text-blue-200 transition font-medium">{{ __('support.login') }}</a>
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-6 py-3 rounded-lg font-semibold">{{ __('support.create_account') }}</a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700 hidden">
                <div class="px-4 py-6 space-y-4">
                    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="block text-white py-3 text-center">{{ __('support.login') }}</a>
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="block text-white py-3 text-center">{{ __('support.create_account') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="support-hero relative pt-32 pb-20 text-white" data-support-hero data-hero-tone="indigo">
        @include('components.support-hero-slider')
        <div class="support-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">{{ __('support.help_center') }}</h1>
                <p class="text-xl mb-8 text-indigo-100 leading-relaxed">{{ __('support.find_answers_quickly') }} {{ __('support.knowledge_base_available') }}</p>
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" placeholder="{{ __('support.search_help') }}" class="w-full px-6 py-4 rounded-2xl text-gray-900 text-lg focus:outline-none">
                        <button class="absolute right-3 top-3 btn-premium px-6 py-2 rounded-xl font-semibold"><i class="fas fa-search mr-2"></i>{{ __('support.search') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-premium">{{ __('support.quick_actions') }}</h2>
                <p class="text-gray-600">{{ __('support.access_most_requested_solutions') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="#faq" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition"><h3 class="font-semibold mb-2 text-premium">{{ __('support.faq') }}</h3><p class="text-gray-600 text-sm">{{ __('support.frequently_asked_questions') }}</p></a>
                <a href="#guides" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition"><h3 class="font-semibold mb-2 text-premium">{{ __('support.guides') }}</h3><p class="text-gray-600 text-sm">{{ __('support.detailed_tutorials') }}</p></a>
                <a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition"><h3 class="font-semibold mb-2 text-premium">{{ __('support.support') }}</h3><p class="text-gray-600 text-sm">{{ __('support.contact_team') }}</p></a>
                <a href="#status" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition"><h3 class="font-semibold mb-2 text-premium">{{ __('support.status') }}</h3><p class="text-gray-600 text-sm">{{ __('support.service_status') }}</p></a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50" id="guides">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-premium">{{ __('support.popular_topics') }}</h2>
                <p class="text-gray-600">{{ __('support.most_frequent_questions') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="premium-card rounded-xl p-6"><h3 class="font-semibold mb-2 text-premium">{{ __('support.create_account') }}</h3><p class="text-gray-600 text-sm mb-3">{{ __('support.complete_guide_open_account') }}</p><a href="#" class="text-blue-600 text-sm">{{ __('support.read_guide') }}</a></div>
                <div class="premium-card rounded-xl p-6"><h3 class="font-semibold mb-2 text-premium">{{ __('support.make_transfer') }}</h3><p class="text-gray-600 text-sm mb-3">{{ __('support.how_to_make_transfer_securely') }}</p><a href="#" class="text-blue-600 text-sm">{{ __('support.read_guide') }}</a></div>
                <div class="premium-card rounded-xl p-6"><h3 class="font-semibold mb-2 text-premium">{{ __('support.order_card') }}</h3><p class="text-gray-600 text-sm mb-3">{{ __('support.all_about_cards') }}</p><a href="#" class="text-blue-600 text-sm">{{ __('support.read_guide') }}</a></div>
                <div class="premium-card rounded-xl p-6"><h3 class="font-semibold mb-2 text-premium">{{ __('support.account_security') }}</h3><p class="text-gray-600 text-sm mb-3">{{ __('support.protect_account_best_practices') }}</p><a href="#" class="text-blue-600 text-sm">{{ __('support.read_guide') }}</a></div>
                <div class="premium-card rounded-xl p-6"><h3 class="font-semibold mb-2 text-premium">{{ __('support.receipts_and_proofs') }}</h3><p class="text-gray-600 text-sm mb-3">{{ __('support.how_to_get_manage_receipts') }}</p><a href="#" class="text-blue-600 text-sm">{{ __('support.read_guide') }}</a></div>
                <div class="premium-card rounded-xl p-6"><h3 class="font-semibold mb-2 text-premium">{{ __('support.dashboard') }}</h3><p class="text-gray-600 text-sm mb-3">{{ __('support.discover_all_features') }}</p><a href="#" class="text-blue-600 text-sm">{{ __('support.read_guide') }}</a></div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">{{ __('support.frequent_questions_title') }}</h2>
                <p class="text-xl text-gray-600 leading-relaxed">{{ __('support.find_answers_most_common_questions') }}</p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6" id="faq-list">
                <div class="faq-item"><button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left"><div><p class="font-bold text-xl text-gray-800">{{ __('support.faq_how_open_account') }}</p><p class="text-gray-500 mt-2">{{ __('support.faq_simple_registration_steps') }}</p></div><i class="fas fa-chevron-down text-gray-400 text-lg"></i></button><div class="faq-answer px-8 pb-6"><p class="text-gray-600 leading-relaxed mb-4">{{ __('support.faq_open_account_answer') }}</p><a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-4 py-2 rounded-lg text-sm">{{ __('support.create_account') }}</a></div></div>
                <div class="faq-item"><button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left"><div><p class="font-bold text-xl text-gray-800">{{ __('support.faq_transfers_monitored') }}</p><p class="text-gray-500 mt-2">{{ __('support.faq_manual_tracking_control') }}</p></div><i class="fas fa-chevron-down text-gray-400 text-lg"></i></button><div class="faq-answer px-8 pb-6"><p class="text-gray-600 leading-relaxed">{{ __('support.faq_transfers_monitored_answer') }}</p></div></div>
                <div class="faq-item"><button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left"><div><p class="font-bold text-xl text-gray-800">{{ __('support.faq_download_receipt') }}</p><p class="text-gray-500 mt-2">{{ __('support.faq_pdf_available') }}</p></div><i class="fas fa-chevron-down text-gray-400 text-lg"></i></button><div class="faq-answer px-8 pb-6"><p class="text-gray-600 leading-relaxed">{{ __('support.faq_download_receipt_answer') }}</p></div></div>
                <div class="faq-item"><button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left"><div><p class="font-bold text-xl text-gray-800">{{ __('support.faq_problem_or_doubt') }}</p><p class="text-gray-500 mt-2">{{ __('support.faq_human_support_available') }}</p></div><i class="fas fa-chevron-down text-gray-400 text-lg"></i></button><div class="faq-answer px-8 pb-6"><p class="text-gray-600 leading-relaxed mb-4">{{ __('support.faq_problem_or_doubt_answer') }}</p><a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="btn-premium px-4 py-2 rounded-lg text-sm">{{ __('support.contact_team') }}</a></div></div>
                <div class="faq-item"><button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left"><div><p class="font-bold text-xl text-gray-800">{{ __('support.faq_fees_sg_bank') }}</p><p class="text-gray-500 mt-2">{{ __('support.faq_total_transparency_fees') }}</p></div><i class="fas fa-chevron-down text-gray-400 text-lg"></i></button><div class="faq-answer px-8 pb-6"><p class="text-gray-600 leading-relaxed">{{ __('support.faq_fees_sg_bank_answer') }}</p></div></div>
                <div class="faq-item"><button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left"><div><p class="font-bold text-xl text-gray-800">{{ __('support.faq_data_secure') }}</p><p class="text-gray-500 mt-2">{{ __('support.faq_maximum_data_protection') }}</p></div><i class="fas fa-chevron-down text-gray-400 text-lg"></i></button><div class="faq-answer px-8 pb-6"><p class="text-gray-600 leading-relaxed">{{ __('support.faq_data_secure_answer') }}</p></div></div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">{{ __('support.need_additional_help') }}</h2>
            <p class="text-xl mb-8 text-blue-100 leading-relaxed">{{ __('support.support_team_available') }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="btn-premium px-8 py-4 rounded-lg font-semibold">{{ __('support.contact_support') }}</a>
                <a href="tel:+33123456789" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition"><i class="fas fa-phone mr-2"></i>{{ __('support.phone_number') }}</a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6"><div class="text-center"><p>&copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. {{ __('support.all_rights_reserved') }}</p></div></div>
    </footer>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        const faqItems = document.querySelectorAll('#faq-list .faq-item');
        faqItems.forEach(item => {
            const button = item.querySelector('button');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('i.fas.fa-chevron-down');
            button.addEventListener('click', function() {
                const isOpen = answer.classList.contains('open');
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-answer')?.classList.remove('open');
                    otherItem.querySelector('i.fas.fa-chevron-down')?.classList.remove('rotate-180');
                });
                if (!isOpen) {
                    item.classList.add('active');
                    answer.classList.add('open');
                    icon.classList.add('rotate-180');
                }
            });
        });
    </script>
</body>
</html>
