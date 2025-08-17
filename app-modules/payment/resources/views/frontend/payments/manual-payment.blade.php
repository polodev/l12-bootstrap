<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.manual_payment') }}</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.manual_payment_description') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Payment Form -->
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

                    @if($payment->status === 'pending')
                        <!-- Manual Payment Form -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('messages.complete_manual_payment') }}
                            </h3>
                            
                            @if($errors->any())
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

                            <form action="{{ route('payment::payments.submit-manual', $payment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                
                                <!-- Bank/MFS Name -->
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.bank_mfs_name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="bank_name" 
                                           id="bank_name" 
                                           value="{{ old('bank_name') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('bank_name') border-red-500 @enderror"
                                           placeholder="{{ __('messages.bank_mfs_placeholder') }}"
                                           required>
                                    @error('bank_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.additional_details_message') }}
                                    </label>
                                    <textarea name="notes" 
                                              id="notes" 
                                              rows="3"
                                              class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                                              placeholder="{{ __('messages.additional_details_placeholder') }}">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Attachment -->
                                <div>
                                    <label for="payment_attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.payment_attachment') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" 
                                           id="payment_attachment"
                                           name="payment_attachment"
                                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,application/pdf"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                           required>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.payment_attachment_description') }}</p>
                                    @error('payment_attachment')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <button type="submit" 
                                            id="submit-button"
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        {{ __('messages.submit_payment_proof') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <!-- Payment Status and Details -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('messages.payment_status') }}
                            </h3>
                            
                            <!-- Payment Status Badge -->
                            <div class="mb-6">
                                @php
                                $statusClasses = [
                                    'processing' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                    'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                                    'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300',
                                    'refunded' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300'
                                ];
                                $statusClass = $statusClasses[$payment->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                                    @if($payment->status === 'processing')
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ __('messages.payment_under_review') }}
                                    @elseif($payment->status === 'completed')
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ __('messages.payment_completed') }}
                                    @elseif($payment->status === 'failed')
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        {{ __('messages.payment_failed') }}
                                    @else
                                        {{ ucfirst($payment->status) }}
                                    @endif
                                </span>
                            </div>

                            <!-- Submitted Payment Details -->
                            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4 space-y-4">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ __('messages.submitted_payment_details') }}</h4>
                                
                                @if($payment->bank_name)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.bank_mfs_name') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->bank_name }}</p>
                                </div>
                                @endif

                                @if($payment->notes)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.additional_details') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->notes }}</p>
                                </div>
                                @endif

                                @if($payment->processed_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.processed_at') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->processed_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                                @endif

                                @if($payment->receipt_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.receipt_number') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $payment->receipt_number }}</p>
                                </div>
                                @endif

                                <!-- Payment Attachments -->
                                @if($payment->getMedia('payment_attachment')->count() > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.submitted_attachment') }}</label>
                                    @foreach($payment->getMedia('payment_attachment') as $attachment)
                                        <div class="flex items-center space-x-2 p-2 bg-white dark:bg-gray-700 rounded border">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <a href="{{ $attachment->getUrl() }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                                {{ $attachment->name }} ({{ $attachment->human_readable_size }})
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            @if($payment->status === 'processing')
                                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                            {{ __('messages.payment_under_review_message') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Customer Information -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                            {{ __('messages.customer_information') }}
                        </h3>
                        
                        @if($payment->payment_type === 'custom_payment')
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
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.payment_purpose') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->purpose }}</p>
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Information Sidebar -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 h-fit">
                    <!-- Instructions -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('messages.payment_instructions') }}
                        </h3>
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">1</div>
                                <p>{{ __('messages.manual_payment_step_1') }}</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">2</div>
                                <p>{{ __('messages.manual_payment_step_2') }}</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-xs font-semibold mr-3 mt-0.5">3</div>
                                <p>{{ __('messages.manual_payment_step_3') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-green-900 dark:text-green-100 mb-2">
                            {{ __('messages.need_help') }}
                        </h4>
                        <p class="text-sm text-green-700 dark:text-green-300">
                            {{ __('messages.contact_support') }}
                        </p>
                    </div>

                    <!-- Security Note -->
                    <div class="mt-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-yellow-900 dark:text-yellow-100 mb-2">
                            {{ __('messages.verification_notice') }}
                        </h4>
                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                            {{ __('messages.manual_verification_message') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function copyPaymentLink() {
        const paymentLinkInput = document.getElementById('payment-link');
        paymentLinkInput.select();
        paymentLinkInput.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            document.execCommand('copy');
            const button = document.getElementById('copy-payment-link');
            const originalHTML = button.innerHTML;
            
            button.innerHTML = `
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            `;
            
            setTimeout(() => {
                button.innerHTML = originalHTML;
            }, 2000);
        } catch (err) {
            console.error('Copy failed', err);
        }
    }
    
    // Simple form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const bankNameInput = document.getElementById('bank_name');
        const fileInput = document.getElementById('payment_attachment');
        
        // Validate bank name
        if (!bankNameInput.value.trim()) {
            e.preventDefault();
            alert('{{ __("messages.bank_name_required") }}');
            bankNameInput.focus();
            return false;
        }
        
        // Validate file selection
        if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            alert('{{ __("messages.payment_attachment_required") }}');
            fileInput.focus();
            return false;
        }
        
        // Validate file type
        const file = fileInput.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp', 'application/pdf'];
        
        if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            alert('{{ __("messages.payment_attachment_invalid_format") }}');
            fileInput.focus();
            return false;
        }
        
        // Validate file size (5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            e.preventDefault();
            alert('{{ __("messages.payment_attachment_too_large") }}');
            fileInput.focus();
            return false;
        }
        
        // Show loading state on submit button
        const submitButton = document.getElementById('submit-button');
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('messages.submitting') }}...
        `;
    });
    </script>
    @endpush
</x-customer-frontend-layout::layout>