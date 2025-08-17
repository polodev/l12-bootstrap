<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Coupon Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View coupon information and usage statistics</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('coupon::admin.coupons.edit', $coupon) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Coupon
                    </a>
                    <a href="{{ route('coupon::admin.coupons.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                    <!-- Basic Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Coupon Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Coupon Code</label>
                                <p class="mt-1 text-2xl text-gray-900 dark:text-gray-100 font-bold font-mono">{{ $coupon->code }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Coupon Name</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100 font-semibold">{{ $coupon->name }}</p>
                            </div>
                        </div>

                        @if($coupon->description)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Description</label>
                                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $coupon->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Discount Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Discount Configuration</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Discount Type</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100 capitalize">{{ $coupon->type }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Discount Value</label>
                                <p class="mt-1 text-2xl text-green-600 dark:text-green-400 font-bold">
                                    @if($coupon->type === 'percentage')
                                        {{ $coupon->value }}%
                                    @else
                                        {{ number_format($coupon->value, 0) }} BDT
                                    @endif
                                </p>
                            </div>
                            @if($coupon->minimum_amount)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Minimum Order Amount</label>
                                    <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ number_format($coupon->minimum_amount, 0) }} BDT</p>
                                </div>
                            @endif
                            @if($coupon->maximum_discount)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Maximum Discount</label>
                                    <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ number_format($coupon->maximum_discount, 0) }} BDT</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Applicable Plans -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Applicable Plans</h3>
                        @if($coupon->applicable_plans)
                            <div class="space-y-2">
                                @foreach(\Modules\Subscription\Models\SubscriptionPlan::whereIn('id', $coupon->applicable_plans)->get() as $plan)
                                    <div class="flex items-center justify-between bg-white dark:bg-gray-600 rounded-lg p-3">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $plan->getTranslation('plan_title', 'en') }}</span>
                                        <span class="text-green-600 dark:text-green-400 font-semibold">{{ $plan->formatted_price }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-blue-100 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-blue-800 dark:text-blue-200 font-medium">This coupon applies to all subscription plans</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Usage Statistics -->
                    @if($coupon->usages->isNotEmpty())
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Recent Usage</h3>
                            <div class="space-y-3">
                                @foreach($coupon->usages->take(10) as $usage)
                                    <div class="flex items-center justify-between bg-white dark:bg-gray-600 rounded-lg p-4">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $usage->user->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $usage->user->email }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-green-600 dark:text-green-400">-{{ number_format($usage->discount_amount, 0) }} BDT</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $usage->used_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($coupon->usages->count() > 10)
                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Showing 10 of {{ $coupon->usages->count() }} total uses
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status</h3>
                        <div class="space-y-4">
                            <div class="text-center">
                                @if($coupon->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                            
                            <form action="{{ route('coupon::admin.coupons.toggle-status', $coupon) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium rounded-md
                                    @if($coupon->is_active) 
                                        text-red-700 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800
                                    @else 
                                        text-green-700 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800
                                    @endif">
                                    @if($coupon->is_active)
                                        Deactivate Coupon
                                    @else
                                        Activate Coupon
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Usage Statistics -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Usage Statistics</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Uses</span>
                                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $coupon->usages_count ?? 0 }}</span>
                            </div>
                            
                            @if($coupon->usage_limit)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Usage Limit</span>
                                    <span class="text-xl font-semibold text-gray-700 dark:text-gray-300">{{ $coupon->usage_limit }}</span>
                                </div>
                                
                                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, (($coupon->usages_count ?? 0) / $coupon->usage_limit) * 100) }}%"></div>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">{{ $coupon->usage_limit - ($coupon->usages_count ?? 0) }} remaining</span>
                                    <span class="text-gray-500 dark:text-gray-400">{{ number_format(min(100, (($coupon->usages_count ?? 0) / $coupon->usage_limit) * 100), 1) }}% used</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Savings</span>
                                <span class="text-xl font-semibold text-green-600 dark:text-green-400">{{ number_format($coupon->usages_sum_discount_amount ?? 0, 0) }} BDT</span>
                            </div>
                        </div>
                    </div>

                    <!-- Validity Period -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Validity Period</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Starts</label>
                                @if($coupon->starts_at)
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $coupon->starts_at->format('M d, Y g:i A') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $coupon->starts_at->diffForHumans() }}</p>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No start date (active immediately)</p>
                                @endif
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Expires</label>
                                @if($coupon->expires_at)
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $coupon->expires_at->format('M d, Y g:i A') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $coupon->expires_at->diffForHumans() }}</p>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No expiry date</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Timestamps</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Created</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $coupon->created_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $coupon->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Updated</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $coupon->updated_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $coupon->updated_at->diffForHumans() }}</p>
                            </div>
                            @if($coupon->created_by)
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Created By</label>
                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $coupon->creator->name ?? 'Unknown' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>