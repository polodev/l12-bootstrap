<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Subscription Plan Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View subscription plan information and subscribers</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('subscription::admin.plans.edit', $plan) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Plan
                    </a>
                    <a href="{{ route('subscription::admin.plans.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                <!-- Plan Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Info Card -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Plan Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Internal Name</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100 font-semibold">{{ $plan->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Slug</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $plan->slug }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">English Title</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100 font-semibold">{{ $plan->getTranslation('plan_title', 'en') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Bengali Title</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100 font-semibold">{{ $plan->getTranslation('plan_title', 'bn') ?: 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Price</label>
                                <p class="mt-1 text-2xl text-green-600 dark:text-green-400 font-bold">{{ $plan->formatted_price }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Duration</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $plan->duration_text }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Price per Month</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ number_format($plan->price_per_month, 2) }} {{ $plan->currency }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Sort Order</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $plan->sort_order }}</p>
                            </div>
                        </div>

                        @if($plan->description)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Description</label>
                                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $plan->description }}</p>
                            </div>
                        @endif

                        @if($plan->savings)
                            <div class="mt-6">
                                <div class="bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="text-green-800 dark:text-green-200 font-semibold">Savings: {{ number_format($plan->savings, 0) }} {{ $plan->currency }}</p>
                                            <p class="text-green-600 dark:text-green-400 text-sm">{{ $plan->savings_percentage }}% off compared to monthly</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Features Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Plan Features</h3>
                        
                        <!-- Features Tabs -->
                        <div class="border-b border-gray-200 dark:border-gray-600 mb-4">
                            <nav class="-mb-px flex space-x-8">
                                <button type="button" 
                                        class="features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                        data-tab="en" 
                                        data-active="true">
                                    English Features
                                </button>
                                <button type="button" 
                                        class="features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                        data-tab="bn" 
                                        data-active="false">
                                    Bengali Features
                                </button>
                            </nav>
                        </div>

                        <!-- English Features -->
                        <div id="features-tab-en" class="features-tab-panel">
                            @if($plan->getTranslation('features', 'en'))
                                <div class="prose prose-sm max-w-none dark:prose-invert">
                                    {!! Str::markdown($plan->getTranslation('features', 'en')) !!}
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">No English features defined</p>
                            @endif
                        </div>

                        <!-- Bengali Features -->
                        <div id="features-tab-bn" class="features-tab-panel hidden">
                            @if($plan->getTranslation('features', 'bn'))
                                <div class="prose prose-sm max-w-none dark:prose-invert">
                                    {!! Str::markdown($plan->getTranslation('features', 'bn')) !!}
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">No Bengali features defined</p>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Subscribers -->
                    @if($plan->userSubscriptions->isNotEmpty())
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Recent Subscribers</h3>
                            <div class="space-y-3">
                                @foreach($plan->userSubscriptions as $subscription)
                                    <div class="flex items-center justify-between bg-white dark:bg-gray-600 rounded-lg p-4">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $subscription->user->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subscription->user->email }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($subscription->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($subscription->status === 'expired') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @endif">
                                                {{ ucfirst($subscription->status) }}
                                            </span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subscription->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($plan->userSubscriptions->count() >= 10)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('subscription::admin.subscriptions.index') }}?plan={{ $plan->id }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                        View all subscribers
                                    </a>
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
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Active</span>
                                @if($plan->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                            
                            <form action="{{ route('subscription::admin.plans.toggle-status', $plan) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium rounded-md
                                    @if($plan->is_active) 
                                        text-red-700 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800
                                    @else 
                                        text-green-700 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800
                                    @endif">
                                    @if($plan->is_active)
                                        Deactivate Plan
                                    @else
                                        Activate Plan
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Statistics</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Subscribers</span>
                                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $plan->userSubscriptions->count() }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Active Subscriptions</span>
                                <span class="text-xl font-semibold text-green-600 dark:text-green-400">{{ $plan->userSubscriptions->where('status', 'active')->count() }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Expired</span>
                                <span class="text-xl font-semibold text-red-600 dark:text-red-400">{{ $plan->userSubscriptions->where('status', 'expired')->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Timestamps</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Created</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $plan->created_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Updated</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $plan->updated_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Features Tab functionality
            const featuresTabButtons = document.querySelectorAll('.features-tab-btn');
            const featuresTabPanels = document.querySelectorAll('.features-tab-panel');

            featuresTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update button states
                    featuresTabButtons.forEach(btn => {
                        btn.setAttribute('data-active', 'false');
                        btn.className = 'features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500';
                    });
                    
                    this.setAttribute('data-active', 'true');
                    this.className = 'features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400';
                    
                    // Update panel visibility
                    featuresTabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    
                    document.getElementById(`features-tab-${targetTab}`).classList.remove('hidden');
                });
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>