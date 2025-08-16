<x-customer-frontend-layout::layout>
    @push('head')
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    @endpush
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mobile Header -->
            <div class="lg:hidden mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.custom_payment') }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.custom_payment_description') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Payment Form - Shows first on mobile -->
                <div class="order-1 lg:order-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <form action="{{ route('payment::custom-payment.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Payment Method Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            {{ __('messages.payment_method') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 gap-2">
                            <!-- Online Payment (SSLCommerz) -->
                            <label class="relative flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 @error('payment_method') border-red-500 @enderror">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="sslcommerz" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2" 
                                       {{ old('payment_method', 'sslcommerz') === 'sslcommerz' ? 'checked' : '' }}
                                       onchange="updatePaymentMethod()">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.online_payment_sslcommerz') }}</div>
                                        <div class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ __('messages.online') }}
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ __('messages.cards_mobile_banking') }}
                                    </div>
                                </div>
                            </label>

                            <!-- Manual Payment -->
                            <label class="relative flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="manual_payment" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2"
                                       {{ old('payment_method') === 'manual_payment' ? 'checked' : '' }}
                                       onchange="updatePaymentMethod()">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.manual_payment') }}</div>
                                        <div class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ __('messages.manual') }}
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ __('messages.bank_transfer_deposit_bkash') }}
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($errors->any())
                        <!-- Error Messages -->
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('messages.please_fix_errors') }}:</h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Amount Field -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.amount') }} (৳) <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">৳</span>
                            </div>
                            <input type="number" 
                                   name="amount" 
                                   id="amount" 
                                   step="0.01" 
                                   min="100"
                                   value="{{ old('amount') }}"
                                   class="block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('amount') border-red-500 @enderror"
                                   placeholder="100.00"
                                   required>
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        
                        <!-- Payment Gateway Fees Display -->
                        <div id="gateway-fees" class="mt-2 space-y-1 text-xs" style="display: none;">
                            <!-- SSLCommerz Regular Card Fee -->
                            <div id="sslcommerz-regular-fee" class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded px-2 py-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-700 dark:text-blue-300">SSLCommerz Regular ({{ $gatewayCharges['sslcommerz_regular'] ?? 2.00 }}%)</span>
                                    <span class="font-medium text-blue-800 dark:text-blue-200">৳<span id="sslcommerz-regular-total">0.00</span></span>
                                </div>
                                <div class="text-blue-600 dark:text-blue-400">Fee: ৳<span id="sslcommerz-regular-fee-amount">0.00</span></div>
                            </div>
                            
                            <!-- SSLCommerz Premium Card Fee -->
                            <div id="sslcommerz-premium-fee" class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded px-2 py-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-purple-700 dark:text-purple-300">SSLCommerz Premium Cards ({{ $gatewayCharges['sslcommerz_premium'] ?? 3.00 }}%)</span>
                                    <span class="font-medium text-purple-800 dark:text-purple-200">৳<span id="sslcommerz-premium-total">0.00</span></span>
                                </div>
                                <div class="text-purple-600 dark:text-purple-400">Fee: ৳<span id="sslcommerz-premium-fee-amount">0.00</span></div>
                                @php
                                    $premiumCards = ['American Express', 'City Visa Platinum'];
                                @endphp
                                <div class="text-xs text-purple-500 dark:text-purple-400 mt-1 leading-tight">
                                    {{ implode(', ', $premiumCards) }}
                                </div>
                            </div>
                            
                            <!-- bKash Fee - Temporarily commented out until bKash integration -->
                            {{-- <div id="bkash-fee" class="bg-pink-50 dark:bg-pink-900/20 border border-pink-200 dark:border-pink-800 rounded px-2 py-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-pink-700 dark:text-pink-300">bKash (<span id="bkash-rate">{{ $gatewayCharges['bkash'] ?? 1.5 }}</span>%)</span>
                                    <span class="font-medium text-pink-800 dark:text-pink-200">৳<span id="bkash-total">0.00</span></span>
                                </div>
                                <div class="text-pink-600 dark:text-pink-400">Fee: ৳<span id="bkash-fee-amount">0.00</span></div>
                            </div> --}}
                        </div>
                    </div>

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.full_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="{{ __('messages.enter_full_name') }}"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mobile Field -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.mobile_number') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               name="mobile" 
                               id="mobile" 
                               value="{{ old('mobile') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mobile') border-red-500 @enderror"
                               placeholder="{{ __('messages.enter_mobile') }}"
                               required>
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.email_address') }}
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="{{ __('messages.enter_email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Purpose Field (Optional) -->
                    <div>
                        <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.payment_purpose') }}
                        </label>
                        <textarea name="purpose" 
                                  id="purpose" 
                                  rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('purpose') border-red-500 @enderror"
                                  placeholder="{{ __('messages.enter_payment_purpose') }}">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- reCAPTCHA -->
                    @if(env('RECAPTCHA_ENABLED', false))
                    <div>
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        @error('recaptcha')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('messages.proceed_to_payment') }}
                        </button>
                    </div>

                    <!-- Security Notice -->
                    <div class="text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('messages.secure_payment_notice') }}
                        </p>
                    </div>
                </form>
                </div>

                <!-- Information Section - Shows second on mobile, first on desktop -->
                <div class="order-2 lg:order-1 lg:pr-8">
                    <div class="sticky top-8">
                        <!-- Desktop Header (hidden on mobile) -->
                        <div class="hidden lg:block">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.custom_payment') }}</h1>
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">{{ __('messages.custom_payment_description') }}</p>
                        </div>
                        
                        <!-- Features -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.secure_payment_notice') }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">256-bit SSL encryption protects your data</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Instant Processing</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Payments are processed immediately</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Multiple Payment Methods</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Cards, mobile banking & more</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Help Section -->
                        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">{{ __('messages.need_help') }}</h4>
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                {{ __('messages.contact_support') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @if(env('RECAPTCHA_ENABLED', false))
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    
    <!-- Amount Validation and Gateway Fee Calculation Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const form = amountInput.closest('form');
        const gatewayFeesContainer = document.getElementById('gateway-fees');
        
        // Gateway fee settings (controlled by payment method selection)
        let showSSLCommerz = false; // Will be enabled based on payment method selection
        let showBkash = false; // Temporarily disabled until bKash integration
        
        // Gateway charges from controller
        const gatewayCharges = @json($gatewayCharges ?? ['sslcommerz_regular' => 2.00, 'sslcommerz_premium' => 3.00, 'bkash' => 1.5]);
        
        // Number formatting function
        function formatNumber(num) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(num);
        }
        
        // Payment gateway calculation functions
        function calculateSSLCommerzRegularFee(amount) {
            const feePercentage = gatewayCharges.sslcommerz_regular;
            const fee = (amount * feePercentage) / 100;
            return {
                fee: Math.round(fee * 100) / 100,
                total: Math.round((amount + fee) * 100) / 100
            };
        }
        
        function calculateSSLCommerzPremiumFee(amount) {
            const feePercentage = gatewayCharges.sslcommerz_premium;
            const fee = (amount * feePercentage) / 100;
            return {
                fee: Math.round(fee * 100) / 100,
                total: Math.round((amount + fee) * 100) / 100
            };
        }
        
        function calculateBkashFee(amount) {
            const feePercentage = gatewayCharges.bkash;
            const fee = (amount * feePercentage) / 100;
            return {
                fee: Math.round(fee * 100) / 100,
                total: Math.round((amount + fee) * 100) / 100
            };
        }
        
        // Update gateway fees display
        function updateGatewayFees() {
            const amount = parseFloat(amountInput.value);
            
            if (!amount || amount < 100) {
                gatewayFeesContainer.style.display = 'none';
                return;
            }
            
            // Show/hide gateway fee cards based on settings
            const sslcommerzRegularElement = document.getElementById('sslcommerz-regular-fee');
            const sslcommerzPremiumElement = document.getElementById('sslcommerz-premium-fee');
            const bkashElement = document.getElementById('bkash-fee');
            
            if (sslcommerzRegularElement) {
                sslcommerzRegularElement.style.display = showSSLCommerz ? 'block' : 'none';
            }
            if (sslcommerzPremiumElement) {
                sslcommerzPremiumElement.style.display = showSSLCommerz ? 'block' : 'none';
            }
            if (bkashElement) {
                bkashElement.style.display = showBkash ? 'block' : 'none';
            }
            
            // Calculate and display SSLCommerz Regular fee
            if (showSSLCommerz && sslcommerzRegularElement) {
                const sslRegularData = calculateSSLCommerzRegularFee(amount);
                const feeAmountElement = document.getElementById('sslcommerz-regular-fee-amount');
                const totalElement = document.getElementById('sslcommerz-regular-total');
                
                if (feeAmountElement) feeAmountElement.textContent = formatNumber(sslRegularData.fee);
                if (totalElement) totalElement.textContent = formatNumber(sslRegularData.total);
            }
            
            // Calculate and display SSLCommerz Premium fee
            if (showSSLCommerz && sslcommerzPremiumElement) {
                const sslPremiumData = calculateSSLCommerzPremiumFee(amount);
                const feeAmountElement = document.getElementById('sslcommerz-premium-fee-amount');
                const totalElement = document.getElementById('sslcommerz-premium-total');
                
                if (feeAmountElement) feeAmountElement.textContent = formatNumber(sslPremiumData.fee);
                if (totalElement) totalElement.textContent = formatNumber(sslPremiumData.total);
            }
            
            // Calculate and display bKash fee - Temporarily commented out until bKash integration
            /*
            if (showBkash) {
                const bkashData = calculateBkashFee(amount);
                document.getElementById('bkash-fee-amount').textContent = formatNumber(bkashData.fee);
                document.getElementById('bkash-total').textContent = formatNumber(bkashData.total);
            }
            */
            
            // Show the container if any gateway is enabled
            if (showSSLCommerz || showBkash) {
                gatewayFeesContainer.style.display = 'block';
            } else {
                gatewayFeesContainer.style.display = 'none';
            }
        }
        
        // Real-time validation and fee calculation
        amountInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            const errorElement = this.parentElement.parentElement.querySelector('.text-red-600, .text-red-400');
            
            // Validation logic
            if (value < 100 && this.value !== '') {
                this.classList.add('border-red-500');
                this.classList.remove('border-gray-300', 'dark:border-gray-600');
                
                if (!errorElement) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'mt-1 text-sm text-red-600 dark:text-red-400';
                    errorMsg.textContent = '{{ __("messages.amount_minimum_required") }}';
                    this.parentElement.parentElement.appendChild(errorMsg);
                }
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300', 'dark:border-gray-600');
                
                if (errorElement && !errorElement.hasAttribute('data-server-error')) {
                    errorElement.remove();
                }
            }
            
            // Update gateway fees
            updateGatewayFees();
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            const value = parseFloat(amountInput.value);
            
            if (value < 100) {
                e.preventDefault();
                amountInput.focus();
                
                const errorElement = amountInput.parentElement.parentElement.querySelector('.text-red-600, .text-red-400');
                if (!errorElement) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'mt-1 text-sm text-red-600 dark:text-red-400';
                    errorMsg.textContent = '{{ __("messages.amount_minimum_required") }}';
                    amountInput.parentElement.parentElement.appendChild(errorMsg);
                }
                
                amountInput.classList.add('border-red-500');
                return false;
            }
        });
        
        // Mark server errors so they don't get removed by JS
        const existingError = amountInput.parentElement.parentElement.querySelector('.text-red-600, .text-red-400');
        if (existingError) {
            existingError.setAttribute('data-server-error', 'true');
        }
        
        // Payment method change handler
        window.updatePaymentMethod = function() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
            
            // Show SSLCommerz fees only when SSLCommerz is selected
            showSSLCommerz = (selectedMethod === 'sslcommerz');
            showBkash = false; // Keep disabled for now
            
            // Update gateway fees display
            updateGatewayFees();
        };
        
        // Expose toggle functions globally for easy control
        window.toggleSSLCommerz = function(show) {
            showSSLCommerz = show;
            updateGatewayFees();
        };
        
        window.toggleBkash = function(show) {
            showBkash = show;
            updateGatewayFees();
        };
        
        // Initialize payment method on page load
        updatePaymentMethod();
        
        // Initial calculation if amount is already filled
        if (amountInput.value) {
            updateGatewayFees();
        }
    });
    </script>
    @endpush
</x-customer-frontend-layout::layout>