<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 text-center">
                <!-- Error Icon -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 mb-4">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                <!-- Error Message -->
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.payment_failed') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('messages.payment_failed_message') }}</p>

                <!-- Payment Details -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.attempted_amount') }}:</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($payment->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.payment_id') }}:</span>
                            <span class="font-mono text-gray-900 dark:text-gray-100">#{{ $payment->id }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.status') }}:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                {{ __('messages.failed') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <a href="{{ route('payment::payments.show', $payment->id) }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('messages.try_again') }}
                    </a>
                    <a href="/" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('messages.back_to_home') }}
                    </a>
                </div>

                <!-- Help Section -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('messages.payment_help_text') }}
                        <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.contact_support') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>