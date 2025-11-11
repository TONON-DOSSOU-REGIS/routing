<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau virement - BankPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-900">BankPro</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">Nouveau virement</h1>

                    <form id="transferForm" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Montant (€)</label>
                            <input type="number" step="0.01" id="amount" name="amount" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00">
                            @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="recipient_name" class="block text-sm font-medium text-gray-700">Nom du bénéficiaire</label>
                            <input type="text" id="recipient_name" name="recipient_name" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('recipient_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="recipient_iban" class="block text-sm font-medium text-gray-700">IBAN du bénéficiaire</label>
                            <input type="text" id="recipient_iban" name="recipient_iban" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="FR76 1234 5678 9012 3456 7890 123">
                            @error('recipient_iban') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="recipient_bic" class="block text-sm font-medium text-gray-700">BIC du bénéficiaire</label>
                            <input type="text" id="recipient_bic" name="recipient_bic" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="BNPAFRPP">
                            @error('recipient_bic') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="bank_name" class="block text-sm font-medium text-gray-700">Nom de la banque</label>
                            <input type="text" id="bank_name" name="bank_name" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('bank_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700">Motif (optionnel)</label>
                            <input type="text" id="reason" name="reason"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('reason') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="activation_code" class="block text-sm font-medium text-gray-700">Code d'activation (si requis)</label>
                            <input type="text" id="activation_code" name="activation_code"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('activation_code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('dashboard') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Annuler</a>
                            <button type="button" id="startBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Lancer le virement
                            </button>
                        </div>
                    </form>

                    <!-- Barre de progression -->
                    <div class="mt-8 hidden" id="progressSection">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Progression du virement</h3>
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                            <div id="progressBar" class="bg-blue-600 h-4 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <div class="text-center text-sm text-gray-600" id="progressText">0%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash overlay -->
        <div id="flashOverlay" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-60 z-50">
            <div class="bg-white max-w-md w-full mx-4 p-6 rounded-2xl shadow-xl text-center animate-pulse">
                <h3 class="text-xl font-semibold mb-4">Opération interrompue</h3>
                <p id="flashMessage" class="text-gray-700 mb-4"></p>
                <button id="closeFlash" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">J'ai compris</button>
            </div>
        </div>
    </div>

    <script>
        const startBtn = document.getElementById('startBtn');
        const progressSection = document.getElementById('progressSection');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const overlay = document.getElementById('flashOverlay');
        const flashMsg = document.getElementById('flashMessage');
        const closeFlash = document.getElementById('closeFlash');

        let txId = null;
        let ticking = false;

        function setProgress(p) {
            progressBar.style.width = p + '%';
            progressText.textContent = p + '%';
        }

        startBtn.addEventListener('click', async () => {
            if (ticking) return;
            const form = document.getElementById('transferForm');
            const payload = new FormData(form);

            try {
                const res = await fetch('{{ route('transfer.start') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: payload
                });

                const data = await res.json();

                if (res.ok) {
                    txId = data.tx_id;
                    ticking = true;
                    progressSection.classList.remove('hidden');
                    tick();
                } else {
                    alert('Erreur lors du lancement du virement');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            }
        });

        async function tick() {
            if (!ticking || !txId) return;

            try {
                const res = await fetch('{{ route('transfer.progress') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ tx_id: txId })
                });

                const data = await res.json();

                setProgress(data.progress);

                if (data.status === 'on_hold') {
                    ticking = false;
                    flashMsg.textContent = data.message || 'Transaction en attente.';
                    overlay.classList.remove('hidden');
                    overlay.classList.add('flex');
                    return;
                }

                if (data.status === 'success') {
                    ticking = false;
                    window.location.href = '{{ route('transactions.history') }}';
                    return;
                }

                // Continue ticking
                setTimeout(tick, 700);
            } catch (error) {
                console.error('Error:', error);
                ticking = false;
            }
        }

        closeFlash.addEventListener('click', () => {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        });
    </script>
</body>
</html>
