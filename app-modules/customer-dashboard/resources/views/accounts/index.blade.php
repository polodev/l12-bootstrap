<x-customer-account-layout::layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.my_account') }}</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.manage_account_details') }}</p>
        </div>
        
        <!-- Account Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Profile Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    @if($user->getFirstMedia('avatar'))
                        <img src="{{ $user->avatar_url }}" 
                             alt="{{ $user->name }}"
                             class="w-20 h-20 rounded-full object-cover mx-auto mb-4 border-2 border-gray-200 dark:border-gray-600">
                    @else
                        <div class="w-20 h-20 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-medium">{{ $user->initials() }}</span>
                        </div>
                    @endif
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-1">{{ $user->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-2">{{ $user->email }}</p>
                    <span class="text-sm text-gray-500 dark:text-gray-500">{{ __('messages.member_since') }} {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
            
            <!-- Statistics Grid -->
            <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.total_orders') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mb-1">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.pending_orders') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.completed_orders') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-1">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.wishlist_items') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-1">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.support_tickets') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-2xl mb-1">
                        @if($user->email_verified_at)
                            <svg class="w-8 h-8 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-red-500 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.email_status') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Edit Profile -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-blue-200 dark:border-blue-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.edit_profile') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.update_personal_info') }}</p>
                    <a href="{{ route('accounts.settings.profile') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.edit_profile') }}
                    </a>
                </div>
            </div>
            
            <!-- My Orders -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-cyan-200 dark:border-cyan-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-cyan-100 dark:bg-cyan-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13v6a2 2 0 002 2h7a2 2 0 002-2v-6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.my_orders') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.view_order_history') }}</p>
                    <a href="{{ route('accounts.orders') }}" class="bg-cyan-600 text-white px-4 py-2 rounded-md hover:bg-cyan-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.view_orders') }}
                    </a>
                </div>
            </div>
            
            <!-- My Subscription -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-purple-200 dark:border-purple-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.my_subscription') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.manage_subscription_details') }}</p>
                    <a href="{{ route('accounts.subscription') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.view_subscription') }}
                    </a>
                </div>
            </div>

            <!-- My Wishlist -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-green-200 dark:border-green-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.my_wishlist') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.manage_saved_items') }}</p>
                    <a href="{{ route('accounts.wishlist') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.view_wishlist') }}
                    </a>
                </div>
            </div>
            
            <!-- Support -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-amber-200 dark:border-amber-900 hover:shadow-md transition-shadow duration-200">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.support') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ __('messages.get_help_support') }}</p>
                    <a href="{{ route('accounts.support') }}" class="bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition-colors duration-200 text-sm font-medium">
                        {{ __('messages.contact_support') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Dashboard Link (if user has admin roles) -->
        @if(auth()->user()->hasAnyRole(['developer', 'admin', 'employee', 'accounts']))
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-1">{{ __('messages.admin_access') }}</h3>
                        <p class="text-blue-700 dark:text-blue-300 mb-4">{{ __('messages.admin_access_message') }}</p>
                        <a href="{{ route('admin-dashboard.index') }}" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            {{ __('messages.go_to_admin_dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-customer-account-layout::layout>