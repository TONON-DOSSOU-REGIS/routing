@extends('layouts.admin')

@section('title', __('budgets.page_title'))

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('budgets.page_heading') }}</h1>
            <p class="text-gray-600 mt-1">{{ __('budgets.page_subtitle') }}</p>
        </div>
        <a href="{{ localized_route('budgets.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-300 shadow-lg">
            <i class="fas fa-plus mr-2"></i> {{ __('budgets.new_budget') }}
        </a>
    </div>

    <!-- Budgets Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_user') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_category') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_amount') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_spent') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_remaining') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_month') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_status') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('budgets.table_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($budgets as $budget)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $budget->user->name ?? __('budgets.unknown_user') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $budget->category }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            {{ number_format($budget->amount, 2) }} €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ number_format($budget->spent, 2) }} €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $budget->remaining >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $budget->remaining >= 0 ? 'fa-check-circle' : 'fa-exclamation-triangle' }} mr-1"></i>
                                {{ number_format($budget->remaining, 2) }} €
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $budget->month->format('M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($budget->is_over_budget)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> {{ __('budgets.status_over_budget') }}
                                </span>
                            @elseif($budget->should_alert)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> {{ __('budgets.status_alert') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> {{ __('budgets.status_ok') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ localized_route('budgets.edit', $budget) }}" class="inline-flex items-center px-3 py-2 border border-yellow-300 rounded-lg text-yellow-700 bg-yellow-50 hover:bg-yellow-100 transition-colors duration-200" title="{{ __('budgets.action_edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ localized_route('budgets.destroy', $budget) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-red-300 rounded-lg text-red-700 bg-red-50 hover:bg-red-100 transition-colors duration-200" title="{{ __('budgets.action_delete') }}" onclick="return confirm('{{ __('budgets.delete_confirm') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-wallet text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('budgets.empty_title') }}</h3>
                                <p class="text-gray-500 mb-6 max-w-sm">{{ __('budgets.empty_message') }}</p>
                                <a href="{{ localized_route('budgets.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-300 shadow-lg">
                                    <i class="fas fa-plus mr-2"></i> {{ __('budgets.empty_action') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($budgets->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $budgets->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

