<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.complete_payment') }}</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.payment_page_description') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <div class="lg:col-span-3 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">{{ __('messages.payment_details') }}</h2>
                    
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-blue-900 dark:text-blue-100">{{ __('messages.amount_to_pay') }}</span>
                            <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">৳{{ number_format($payment->amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Payment Link Sharing Section -->
                    <div class="mb-6 flex items-center space-x-2 p-3 bg-gray-50 dark:bg-gray-900/50 rounded border border-gray-200 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ __('messages.payment_link') }}:</span>
                        <input type="text" 
                               id="payment-link"
                               value="{{ route('payment::payments.show', $payment->id) }}" 
                               readonly
                               class="flex-1 px-2 py-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded text-xs text-gray-900 dark:text-gray-100 font-mono">
                        <button type="button"
                                id="copy-payment-link"
                                onclick="copyPaymentLink()"
                                class="inline-flex items-center p-1.5 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ __('messages.customer_information') }}
                        </h3>
                        
                        @if($payment->payment_type === 'custom_payment')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.full_name') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->name }}</p>
                                </div>
                                @if($payment->email_address)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.email_address') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->email_address }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.mobile_number') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->mobile }}</p>
                                </div>
                                @if($payment->purpose)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.purpose') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->purpose }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.reference') }}</label>
                                    <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">PAY-{{ $payment->id }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.payment_status') }}</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($payment->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($payment->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                            @endif">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.payment_method') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $payment->payment_method }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.payment_id') }}</label>
                                    <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">#{{ $payment->id }}</p>
                                </div>
                                @if($payment->payment_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.date_time') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->payment_date->format('M d, Y h:i A') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 h-fit">
                    @if($payment->status === 'pending')
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.payment_method') }}</h3>
                            
                            <!-- Consent and Payment Card -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg border-2 border-gray-200 dark:border-gray-700 p-6 mb-4">
                                <!-- Consent Text -->
                                <div class="mb-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex items-center h-5">
                                            <input id="payment-consent" 
                                                   type="checkbox" 
                                                   checked
                                                   class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 dark:border-gray-500 rounded">
                                        </div>
                                        <div class="text-sm">
                                            <label for="payment-consent" class="text-gray-700 dark:text-gray-300 font-medium">
                                                By clicking the payment button below, you agree to our 
                                                <a href="{{ route('page::pages.show', 'privacy-policy') }}" 
                                                   target="_blank" 
                                                   class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.privacy_policy') }}</a>, 
                                                <a href="{{ route('page::pages.show', 'terms-of-service') }}" 
                                                   target="_blank" 
                                                   class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.terms_of_service') }}</a>, and 
                                                <a href="{{ route('page::pages.show', 'refund-policy') }}" 
                                                   target="_blank" 
                                                   class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.refund_policy') }}</a>.
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Separator Line -->
                                <div class="border-t border-gray-300 dark:border-gray-600 my-4"></div>

                                <!-- Payment Form -->
                                <form action="{{ route('payment::payments.process', $payment) }}" method="POST" id="payment-form">
                                    @csrf
                                    <button type="submit" 
                                            id="payment-submit-btn"
                                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 cursor-pointer transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Pay with SSLCommerz
                                    </button>
                                </form>
                            </div>

                            <!-- Gateway Fee Display Cards -->
                            <div class="mb-6 space-y-2">
                                <!-- SSLCommerz Regular Fee -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded px-3 py-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-blue-700 dark:text-blue-300">SSLCommerz Regular ({{ config('global.sslcommerz_payment_gateway_charge', 2.00) }}%)</span>
                                        <span class="text-sm font-medium text-blue-800 dark:text-blue-200">৳{{ number_format($sslcommerzCalculation['regular_total'], 2) }}</span>
                                    </div>
                                    <div class="text-xs text-blue-600 dark:text-blue-400">Fee: ৳{{ number_format($sslcommerzCalculation['regular_fee'], 2) }}</div>
                                </div>
                                
                                <!-- SSLCommerz Premium Fee -->
                                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded px-3 py-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-purple-700 dark:text-purple-300">SSLCommerz Premium Cards ({{ config('global.sslcommerz_payment_gateway_charge_for_premium_card', 3.00) }}%)</span>
                                        <span class="text-sm font-medium text-purple-800 dark:text-purple-200">৳{{ number_format($sslcommerzCalculation['premium_total'], 2) }}</span>
                                    </div>
                                    <div class="text-xs text-purple-600 dark:text-purple-400">Fee: ৳{{ number_format($sslcommerzCalculation['premium_fee'], 2) }}</div>
                                    @php
                                        $premiumCards = ['American Express', 'City Visa Platinum'];
                                    @endphp
                                    <div class="text-xs text-purple-500 dark:text-purple-400 mt-1 leading-tight">
                                        {{ implode(', ', $premiumCards) }}
                                    </div>
                                </div>
                                
                                <!-- bKash Fee - Temporarily commented out until bKash integration -->
                                {{-- <div class="bg-pink-50 dark:bg-pink-900/20 border border-pink-200 dark:border-pink-800 rounded px-3 py-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-pink-700 dark:text-pink-300">bKash ({{ $gatewayCharges['bkash'] ?? 1.5 }}%)</span>
                                        <span class="text-sm font-medium text-pink-800 dark:text-pink-200">৳{{ number_format($bkashCalculation['total'], 2) }}</span>
                                    </div>
                                    <div class="text-xs text-pink-600 dark:text-pink-400">Fee: ৳{{ number_format($bkashCalculation['fee'], 2) }}</div>
                                </div> --}}
                            </div>

                            <!-- SSLCommerz Info (Hidden on Mobile) -->
                            <div class="hidden md:block mb-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                <div class="flex items-center justify-center mb-2">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-green-900 dark:text-green-100">SSLCommerz</h4>
                                <p class="text-sm text-green-700 dark:text-green-300 mt-1">{{ __('messages.ssl_commerz_description') }}</p>
                            </div>

                            <div class="mt-6">
                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('messages.supported_methods') }}</h5>
                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        {{ __('messages.payment_cards') }}
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        {{ __('messages.payment_mobile_banking') }}
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                        {{ __('messages.payment_net_banking') }}
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                                        {{ __('messages.payment_wallets') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="mb-4">
                                @if($payment->status === 'completed')
                                    <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-lg font-medium {{ $payment->status === 'completed' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mb-2">
                                {{ $payment->status === 'completed' ? __('messages.payment_successful') : ($payment->status === 'failed' ? __('messages.payment_failed') : __('messages.payment_cancelled')) }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                {{ $payment->status === 'completed' ? __('messages.payment_success_message') : ($payment->status === 'failed' ? __('messages.payment_failed_message') : __('messages.payment_cancelled_message')) }}
                            </p>
                            
                            @if($payment->status !== 'completed')
                                <!-- Retry Consent and Payment Card -->
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg border-2 border-gray-200 dark:border-gray-700 p-6">
                                    <!-- Consent Text for retry -->
                                    <div class="mb-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex items-center h-5">
                                                <input id="retry-payment-consent" 
                                                       type="checkbox" 
                                                       checked
                                                       class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 dark:border-gray-500 rounded">
                                            </div>
                                            <div class="text-sm">
                                                <label for="retry-payment-consent" class="text-gray-700 dark:text-gray-300 font-medium">
                                                    By clicking the retry button below, you agree to our 
                                                    <a href="{{ route('page::pages.show', 'privacy-policy') }}" 
                                                       target="_blank" 
                                                       class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.privacy_policy') }}</a>, 
                                                    <a href="{{ route('page::pages.show', 'terms-of-service') }}" 
                                                       target="_blank" 
                                                       class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.terms_of_service') }}</a>, and 
                                                    <a href="{{ route('page::pages.show', 'refund-policy') }}" 
                                                       target="_blank" 
                                                       class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.refund_policy') }}</a>.
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Separator Line -->
                                    <div class="border-t border-gray-300 dark:border-gray-600 my-4"></div>
                                    
                                    <!-- Retry Payment Form -->
                                    <form action="{{ route('payment::payments.process', $payment) }}" method="POST" id="retry-payment-form">
                                        @csrf
                                        <button type="submit" 
                                                id="retry-payment-btn"
                                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 cursor-pointer transition-colors">
                                            {{ __('messages.try_again') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                            
                        </div>
                    @endif

                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('messages.payment_security_notice') }}
                        </p>
                    </div>
                </div>
            </div>

            @if($payment->status !== 'completed')
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.payment_help_text') }} 
                    <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.contact_customer_care') }}</a>
                </p>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
    // Payment consent validation
    document.addEventListener('DOMContentLoaded', function() {
        const paymentConsent = document.getElementById('payment-consent');
        const paymentSubmitBtn = document.getElementById('payment-submit-btn');
        const retryPaymentConsent = document.getElementById('retry-payment-consent');
        const retryPaymentBtn = document.getElementById('retry-payment-btn');
        
        // Handle main payment form validation
        if (paymentConsent && paymentSubmitBtn) {
            paymentConsent.addEventListener('change', function() {
                if (this.checked) {
                    paymentSubmitBtn.disabled = false;
                    paymentSubmitBtn.classList.remove('bg-green-100', 'dark:bg-green-900/30', 'text-green-700', 'dark:text-green-300', 'border-green-300', 'dark:border-green-600', 'cursor-not-allowed');
                    paymentSubmitBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'text-white', 'border-transparent', 'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-green-500', 'cursor-pointer');
                } else {
                    paymentSubmitBtn.disabled = true;
                    paymentSubmitBtn.classList.add('bg-green-100', 'dark:bg-green-900/30', 'text-green-700', 'dark:text-green-300', 'border-green-300', 'dark:border-green-600', 'cursor-not-allowed');
                    paymentSubmitBtn.classList.remove('bg-green-600', 'hover:bg-green-700', 'text-white', 'border-transparent', 'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-green-500', 'cursor-pointer');
                }
            });
        }
        
        // Handle retry payment form validation
        if (retryPaymentConsent && retryPaymentBtn) {
            retryPaymentConsent.addEventListener('change', function() {
                if (this.checked) {
                    retryPaymentBtn.disabled = false;
                    retryPaymentBtn.classList.remove('bg-green-100', 'dark:bg-green-900/30', 'text-green-700', 'dark:text-green-300', 'border-green-300', 'dark:border-green-600', 'cursor-not-allowed');
                    retryPaymentBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'text-white', 'border-transparent', 'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-green-500', 'cursor-pointer');
                } else {
                    retryPaymentBtn.disabled = true;
                    retryPaymentBtn.classList.add('bg-green-100', 'dark:bg-green-900/30', 'text-green-700', 'dark:text-green-300', 'border-green-300', 'dark:border-green-600', 'cursor-not-allowed');
                    retryPaymentBtn.classList.remove('bg-green-600', 'hover:bg-green-700', 'text-white', 'border-transparent', 'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-green-500', 'cursor-pointer');
                }
            });
        }
    });
    
    function copyPaymentLink() {
        const linkInput = document.getElementById('payment-link');
        const copyButton = document.getElementById('copy-payment-link');
        
        // Select and copy the text
        linkInput.select();
        linkInput.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            document.execCommand('copy');
            
            // Update button appearance temporarily
            const originalHTML = copyButton.innerHTML;
            copyButton.innerHTML = `
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            `;
            copyButton.classList.add('text-green-600', 'border-green-300');
            copyButton.classList.remove('text-gray-700', 'dark:text-gray-300', 'border-gray-300', 'dark:border-gray-600');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                copyButton.innerHTML = originalHTML;
                copyButton.classList.remove('text-green-600', 'border-green-300');
                copyButton.classList.add('text-gray-700', 'dark:text-gray-300', 'border-gray-300', 'dark:border-gray-600');
            }, 2000);
            
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
        
        // Deselect the text
        linkInput.blur();
    }
    </script>
    @endpush
</x-customer-frontend-layout::layout>