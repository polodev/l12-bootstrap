<x-customer-account-layout::layout>
    <x-slot name="title">{{ __('messages.payment_details') }} - #{{ $payment->id }}</x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.payment_details') }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Payment ID: #{{ $payment->id }}</p>
                </div>
                <a href="{{ route('accounts.payments') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.back_to_payments') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Information -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.payment_information') }}</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Status and Amount -->
                        <div class="flex items-center justify-between">
                            <div>
                                @php
                                    $statusColors = [
                                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }} capitalize">
                                    @if($payment->status === 'completed')
                                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($payment->status === 'pending')
                                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($payment->status === 'failed')
                                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    {{ $payment->status }}
                                </span>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($payment->amount, 0) }} {{ $payment->currency }}
                                </div>
                                @if($payment->discount_amount > 0)
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Original: {{ number_format($payment->original_amount ?? $payment->amount, 0) }} {{ $payment->currency }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.payment_method') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.payment_type') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white capitalize">{{ $payment->payment_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.created_at') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $payment->created_at->format('F j, Y \a\t g:i A') }}</dd>
                            </div>
                            @if($payment->updated_at->ne($payment->created_at))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.updated_at') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $payment->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                                </div>
                            @endif
                        </div>

                        @if($payment->coupon_code)
                            <!-- Coupon Information -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('messages.coupon_applied') }}</h3>
                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-green-800 dark:text-green-200">
                                                {{ $payment->coupon_code }}
                                            </div>
                                            <div class="text-xs text-green-600 dark:text-green-400">
                                                Discount: {{ number_format($payment->discount_amount, 0) }} {{ $payment->currency }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($payment->description)
                            <!-- Description -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.description') }}</dt>
                                <dd class="mt-2 text-sm text-gray-900 dark:text-white">{{ $payment->description }}</dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Subscription Details (if applicable) -->
            <div class="lg:col-span-1">
                @if($payment->subscriptionPlan)
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.subscription_details') }}</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.plan') }}</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $payment->subscriptionPlan->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.duration') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $payment->subscriptionPlan->duration_text }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.plan_price') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($payment->subscriptionPlan->price, 0) }} BDT</dd>
                            </div>
                            @if($payment->subscriptionPlan->getTranslation('features', app()->getLocale()))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('messages.features_included') }}</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white prose prose-sm max-w-none dark:prose-invert prose-ul:space-y-1 prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-li:marker:text-blue-500">
                                        {!! Str::markdown($payment->subscriptionPlan->getTranslation('features', app()->getLocale())) !!}
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Customer Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.customer_information') }}</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.name') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $payment->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.email') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $payment->email }}</dd>
                        </div>
                        @if($payment->mobile)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.mobile') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $payment->mobile }}</dd>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.quick_actions') }}</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($payment->status === 'completed')
                            <a href="{{ route('accounts.subscription') }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('messages.view_subscription') }}
                            </a>
                        @endif
                        <a href="{{ route('accounts.support') }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                            {{ __('messages.contact_support') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-account-layout::layout>