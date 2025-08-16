<x-customer-frontend-layout::layout :title="__('Verify Mobile Number')">
    <!-- Verify Mobile Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Verify Your Mobile Number') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('Your mobile number needs to be verified before you can access your account.') }}<br>
                    {{ __('Please contact support to verify your mobile number.') }}
                </p>
            </div>

            @if (session('status') === 'mobile-verification-sent')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A mobile verification request has been sent.') }}
                </div>
            @endif

            <div class="text-center">
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('Your mobile number: ') }}
                    <span class="font-semibold text-gray-800 dark:text-gray-100">
                        {{ auth()->user()->country_code }}{{ auth()->user()->mobile }}
                    </span>
                </p>
                
                <div class="space-y-3">
                    <a href="mailto:support@example.com" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('Contact Support') }}
                    </a>
                    
                    <a href="{{ route('accounts.settings.profile.edit') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('Update Mobile Number') }}
                    </a>
                </div>
            </div>

            <div class="text-center mt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                        {{ __('Log out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>