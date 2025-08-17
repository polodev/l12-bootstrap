<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.pricing') }} - Laravel 12 Bootstrap</x-slot>
    <x-slot name="meta_description">Choose the perfect Pro subscription plan that fits your needs. Monthly, quarterly, semi-annual, and annual plans available.</x-slot>

    <!-- Pricing Hero Section -->
    <section class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Choose Your Pro Plan
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto">
                Unlock advanced features and take your projects to the next level with our Pro subscription plans.
            </p>
            
            @if($userSubscription)
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 max-w-md mx-auto mb-8">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-green-800 dark:text-green-200 font-medium">
                            Active: {{ $userSubscription->subscriptionPlan->name }}
                        </span>
                    </div>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                        Expires {{ $userSubscription->ends_at->format('M j, Y') }}
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($plans as $plan)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center relative {{ $plan->duration_months == 12 ? 'ring-2 ring-blue-500 scale-105' : '' }}">
                        
                        @if($plan->duration_months == 12)
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-medium">
                                    Most Popular
                                </span>
                            </div>
                        @endif

                        @if($plan->savings_percentage)
                            <div class="absolute -top-4 right-4">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Save {{ $plan->savings_percentage }}%
                                </span>
                            </div>
                        @endif

                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $plan->name }}
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            {{ $plan->description }}
                        </p>

                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($plan->price, 0) }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">BDT</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $plan->duration_text }}
                            </p>
                            @if($plan->duration_months > 1)
                                <p class="text-sm text-green-600 dark:text-green-400">
                                    {{ number_format($plan->price_per_month, 0) }} BDT/month
                                </p>
                            @endif
                        </div>

                        @if($plan->getTranslation('features', app()->getLocale()))
                            <div class="text-left mb-8 prose prose-sm max-w-none dark:prose-invert prose-ul:space-y-2 prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-li:marker:text-green-500">
                                {!! Str::markdown($plan->getTranslation('features', app()->getLocale())) !!}
                            </div>
                        @endif

                        @if($userSubscription)
                            @if($userSubscription->subscription_plan_id == $plan->id)
                                <button class="w-full bg-green-500 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed" disabled>
                                    Current Plan
                                </button>
                            @else
                                <button class="w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-3 px-6 rounded-lg font-semibold cursor-not-allowed" disabled>
                                    Upgrade Available Soon
                                </button>
                            @endif
                        @else
                            @auth
                                <a href="{{ route('subscription.purchase', $plan) }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors inline-block">
                                    Choose Plan
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors inline-block">
                                    Login to Purchase
                                </a>
                            @endauth
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    What's Included in Pro
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    All Pro plans include these powerful features
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Advanced Features</h3>
                    <p class="text-gray-600 dark:text-gray-400">Access to all premium functionality and tools</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Priority Support</h3>
                    <p class="text-gray-600 dark:text-gray-400">Get help when you need it with priority assistance</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-400">Detailed insights and reporting capabilities</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-900 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Can I change my plan later?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Currently, you can purchase a new subscription when your current one expires. Plan upgrades/downgrades during active subscriptions will be available soon.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Do you offer refunds?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        We offer a 7-day money-back guarantee for all new subscriptions. Contact support if you're not satisfied.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Can I use coupon codes?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Yes! You can apply coupon codes during checkout to get discounts on your subscription.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        What payment methods do you accept?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        We accept SSL Commerz, bKash, Nagad, and bank transfers for your convenience.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-customer-frontend-layout::layout>