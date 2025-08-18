<x-customer-account-layout::layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.my_subscription') }}</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.manage_subscription_details') }}</p>
        </div>

        @if($currentSubscription)
            <!-- Current Subscription -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600">
                    <h2 class="text-xl font-semibold text-white">{{ __('messages.current_subscription') }}</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Plan Details -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('messages.plan_details') }}</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.plan_name') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $currentSubscription->subscriptionPlan->name }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.status') }}:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($currentSubscription->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($currentSubscription->status === 'expired') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($currentSubscription->status === 'cancelled') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                        {{ ucfirst($currentSubscription->status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.amount_paid') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ number_format($currentSubscription->paid_amount, 0) }} BDT</span>
                                </div>
                                @if($currentSubscription->coupon_code)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.coupon_used') }}:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ $currentSubscription->coupon_code }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Subscription Period -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('messages.subscription_period') }}</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.started_at') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $currentSubscription->starts_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.expires_at') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $currentSubscription->ends_at->format('M j, Y') }}</span>
                                </div>
                                @if($currentSubscription->status === 'active')
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.days_remaining') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $currentSubscription->ends_at->diffInDays(now()) }} {{ __('messages.days') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Plan Features -->
                    @if($currentSubscription->subscriptionPlan->getTranslation('features', app()->getLocale()))
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('messages.plan_features') }}</h3>
                        <div class="prose prose-sm max-w-none dark:prose-invert prose-ul:space-y-1 prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-li:marker:text-green-500">
                            {!! Str::markdown($currentSubscription->subscriptionPlan->getTranslation('features', app()->getLocale())) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-wrap gap-3">
                        @if($currentSubscription->payment)
                        <a href="{{ route('payment::payments.show', $currentSubscription->payment->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ __('messages.view_payment_details') }}
                        </a>
                        @endif
                        
                        @if($currentSubscription->status === 'expired')
                        <a href="{{ route('subscription.pricing') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ __('messages.renew_subscription') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- No Active Subscription -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">{{ __('messages.no_active_subscription') }}</h3>
                        <p class="text-yellow-700 dark:text-yellow-300 mt-1">{{ __('messages.no_subscription_message') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('subscription.pricing') }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('messages.choose_subscription_plan') }}
                    </a>
                </div>
            </div>
        @endif

        <!-- Subscription History -->
        @if($subscriptionHistory->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('messages.subscription_history') }}</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('messages.plan') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('messages.period') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('messages.amount') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('messages.status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($subscriptionHistory as $subscription)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $subscription->subscriptionPlan->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $subscription->subscriptionPlan->duration_text }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <div>{{ $subscription->starts_at->format('M j, Y') }}</div>
                                <div class="text-gray-500 dark:text-gray-400">to {{ $subscription->ends_at->format('M j, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ number_format($subscription->paid_amount, 0) }} BDT
                                </div>
                                @if($subscription->coupon_code)
                                <div class="text-xs text-green-600 dark:text-green-400">
                                    {{ __('messages.coupon') }}: {{ $subscription->coupon_code }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($subscription->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($subscription->status === 'expired') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($subscription->status === 'cancelled') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($subscription->payment)
                                <a href="{{ route('payment::payments.show', $subscription->payment->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ __('messages.view_payment') }}
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($subscriptionHistory->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $subscriptionHistory->links() }}
            </div>
            @endif
        </div>
        @endif

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