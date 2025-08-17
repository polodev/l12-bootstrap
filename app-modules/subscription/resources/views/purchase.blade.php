<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.purchase_subscription') }} - {{ $plan->name }}</x-slot>
    
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.purchase_subscription') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('messages.complete_payment_for') }} {{ $plan->name }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Purchase Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('messages.payment_details') }}</h2>
                        
                        <form id="purchaseForm" action="{{ route('subscription.process-purchase') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            
                            <!-- Payment Method Selection -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('messages.select_payment_method') }}
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input type="radio" name="payment_method" value="sslcommerz" class="sr-only" required>
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full mr-3 payment-radio"></div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">SSL Commerz</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.cards_mobile_banking') }}</div>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <label class="relative flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input type="radio" name="payment_method" value="bkash" class="sr-only">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full mr-3 payment-radio"></div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">bKash</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.mobile_payment') }}</div>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <label class="relative flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input type="radio" name="payment_method" value="nagad" class="sr-only">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full mr-3 payment-radio"></div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Nagad</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.mobile_payment') }}</div>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <label class="relative flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <input type="radio" name="payment_method" value="bank_transfer" class="sr-only">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 border-gray-300 dark:border-gray-600 rounded-full mr-3 payment-radio"></div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.bank_transfer') }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.direct_bank_transfer') }}</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Coupon Code -->
                            <div class="mb-6">
                                <label for="coupon_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.coupon_code') }} ({{ __('messages.optional') }})
                                </label>
                                <div class="flex">
                                    <input type="text" 
                                           id="coupon_code" 
                                           name="coupon_code" 
                                           class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="{{ __('messages.enter_coupon_code') }}">
                                    <button type="button" 
                                            id="applyCouponBtn"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        {{ __('messages.apply') }}
                                    </button>
                                </div>
                                <div id="couponMessage" class="mt-2 text-sm hidden"></div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start">
                                    <input type="checkbox" id="terms" required class="mt-1 mr-3 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('messages.agree_to') }} 
                                        <a href="#" class="text-blue-600 hover:text-blue-700">{{ __('messages.terms_conditions') }}</a>
                                        {{ __('messages.and') }}
                                        <a href="#" class="text-blue-600 hover:text-blue-700">{{ __('messages.privacy_policy') }}</a>
                                    </span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    id="purchaseBtn"
                                    class="w-full py-3 px-4 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="btnText">{{ __('messages.complete_purchase') }}</span>
                                <span id="btnLoader" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ __('messages.processing') }}...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.order_summary') }}</h3>
                        
                        <!-- Plan Details -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $plan->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $plan->duration_text }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ number_format($plan->price, 0) }} BDT</div>
                                    @if($plan->duration_months > 1)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($plan->price_per_month, 0) }} BDT/{{ __('messages.month') }}</div>
                                    @endif
                                </div>
                            </div>
                            @if($plan->getTranslation('features', app()->getLocale()))
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ __('messages.includes') }}:</p>
                                    <div class="prose prose-xs max-w-none dark:prose-invert prose-ul:space-y-1 prose-li:text-gray-600 dark:prose-li:text-gray-400 prose-li:marker:text-green-500">
                                        {!! Str::markdown($plan->getTranslation('features', app()->getLocale())) !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Pricing Breakdown -->
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.subtotal') }}</span>
                                <span id="originalAmount" class="text-gray-900 dark:text-white">{{ number_format($plan->price, 0) }} BDT</span>
                            </div>
                            <div id="discountRow" class="flex justify-between hidden">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.discount') }} (<span id="couponCodeDisplay"></span>)</span>
                                <span id="discountAmount" class="text-green-600">-0 BDT</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                                <div class="flex justify-between font-semibold text-lg">
                                    <span class="text-gray-900 dark:text-white">{{ __('messages.total') }}</span>
                                    <span id="finalAmount" class="text-gray-900 dark:text-white">{{ number_format($plan->price, 0) }} BDT</span>
                                </div>
                            </div>
                        </div>

                        @if($plan->duration_months > 1 && $plan->savings > 0)
                            <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-green-700 dark:text-green-300">
                                        {{ __('messages.save') }} {{ number_format($plan->savings, 0) }} BDT
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const paymentRadioElements = document.querySelectorAll('.payment-radio');
        
        paymentRadios.forEach((radio, index) => {
            radio.addEventListener('change', function() {
                paymentRadioElements.forEach(elem => {
                    elem.style.backgroundColor = 'transparent';
                    elem.style.borderColor = '';
                });
                
                if (this.checked) {
                    paymentRadioElements[index].style.backgroundColor = '#3B82F6';
                    paymentRadioElements[index].style.borderColor = '#3B82F6';
                }
            });
        });

        // Coupon application
        const applyCouponBtn = document.getElementById('applyCouponBtn');
        const couponInput = document.getElementById('coupon_code');
        const couponMessage = document.getElementById('couponMessage');
        
        applyCouponBtn.addEventListener('click', function() {
            const couponCode = couponInput.value.trim();
            if (!couponCode) {
                showCouponMessage('{{ __("messages.enter_coupon_code") }}', 'error');
                return;
            }

            applyCouponBtn.disabled = true;
            applyCouponBtn.textContent = '{{ __("messages.applying") }}...';

            fetch('{{ route("subscription.apply-coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    coupon_code: couponCode,
                    plan_id: {{ $plan->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCouponMessage(data.message, 'success');
                    updatePricing(data.data);
                } else {
                    showCouponMessage(data.message, 'error');
                }
            })
            .catch(error => {
                showCouponMessage('{{ __("messages.error_applying_coupon") }}', 'error');
                console.error('Error:', error);
            })
            .finally(() => {
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = '{{ __("messages.apply") }}';
            });
        });

        function showCouponMessage(message, type) {
            couponMessage.textContent = message;
            couponMessage.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600' : 'text-red-600'}`;
            couponMessage.classList.remove('hidden');
        }

        function updatePricing(data) {
            document.getElementById('discountRow').classList.remove('hidden');
            document.getElementById('couponCodeDisplay').textContent = data.coupon_code;
            document.getElementById('discountAmount').textContent = '-' + Math.round(data.discount_amount) + ' BDT';
            document.getElementById('finalAmount').textContent = data.formatted_final_amount;
        }

        // Form submission
        document.getElementById('purchaseForm').addEventListener('submit', function() {
            const purchaseBtn = document.getElementById('purchaseBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            
            purchaseBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
        });
    });
    </script>
    @endpush
</x-customer-frontend-layout::layout>