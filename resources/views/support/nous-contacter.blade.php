<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('support.contact_title') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.favicon')
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-gradient { background: linear-gradient(90deg, #1e3a8a 0%, #1e40af 100%); }
        .text-premium { color: #1e3a8a; }
        .btn-premium { background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%); color: white; transition: 0.3s; }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3); }
        .premium-card { background: rgba(255,255,255,0.97); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }

        .hero-image{
            background-image:linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.6)),
                url('https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&fit=crop&w=2070&q=80');
            background-size:cover;
            background-position:center;
            background-attachment:fixed;
        }

        .contact-section-bg{
            background-image:linear-gradient(rgba(14,18,35,.88),rgba(14,18,35,.92)),
                url('https://images.unsplash.com/photo-1523289333742-be1143f6b766?auto=format&fit=crop&w=2100&q=80');
            background-size:cover;
            background-position:center;
        }

        #map{
            width:100%;
            height:450px;
            border:0;
            border-radius:16px;
        }

        .error-message{
            font-size:.875rem;
            color:#dc2626;
        }
    </style>

</head>
<body class="bg-gray-50">
  @include('components.background-slider')
<!-- NAVIGATION -->
    <nav class="nav-gradient shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                    </div>
                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-2xl font-bold text-white"><span class="sr-only">Valtrix Bank</span></a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="text-white hover:text-blue-200 transition font-medium">{{ __('support.login') }}</a>
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-6 py-3 rounded-lg font-semibold">{{ __('support.create_account') }}</a>
                </div>

                <button id="mobile-menu-button" class="md:hidden text-white text-3xl">
                    <i class="fas fa-bars"></i>
                </button>

            </div>

            <div id="mobile-menu" class="hidden md:hidden bg-blue-900 border-t border-blue-700">
                <div class="px-4 py-4 space-y-4 text-center">
                    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="block text-white py-2">{{ __('support.login') }}</a>
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="block text-white py-2">{{ __('support.create_account') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-image text-white pt-32 pb-24 text-center">
        <h1 class="text-5xl font-bold mb-6">{{ __('support.contact_hero_title') }}</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            {{ __('support.contact_hero_subtitle') }}
        </p>
    </section>

    <!-- CONTACT OPTIONS -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-4xl font-bold text-center text-premium mb-14">{{ __('support.contact_how_to_reach') }}</h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

                <div class="premium-card p-8 text-center rounded-2xl">
                    <div class="w-20 h-20 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-phone text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3 text-premium">{{ __('support.contact_phone') }}</h3>
                    <p class="text-gray-600 mb-2">{{ __('support.contact_phone_hours') }}</p>
                    <p class="font-semibold text-premium">{{ __('support.contact_phone_number') }}</p>
                </div>

                <div class="premium-card p-8 text-center rounded-2xl">
                    <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-envelope text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3 text-premium">{{ __('support.contact_email') }}</h3>
                    <p class="text-gray-600 mb-2">{{ __('support.contact_email_response') }}</p>
                    <p class="font-semibold text-premium">{{ __('support.contact_email_address') }}</p>
                </div>

                <div class="premium-card p-8 text-center rounded-2xl">
                    <div class="w-20 h-20 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-comments text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3 text-premium">{{ __('support.contact_chat') }}</h3>
                    <p class="text-gray-600 mb-2">{{ __('support.contact_chat_response') }}</p>
                    <p class="font-semibold text-premium">{{ __('support.contact_chat_available') }}</p>
                </div>

                <div class="premium-card p-8 text-center rounded-2xl">
                    <div class="w-20 h-20 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-map-marker-alt text-orange-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3 text-premium">{{ __('support.contact_appointment') }}</h3>
                    <p class="text-gray-600 mb-2">{{ __('support.contact_appointment_location') }}</p>
                    <p class="font-semibold text-premium">{{ __('support.contact_appointment_request') }}</p>
                </div>

            </div>

        </div>
    </section>

    <!-- FORMULAIRE + MAP -->
    <section class="py-24 contact-section-bg text-white">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-4xl font-bold text-center mb-14">{{ __('support.contact_form_title') }}</h2>

            <div class="grid lg:grid-cols-2 gap-14">

                <!-- FORMULAIRE -->
                <div class="premium-card p-8 text-gray-800 rounded-2xl">
                    <form method="POST" action="{{ localized_route('support.nous-contacter.store', ['locale' => app()->getLocale()]) }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="font-semibold">{{ __('support.contact_form_first_name') }}</label>
                                <input type="text" name="first_name" class="w-full mt-2 border rounded-lg p-3" required>
                            </div>
                            <div>
                                <label class="font-semibold">{{ __('support.contact_form_last_name') }}</label>
                                <input type="text" name="last_name" class="w-full mt-2 border rounded-lg p-3" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="font-semibold">{{ __('support.contact_form_email') }}</label>
                                <input type="email" name="email" class="w-full mt-2 border rounded-lg p-3" required>
                            </div>
                            <div>
                                <label class="font-semibold">{{ __('support.contact_form_phone') }}</label>
                                <input type="tel" name="phone" class="w-full mt-2 border rounded-lg p-3">
                            </div>
                        </div>

                        <div>
                            <label class="font-semibold">{{ __('support.contact_form_subject') }}</label>
                            <select name="subject" class="w-full mt-2 border rounded-lg p-3" required>
                                <option value="">{{ __('support.contact_form_select_subject') }}</option>
                                <option value="support">{{ __('support.contact_form_subject_support') }}</option>
                                <option value="commercial">{{ __('support.contact_form_subject_commercial') }}</option>
                                <option value="partnership">{{ __('support.contact_form_subject_partnership') }}</option>
                                <option value="press">{{ __('support.contact_form_subject_press') }}</option>
                                <option value="other">{{ __('support.contact_form_subject_other') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-semibold">{{ __('support.contact_form_message') }}</label>
                            <textarea name="message" rows="6" class="w-full mt-2 border rounded-lg p-3" required></textarea>
                        </div>

                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="privacy_accepted" class="mt-1" required>
                            <label class="text-sm text-gray-700">{!! __('support.contact_form_privacy') !!}</label>
                        </div>

                        <button class="btn-premium px-10 py-4 rounded-lg text-lg mt-4 w-full">
                            {{ __('support.contact_form_send') }}
                        </button>
                    </form>
                </div>

                <!-- GOOGLE MAP SANS API -->
                <div class="premium-card p-8 rounded-2xl">
                    <h3 class="text-2xl font-bold text-premium text-center mb-6">{{ __('support.contact_offices_title') }}</h3>

                    <div class="rounded-xl overflow-hidden shadow-xl">
                        <iframe 
                            id="map"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.999503835157!2d2.293651815673616!3d48.873779179288525!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fddf9555ab5%3A0xae5cbb18ce19e6f!2sChamps-%C3%89lys%C3%A9es!5e0!3m2!1sfr!2sfr!4v1700000000000"
                        ></iframe>
                    </div>

                    <div class="mt-6 text-gray-800 space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">{{ __('support.contact_office_address') }}</p>
                                <p class="text-gray-600">{{ __('support.contact_office_city') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">{{ __('support.contact_office_hours') }}</p>
                                <p class="text-gray-600">{{ __('support.contact_office_weekend') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-phone text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">{{ __('support.contact_office_phone') }}</p>
                                <p class="text-gray-600">{{ __('support.contact_office_phone_label') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 text-center py-10">
        &copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. {{ __('support.all_rights_reserved') }}
    </footer>

    <script>
        document.getElementById('mobile-menu-button').onclick = () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        };
    </script>

</body>
</html>
