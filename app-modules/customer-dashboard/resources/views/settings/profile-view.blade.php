<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('accounts.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('accounts.settings.profile') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.profile') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.view') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.profile') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.view_profile_information') }}</p>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar Navigation -->
            @include('customer-dashboard::settings.partials.navigation')

            <!-- Profile Content -->
            <div class="flex-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="p-6">
                        <!-- Profile Information -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                {{ __('messages.profile_information') }}
                            </h2>
                            <a href="{{ route('accounts.settings.profile.edit') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('messages.edit') }}
                            </a>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.name') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $user->name }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.email') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $user->email }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.email_verified') }}:</span>
                                <div class="mt-1">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('messages.verified') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('messages.not_verified') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.country') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">
                                    @if($user->country)
                                        {{ \Modules\UserData\Helpers\CountryListWithCountryCode::getCountryName($user->country) ?: $user->country }}
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.not_provided') }}</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.mobile') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">
                                    @if($user->mobile)
                                        <span class="inline-flex items-center">
                                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-l text-gray-600 dark:text-gray-300 text-xs border-r">{{ $user->country_code }}</span>
                                            <span class="px-2 py-1 bg-gray-50 dark:bg-gray-600 rounded-r">{{ $user->mobile }}</span>
                                        </span>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.not_provided') }}</span>
                                    @endif
                                </p>
                            </div>

                            @if($user->mobile)
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.mobile_verified') }}:</span>
                                <div class="mt-1">
                                    @if($user->mobile_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('messages.verified') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('messages.not_verified') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.role') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $user->role ?: __('messages.customer') }}</p>
                            </div>

                            @if($user->last_login_at)
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.last_login') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $user->last_login_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            @endif

                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.member_since') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $user->created_at->format('F j, Y') }}</p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.profile_updated') }}:</span>
                                <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $user->updated_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Management Component -->
                <div class="mb-6">
                    @livewire('email-management')
                </div>

                <!-- Mobile Management Component -->
                <div class="mb-6">
                    @livewire('mobile-management')
                </div>
            </div>
        </div>
    </div>

</x-customer-account-layout::layout>