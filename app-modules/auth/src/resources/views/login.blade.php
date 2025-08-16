<x-customer-frontend-layout::layout :title="__('messages.login')">
    <!-- Login Card -->
    <div class="max-w-md mx-auto">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.login') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.sign_in_to_account') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <!-- Email Input -->
                <div class="mb-4">
                    <x-forms.input :label="__('messages.email')" name="email" type="email" placeholder="your@email.com" />
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <x-forms.password-input :label="__('messages.password')" name="password" placeholder="••••••••" />
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <x-forms.checkbox :label="__('messages.remember_me')" name="remember" />
                </div>

                <!-- reCAPTCHA Token -->
                <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                <!-- Login Button -->
                <x-button type="primary" class="w-full">{{ __('messages.sign_in') }}</x-button>
            </form>

            <!-- Forgot Password Link -->
            @if (Route::has('password.request'))
                <div class="text-center mt-4">
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                        {{ __('messages.forgot_password') }}
                    </a>
                </div>
            @endif

            <!-- Sign in with email code -->
            <div class="text-center mt-3">
                <a href="{{ route('login.email-code.create') }}" 
                   class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    {{ __('messages.sign_in_with_code') }}
                </a>
            </div>

            @php
                $enabledProviders = \App\Http\Controllers\Auth\SocialLoginController::getEnabledProviders();
            @endphp

            @if(count($enabledProviders) > 0)
                <!-- Social Login Divider -->
                <div class="my-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">{{ __('messages.or_continue_with') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="space-y-3">
                    @if(in_array('google', $enabledProviders))
                        <a href="{{ route('social.redirect', 'google') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            {{ __('messages.continue_with_google') }}
                        </a>
                    @endif

                    @if(in_array('facebook', $enabledProviders))
                        <a href="{{ route('social.redirect', 'facebook') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-white bg-[#1877F2] hover:bg-[#166FE5] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            {{ __('messages.continue_with_facebook') }}
                        </a>
                    @endif
                </div>
            @endif

            @if (Route::has('register'))
                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('messages.dont_have_account') }}
                        <a href="{{ route('register') }}"
                            class="text-blue-600 dark:text-blue-400 hover:underline font-medium">{{ __('messages.sign_up') }}</a>
                    </p>
                </div>
            @endif
        </div>
        </div>
    </div>

    @push('scripts')
        @if(env('RECAPTCHA_ENABLED', true) && config('recaptcha.site_key'))
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}"></script>
            <script>
                document.getElementById('loginForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ config('recaptcha.site_key') }}', {action: 'login'}).then(function(token) {
                            document.getElementById('recaptchaToken').value = token;
                            document.getElementById('loginForm').submit();
                        });
                    });
                });
            </script>
        @else
            <script>
                // reCAPTCHA disabled - allow direct form submission
                document.getElementById('loginForm').addEventListener('submit', function(e) {
                    // Form submits normally without reCAPTCHA
                });
            </script>
        @endif

    @endpush
</x-customer-frontend-layout::layout>
