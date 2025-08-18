<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('accounts.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.support') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.support_center') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.get_help_support') }}</p>
    </div>
    
    <!-- Coming Soon Message -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8">
        <div class="text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.support_coming_soon') }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('messages.support_feature_development') }}</p>
            <a href="{{ route('accounts.index') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                {{ __('messages.back_to_account') }}
            </a>
        </div>
    </div>
</x-customer-account-layout::layout>