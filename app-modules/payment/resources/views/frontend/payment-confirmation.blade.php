<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Status Header -->
            <div class="text-center mb-8">
                <div class="mb-6">
                    @if($payment->status === 'completed')
                        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">{{ __('messages.payment_successful') }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.payment_success_message') }}</p>
                    @elseif($payment->status === 'failed')
                        <div class="w-20 h-20 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-red-600 dark:text-red-400 mb-2">{{ __('messages.payment_failed') }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.payment_failed_message') }}</p>
                    @elseif($payment->status === 'canceled')
                        <div class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-2">{{ __('messages.payment_cancelled') }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.payment_cancelled_message') }}</p>
                    @else
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-600 dark:text-gray-400 mb-2">Payment {{ ucfirst($payment->status) }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">Your payment is currently {{ $payment->status }}.</p>
                    @endif
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 mb-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.payment_details') }}</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Payment Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.amount_paid') }}</label>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">৳{{ number_format($payment->amount, 2) }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.payment_id') }}</label>
                            <div class="text-lg font-mono text-gray-900 dark:text-gray-100">#{{ $payment->id }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.payment_method') }}</label>
                            <div class="text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $payment->payment_method }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.date_time') }}</label>
                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $payment->payment_date ? $payment->payment_date->format('M d, Y h:i A') : $payment->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                        @if($payment->gateway_transaction_id)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction ID</label>
                            <div class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ $payment->gateway_transaction_id }}</div>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.status') }}</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($payment->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($payment->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @elseif($payment->status === 'canceled') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    @if($payment->payment_type === 'custom_payment')
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.customer_information') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.full_name') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->name }}</p>
                                </div>
                                @if($payment->email)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.email_address') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->email }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.mobile_number') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->mobile }}</p>
                                </div>
                                @if($payment->purpose)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.purpose') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->purpose }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.reference') }}</label>
                                    <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">PAY-{{ $payment->id }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4">
                @if($payment->status === 'completed')
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="window.print()" 
                                class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            {{ __('messages.print_receipt') }}
                        </button>
                    </div>
                @elseif($payment->status === 'failed' || $payment->status === 'canceled')
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('payment::payments.show', $payment) }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ __('messages.try_again') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Support Section -->
            <div class="mt-12 text-center">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
                    <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-2">{{ __('messages.need_help') }}</h3>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mb-4">
                        {{ __('messages.payment_help_text') }}
                    </p>
                    <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('messages.contact_customer_care') }}
                    </a>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    {{ __('messages.payment_security_notice') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .dark\:bg-gray-800,
            .dark\:bg-gray-900 {
                background: white !important;
            }
            .dark\:text-gray-100,
            .dark\:text-gray-300 {
                color: black !important;
            }
        }
    </style>
</x-customer-frontend-layout::layout>