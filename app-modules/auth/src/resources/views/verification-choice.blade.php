<x-customer-frontend-layout::layout :title="__('Account Verification')">
    <!-- Verification Choice Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Verify Your Account') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ __('Please verify your email or mobile number to continue accessing your account.') }}
                </p>
            </div>

            <!-- Status Messages -->
            @if (session('status'))
                <div class="mb-6">
                    @if (session('status') === 'verification-link-sent')
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif (session('status') === 'email-added-verification-sent')
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                        {{ __('Email address added successfully! A verification link has been sent.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif (session('status') === 'mobile-added-contact-support')
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                        {{ __('Mobile number added successfully! Please contact support to verify your mobile number.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <div class="max-w-md mx-auto">
                <!-- Email Verification Block -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                    <div class="text-center mb-4">
                        <div class="mx-auto w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ __('Email Verification') }}</h3>
                    </div>

                    @if($user->email)
                        <div class="space-y-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ __('Current Email:') }}</p>
                                <p class="font-medium text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                    {{ $user->email }}
                                </p>
                            </div>
                            
                            @if($user->hasVerifiedEmail())
                                <div class="text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('Verified') }}
                                    </span>
                                </div>
                            @else
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                                        {{ __('Send Verification Email') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <!-- Add Email Form -->
                        <form method="POST" action="{{ route('verification.add-contact') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="type" value="email">
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Email Address') }}</label>
                                <input type="email" name="email" id="email" required 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                       placeholder="your@email.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                                {{ __('Add Email & Send Verification') }}
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Mobile Verification Block --}}
                {{-- <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                    <div class="text-center mb-4">
                        <div class="mx-auto w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ __('Mobile Verification') }}</h3>
                    </div>

                    @if($user->mobile)
                        <div class="space-y-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ __('Current Mobile:') }}</p>
                                <p class="font-medium text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-800 px-3 py-2 rounded border">
                                    {{ $user->country_code }}{{ $user->mobile }}
                                </p>
                            </div>
                            
                            @if($user->hasVerifiedMobile())
                                <div class="text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('Verified') }}
                                    </span>
                                </div>
                            @else
                                <div class="text-center">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        {{ __('Contact support to verify your mobile number.') }}
                                    </p>
                                    <a href="mailto:support@example.com" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ __('Contact Support') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Add Mobile Form -->
                        <form method="POST" action="{{ route('verification.add-contact') }}" class="space-y-4" id="mobile-form">
                            @csrf
                            <input type="hidden" name="type" value="mobile">
                            
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Country') }}</label>
                                <select name="country" id="country" required 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('country') border-red-500 @enderror">
                                    <option value="">{{ __('Select Country') }}</option>
                                    @foreach(\Modules\UserData\Helpers\CountryListWithCountryCode::getCountryOptions() as $alpha3 => $countryOption)
                                        <option value="{{ $alpha3 }}" data-code="{{ \Modules\UserData\Helpers\CountryListWithCountryCode::getCountryCode($alpha3) }}">
                                            {{ $countryOption }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Mobile Number') }}</label>
                                <div class="flex">
                                    <input type="text" name="country_code" id="country_code" readonly 
                                           class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-gray-50 dark:bg-gray-600 text-gray-900 dark:text-gray-100" 
                                           placeholder="+1">
                                    <input type="text" name="mobile" id="mobile" required 
                                           class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-r-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mobile') border-red-500 @enderror"
                                           placeholder="1234567890">
                                </div>
                                @error('mobile')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('country_code')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                                {{ __('Add Mobile Number') }}
                            </button>
                        </form>
                    @endif
                </div> --}}
            </div>

            <!-- Logout Section -->
            <div class="text-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    {{ __('Need to use a different account?') }}
                </p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Log out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('country');
            const countryCodeInput = document.getElementById('country_code');
            
            if (countrySelect && countryCodeInput) {
                countrySelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const countryCode = selectedOption.getAttribute('data-code');
                    
                    if (countryCode) {
                        countryCodeInput.value = countryCode;
                    } else {
                        countryCodeInput.value = '';
                    }
                });
            }
        });
    </script>
    @endpush
</x-customer-frontend-layout::layout>