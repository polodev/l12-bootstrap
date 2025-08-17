<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Payment Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: {{ $payment->id }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('payment::admin.payments.edit', $payment) }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 border border-yellow-300 rounded-md hover:bg-yellow-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Payment
                    </a>
                    <a href="{{ route('payment::admin.payments.index') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Payment Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Payment Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Amount:</span>
                                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $payment->formatted_amount }}</div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                                <div class="mt-1">{!! $payment->status_badge !!}</div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Method:</span>
                                <div class="mt-1">{!! $payment->payment_method_badge !!}</div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Type:</span>
                                <div class="mt-1">
                                    @if($payment->payment_type === 'subscription')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-900 dark:bg-purple-900 dark:text-purple-100">Subscription Payment</span>
                                    @elseif($payment->payment_type === 'custom_payment')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-900 dark:bg-green-900 dark:text-green-100">Custom Payment</span>
                                    @else
                                        <span class="text-gray-400">Unknown</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Details (for subscription payments) -->
                    @if($payment->payment_type === 'subscription' && $payment->subscription_plan_id)
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            <svg class="w-5 h-5 inline mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            Subscription Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $subscriptionPlan = \Modules\Subscription\Models\SubscriptionPlan::find($payment->subscription_plan_id);
                                $userSubscription = \Modules\Subscription\Models\UserSubscription::where('payment_id', $payment->id)->first();
                                $coupon = $payment->coupon_id ? \Modules\Coupon\Models\Coupon::find($payment->coupon_id) : null;
                            @endphp
                            
                            @if($subscriptionPlan)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subscription Plan:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $subscriptionPlan->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $subscriptionPlan->duration_text }}</div>
                            </div>
                            @endif
                            
                            @if($payment->user_id)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subscriber:</span>
                                @php $subscriber = \App\Models\User::find($payment->user_id); @endphp
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $subscriber->name ?? 'User Not Found' }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $subscriber->email ?? 'N/A' }}</div>
                            </div>
                            @endif
                            
                            @if($payment->original_amount && $payment->original_amount != $payment->amount)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Original Amount:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($payment->original_amount, 2) }} BDT</div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Discount Applied:</span>
                                <div class="font-medium text-green-600 dark:text-green-400">-{{ number_format($payment->discount_amount, 2) }} BDT</div>
                            </div>
                            @endif
                            
                            @if($payment->coupon_code)
                            <div class="md:col-span-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Coupon Used:</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ $payment->coupon_code }}
                                    </span>
                                    @if($coupon)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        ({{ $coupon->type === 'percentage' ? $coupon->value.'%' : number_format($coupon->value, 2).' BDT' }} off)
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            @if($userSubscription)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subscription Period:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $userSubscription->starts_at->format('M j, Y') }} - {{ $userSubscription->ends_at->format('M j, Y') }}
                                </div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subscription Status:</span>
                                <div class="mt-1">
                                    @if($userSubscription->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                                    @elseif($userSubscription->status === 'expired')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Expired</span>
                                    @elseif($userSubscription->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Cancelled</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">{{ ucfirst($userSubscription->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        @if($userSubscription)
                        <div class="mt-4 pt-4 border-t border-purple-200 dark:border-purple-700">
                            <div class="flex gap-2">
                                @if($subscriptionPlan)
                                <a href="{{ route('subscription::admin.plans.show', $subscriptionPlan) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-100 border border-purple-300 rounded-md hover:bg-purple-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Plan Details
                                </a>
                                @endif
                                @if($userSubscription)
                                <a href="{{ route('subscription::admin.subscriptions.show', $userSubscription) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-100 border border-purple-300 rounded-md hover:bg-purple-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Subscription
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Customer Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Information</h3>
                        @if($payment->booking)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Customer Name:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->booking->user->name ?? 'Guest User' }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Email:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->booking->user->email ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Booking Reference:</span>
                                    <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->booking->booking_reference }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Booking Type:</span>
                                    <div class="text-gray-900 dark:text-gray-100">{{ ucfirst($payment->booking->booking_type) }}</div>
                                </div>
                            </div>
                        @elseif($payment->payment_type === 'custom_payment')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Customer Name:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->name }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Email:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->email_address ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Mobile:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->mobile }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Purpose:</span>
                                    <div class="text-gray-900 dark:text-gray-100">{{ $payment->purpose ?? 'N/A' }}</div>
                                </div>
                                @if($payment->description)
                                <div class="md:col-span-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Description:</span>
                                    <div class="text-gray-900 dark:text-gray-100">{{ $payment->description }}</div>
                                </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No customer information available</p>
                        @endif
                    </div>

                    <!-- Transaction Details -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Transaction Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Receipt Number:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->receipt_number ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Bank Name:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->bank_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Attachment Section -->
                    @if($payment->getFirstMedia('payment_attachment'))
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Attachment</h3>
                        
                        @php
                            $attachment = $payment->getFirstMedia('payment_attachment');
                            $isImage = in_array($attachment->mime_type, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
                        @endphp

                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
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
                                            Download Attachment
                                        </a>
                                    </div>
                                </div>
                            @else
                                <!-- Document/PDF Download -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-600">
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
                                        Download
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Customer Notes -->
                    @if($payment->notes)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Notes</h3>
                        <div class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $payment->notes }}</div>
                    </div>
                    @endif

                    <!-- Admin Notes -->
                    @if($payment->admin_notes)
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            <svg class="w-5 h-5 inline mr-2 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Admin Notes <span class="text-xs text-yellow-600 dark:text-yellow-400">(Internal)</span>
                        </h3>
                        <div class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $payment->admin_notes }}</div>
                    </div>
                    @endif

                    <!-- Gateway Information -->
                    @if($payment->gateway_response || $payment->gateway_payment_id || $payment->gateway_reference)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Gateway Information</h3>
                        
                        <!-- Gateway IDs -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Payment ID:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">#{{ $payment->id }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Gateway Payment ID:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->gateway_payment_id ?? 'N/A' }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-gray-600 dark:text-gray-400">Gateway Reference:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->gateway_reference ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <!-- Gateway Response -->
                        @if($payment->gateway_response)
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Gateway Response:</span>
                            <div class="mt-2 bg-gray-900 text-green-400 p-4 rounded text-xs font-mono min-h-24 max-h-64 overflow-y-auto border border-gray-700">
                                <pre class="whitespace-pre-wrap break-words">{{ json_encode(is_string($payment->gateway_response) ? json_decode($payment->gateway_response, true) : $payment->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Activity Log -->
                    @if($payment->activities->count() > 0)
                        <x-utility::collapsible-card 
                            title="ActivityLog - Payment"
                            :collapsed="true"
                            headerClass="bg-green-500 text-white hover:bg-green-600"
                            cardClass="border border-gray-200 dark:border-gray-600"
                        >
                            <x-utility::activity-log :model="$payment" />
                        </x-utility::collapsible-card>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Payment Status & Dates -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Timeline</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Created:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->created_at->format('M j, Y H:i') }}</div>
                            </div>
                            @if($payment->payment_date)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Payment Date:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->payment_date->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                            @if($payment->processed_at)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Processed:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->processed_at->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                            @if($payment->failed_at)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Failed:</span>
                                <div class="font-medium text-red-600 dark:text-red-400">{{ $payment->failed_at->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                            @if($payment->refunded_at)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Refunded:</span>
                                <div class="font-medium text-purple-600 dark:text-purple-400">{{ $payment->refunded_at->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Link -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Link</h3>
                        <div class="flex items-center space-x-2">
                            <input type="text" 
                                   id="payment-link"
                                   value="{{ route('payment::payments.show', $payment->id) }}" 
                                   readonly
                                   class="flex-1 px-3 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded text-sm text-gray-900 dark:text-gray-100 font-mono">
                            <button type="button"
                                    onclick="copyPaymentLink()"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-500 rounded bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-500 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy
                            </button>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('payment::admin.payments.edit', $payment) }}" 
                               class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 border border-yellow-300 rounded-md hover:bg-yellow-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Payment
                            </a>
                            
                            @if($payment->booking)
                            <a href="{{ route('booking::admin.bookings.show', $payment->booking) }}" 
                               class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Booking
                            </a>
                            @endif


                            <!-- View Frontend Link -->
                            <a href="{{ route('payment::payments.show', $payment->id) }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-purple-700 bg-purple-100 border border-purple-300 rounded-md hover:bg-purple-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                View Frontend Page
                            </a>
                        </div>

                    </div>
                </div>
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
    function copyPaymentLink() {
        const linkInput = document.getElementById('payment-link');
        const copyButton = document.querySelector('button[onclick="copyPaymentLink()"]');
        
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
            copyButton.classList.add('text-green-600', 'border-green-300', 'bg-green-50');
            copyButton.classList.remove('text-gray-700', 'dark:text-gray-300', 'border-gray-300', 'dark:border-gray-500', 'bg-white', 'dark:bg-gray-600');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                copyButton.innerHTML = originalHTML;
                copyButton.classList.remove('text-green-600', 'border-green-300', 'bg-green-50');
                copyButton.classList.add('text-gray-700', 'dark:text-gray-300', 'border-gray-300', 'dark:border-gray-500', 'bg-white', 'dark:bg-gray-600');
            }, 2000);
            
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
        
        // Deselect the text
        linkInput.blur();
    }

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
</x-admin-dashboard-layout::layout>