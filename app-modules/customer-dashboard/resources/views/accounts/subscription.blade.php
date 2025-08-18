<x-customer-account-layout::layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.my_subscription') }}</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.manage_subscription_details') }}</p>
        </div>

        <!-- Subscription Component -->
        <livewire:subscription--active-subscription :user="Auth::user()" />

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- View Plans -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-blue-200 dark:border-blue-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.view_plans') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.explore_subscription_plans') }}</p>
                    <a href="{{ route('subscription.pricing') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.browse_plans') }}
                    </a>
                </div>
            </div>
            
            <!-- Contact Support -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-amber-200 dark:border-amber-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.need_help') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.contact_support_subscription') }}</p>
                    <a href="{{ route('accounts.support') }}" class="bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.contact_support') }}
                    </a>
                </div>
            </div>
            
            <!-- Account Settings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-green-200 dark:border-green-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.account_settings') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.manage_account_preferences') }}</p>
                    <a href="{{ route('accounts.settings.profile') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.view_settings') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-customer-account-layout::layout>