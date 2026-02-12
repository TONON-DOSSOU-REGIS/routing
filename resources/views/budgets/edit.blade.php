@extends('layouts.admin')

@section('title', __('budgets.edit_title'))

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('budgets.edit_heading') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('budgets.edit_subtitle', ['category' => $budget->category]) }}</p>
        </div>

        <form action="{{ localized_route('budgets.update', $budget) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('budgets.category_label') }}
                </label>
                <input type="text" name="category" id="category" value="{{ $budget->category }}" readonly
                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                <p class="mt-1 text-sm text-gray-600">{{ __('budgets.category_help') }}</p>
            </div>

            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('budgets.budget_amount_label') }} *
                </label>
                <input type="number" name="amount" id="amount" step="0.01" min="0" value="{{ $budget->amount }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="{{ __('budgets.amount_placeholder') }}">
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="alert_enabled" id="alert_enabled" {{ $budget->alert_enabled ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="alert_enabled" class="ml-2 block text-sm text-gray-900">
                        {{ __('budgets.enable_alerts') }}
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-600">{{ __('budgets.alert_helper') }}</p>
            </div>

            <div class="mb-8" id="alert_threshold_container" style="{{ $budget->alert_enabled ? '' : 'display: none;' }}">
                <label for="alert_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('budgets.alert_threshold_label') }}
                </label>
                <input type="number" name="alert_threshold" id="alert_threshold" value="{{ $budget->alert_threshold }}" min="1" max="100"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-600">{{ __('budgets.alert_threshold_helper') }}</p>
                @error('alert_threshold')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ localized_route('budgets.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    {{ __('budgets.cancel') }}
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    {{ __('budgets.update') }}
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

