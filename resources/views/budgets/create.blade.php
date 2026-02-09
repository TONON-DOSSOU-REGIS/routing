@extends('layouts.admin')

@section('title', 'Créer un Budget')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Créer un Budget</h1>
            <p class="text-gray-600 mt-2">Définissez un budget pour une catégorie de dépenses</p>
        </div>

        <form action="{{ localized_route('budgets.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Utilisateur *
                </label>
                <select name="user_id" id="user_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Sélectionnez un utilisateur</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Catégorie *
                </label>
                <select name="category" id="category" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                    Montant du budget (€) *
                </label>
                <input type="number" name="amount" id="amount" step="0.01" min="0" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="0.00">
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">
                    Mois *
                </label>
                <input type="month" name="month" id="month" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       value="{{ date('Y-m') }}">
                @error('month')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="alert_enabled" id="alert_enabled" checked
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="alert_enabled" class="ml-2 block text-sm text-gray-900">
                        Activer les alertes
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-600">Recevez une notification quand vous dépassez le seuil d'alerte</p>
            </div>

            <div class="mb-8" id="alert_threshold_container">
                <label for="alert_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                    Seuil d'alerte (%)
                </label>
                <input type="number" name="alert_threshold" id="alert_threshold" value="80" min="1" max="100"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-600">Pourcentage du budget à partir duquel vous recevrez une alerte</p>
                @error('alert_threshold')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ localized_route('budgets.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Annuler
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    Créer le budget
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('alert_enabled').addEventListener('change', function() {
    const container = document.getElementById('alert_threshold_container');
    const input = document.getElementById('alert_threshold');

    if (this.checked) {
        container.style.display = 'block';
        input.required = true;
    } else {
        container.style.display = 'none';
        input.required = false;
    }
});
</script>
@endsection

