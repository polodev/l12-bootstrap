<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Subscription Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">User subscription information and management</p>
                </div>
                <div class="flex items-center space-x-3">
                    @if($subscription->status === 'active')
                        <form action="{{ route('subscription::admin.subscriptions.cancel', $subscription) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to cancel this subscription?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel Subscription
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('subscription::admin.subscriptions.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- User Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Subscriber Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Name</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100 font-semibold">{{ $subscription->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Email</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $subscription->user->email }}</p>
                            </div>
                            @if($subscription->user->mobile)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Mobile</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $subscription->user->mobile }}</p>
                            </div>
                            @endif
                            @if($subscription->user->country)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Country</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $subscription->user->country }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Subscription Plan Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Plan Details</h3>
                            <a href="{{ route('subscription::admin.plans.show', $subscription->subscriptionPlan) }}" 
                               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                View Plan Details
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Plan Name</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100 font-semibold">{{ $subscription->subscriptionPlan->getTranslation('plan_title', 'en') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Price Paid</label>
                                <p class="mt-1 text-2xl text-green-600 dark:text-green-400 font-bold">{{ number_format($subscription->price, 0) }} {{ $subscription->currency }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Duration</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $subscription->subscriptionPlan->duration_text }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Original Price</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ number_format($subscription->subscriptionPlan->price, 0) }} {{ $subscription->subscriptionPlan->currency }}</p>
                            </div>
                        </div>

                        @if($subscription->discount_amount > 0)
                            <div class="mt-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-green-800 dark:text-green-200 font-semibold">
                                            Discount Applied: {{ number_format($subscription->discount_amount, 0) }} {{ $subscription->currency }}
                                        </p>
                                        @if($subscription->coupon_code)
                                            <p class="text-green-600 dark:text-green-400 text-sm">Coupon Code: {{ $subscription->coupon_code }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Information -->
                    @if($subscription->payment)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Payment Details</h3>
                                <a href="{{ route('payment::admin.payments.show', $subscription->payment) }}" 
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                    View Payment Details
                                </a>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Payment Method</label>
                                    <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $subscription->payment->payment_method }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Payment Status</label>
                                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($subscription->payment->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($subscription->payment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @endif">
                                        {{ ucfirst($subscription->payment->status) }}
                                    </span>
                                </div>
                                @if($subscription->payment->transaction_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Transaction ID</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $subscription->payment->transaction_id }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Payment Date</label>
                                    <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $subscription->payment->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Subscription Status</h3>
                        <div class="space-y-4">
                            <div class="text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium
                                    @if($subscription->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($subscription->status === 'expired') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($subscription->status === 'cancelled') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @endif">
                                    @if($subscription->status === 'active')
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($subscription->status === 'expired')
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($subscription->status === 'cancelled')
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </div>
                            
                            <div class="space-y-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Started</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $subscription->starts_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Expires</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $subscription->expires_at->format('M d, Y') }}</span>
                                </div>
                                @if($subscription->status === 'active')
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Days Remaining</span>
                                        <span class="text-green-600 dark:text-green-400 font-semibold">{{ $subscription->expires_at->diffInDays(now()) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    @if($subscription->status === 'active')
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <form action="{{ route('subscription::admin.subscriptions.extend', $subscription) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800 rounded-md"
                                            onclick="return confirm('Extend this subscription by the plan duration?')">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Extend Subscription
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Timestamps</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Created</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $subscription->created_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Updated</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $subscription->updated_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>