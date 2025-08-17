<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Status Header -->
            <div class="text-center mb-8">
                <div class="mb-6">
                    @if($payment->status === 'completed')
                        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">{{ __('messages.payment_verified') }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.manual_payment_verified_message') }}</p>
                    @elseif($payment->status === 'processing')
                        <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ __('messages.payment_submitted_successfully') }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.manual_payment_processing_message') }}</p>
                    @elseif($payment->status === 'failed')
                        <div class="w-20 h-20 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-red-600 dark:text-red-400 mb-2">{{ __('messages.payment_rejected') }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.manual_payment_rejected_message') }}</p>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Payment Details - Main Column -->
                <div class="lg:col-span-2">
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
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ __('messages.manual_payment') }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.date_time') }}</label>
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $payment->payment_date ? $payment->payment_date->format('M d, Y h:i A') : $payment->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                                @if($payment->bank_name)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.bank_mfs_name') }}</label>
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $payment->bank_name }}</div>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.status') }}</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($payment->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($payment->status === 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($payment->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Notes Section -->
                            @if($payment->notes)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">{{ __('messages.additional_details_message') }}</h3>
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
                                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $payment->notes }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Payment Attachment Section -->
                            @if($payment->getFirstMedia('payment_attachment'))
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.payment_attachment') }}</h3>
                                
                                @php
                                    $attachment = $payment->getFirstMedia('payment_attachment');
                                    $isImage = in_array($attachment->mime_type, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
                                @endphp

                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
                                    @if($isImage)
                                        <!-- Image Preview -->
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $attachment->name }}</span>
                                                </div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $attachment->human_readable_size }}</span>
                                            </div>
                                            
                                            <!-- Image Display -->
                                            <div class="mt-3">
                                                <img src="{{ $attachment->getUrl() }}" 
                                                     alt="{{ $attachment->name }}"
                                                     class="max-w-full h-auto max-h-96 mx-auto rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm cursor-pointer"
                                                     onclick="openImageModal('{{ $attachment->getUrl() }}', '{{ $attachment->name }}')">
                                            </div>
                                            
                                            <!-- Download Link -->
                                            <div class="flex justify-center mt-3">
                                                <a href="{{ $attachment->getUrl() }}" 
                                                   download="{{ $attachment->name }}"
                                                   class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    {{ __('messages.download_attachment') }}
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Document/PDF Download -->
                                        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center space-x-3">
                                                <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded-lg">
                                                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $attachment->name }}</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ strtoupper(pathinfo($attachment->name, PATHINFO_EXTENSION)) }} • {{ $attachment->human_readable_size }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ $attachment->getUrl() }}" 
                                               download="{{ $attachment->name }}"
                                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                {{ __('messages.download') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif

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
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Status Update -->
                    @if($payment->status === 'processing')
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">{{ __('messages.verification_in_progress') }}</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            {{ __('messages.verification_in_progress_message') }}
                        </p>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        @if($payment->status === 'completed')
                            <button onclick="window.print()" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                {{ __('messages.print_receipt') }}
                            </button>
                        @elseif($payment->status === 'failed')
                            <a href="{{ route('payment::payments.show', $payment) }}" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                {{ __('messages.try_again') }}
                            </a>
                        @endif

                        <a href="{{ LaravelLocalization::localizeUrl('/') }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{ __('messages.back_to_home') }}
                        </a>
                    </div>

                    <!-- Help Section -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-yellow-900 dark:text-yellow-100 mb-2">{{ __('messages.need_help') }}</h3>
                        <p class="text-sm text-yellow-700 dark:text-yellow-300 mb-3">
                            {{ __('messages.manual_payment_help_text') }}
                        </p>
                        <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="inline-flex items-center text-sm font-medium text-yellow-600 dark:text-yellow-400 hover:underline">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('messages.contact_customer_care') }}
                        </a>
                    </div>
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

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
        </div>
    </div>

    @push('scripts')
    <script>
    function openImageModal(imageUrl, imageName) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        
        modalImage.src = imageUrl;
        modalImage.alt = imageName;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
    </script>
    @endpush

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