<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.subscription_success') }}</x-slot>
    
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Header -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/20 mb-4">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.subscription_activated') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('messages.subscription_success_message') }}</p>
            </div>

            <!-- Subscription Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600">
                    <h2 class="text-xl font-semibold text-white">{{ __('messages.subscription_details') }}</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Plan Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('messages.plan_information') }}</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.plan_name') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $subscription->subscriptionPlan->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.duration') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $subscription->subscriptionPlan->duration_text }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.amount_paid') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ number_format($subscription->paid_amount, 0) }} BDT</span>
                                </div>
                                @if($subscription->coupon_code)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.coupon_used') }}:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ $subscription->coupon_code }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Subscription Period -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('messages.subscription_period') }}</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.starts_at') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $subscription->starts_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.expires_at') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $subscription->ends_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.status') }}:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.days_remaining') }}:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $subscription->ends_at->diffInDays(now()) }} {{ __('messages.days') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Plan Features -->
                    @if($subscription->subscriptionPlan->getTranslation('features', app()->getLocale()))
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('messages.plan_features') }}</h3>
                        <div class="prose prose-sm max-w-none dark:prose-invert prose-ul:space-y-1 prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-li:marker:text-green-500">
                            {!! Str::markdown($subscription->subscriptionPlan->getTranslation('features', app()->getLocale())) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-3">{{ __('messages.whats_next') }}</h3>
                <ul class="space-y-2 text-blue-800 dark:text-blue-200">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('messages.access_premium_features') }}
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('messages.manage_subscription_account') }}
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('messages.receive_email_confirmation') }}
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v0H8v0z"></path>
                    </svg>
                    {{ __('messages.go_to_dashboard') }}
                </a>
                
                <a href="{{ route('subscription.pricing') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {{ __('messages.back_to_pricing') }}
                </a>
            </div>

            <!-- Support Information -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ __('messages.need_help') }} 
                    <a href="{{ route('contact.index') }}" class="text-blue-600 hover:text-blue-700">{{ __('messages.contact_support') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>