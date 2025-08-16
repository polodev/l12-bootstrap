<x-customer-frontend-layout::layout :title="__('messages.sign_in_with_code')">
    <!-- Email Code Login Card -->
    <div class="max-w-md mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.sign_in_with_code') }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.enter_email_for_code') }}</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md">
                        <p class="text-sm text-green-600 dark:text-green-300">{{ session('status') }}</p>
                    </div>
                @endif

                @if(!session('show_code_form'))
                    <!-- Email Code Request Form -->
                    <form method="POST" action="{{ route('login.email-code') }}" id="emailCodeForm">
                        @csrf
                        
                        <!-- Email Input -->
                        <div class="mb-6">
                            <x-forms.input 
                                :label="__('messages.email')" 
                                name="email" 
                                type="email" 
                                placeholder="your@email.com" 
                                :value="old('email')"
                                required 
                            />
                        </div>

                        <!-- reCAPTCHA Token -->
                        <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                        <!-- Send Code Button -->
                        <x-button type="primary" class="w-full">
                            {{ __('messages.send_code') }}
                        </x-button>
                    </form>
                @else
                    <!-- Code Verification Form -->
                    <form method="POST" action="{{ route('login.verify-code') }}" id="codeVerificationForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        
                        <div class="text-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ __('messages.enter_verification_code') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ __('messages.code_sent_to') }} {{ session('email') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                {{ __('messages.check_your_email_for_code') }}
                            </p>
                        </div>
                        
                        <!-- Code Input -->
                        <div class="mb-6">
                            <x-forms.input 
                                :label="__('messages.verification_code')" 
                                name="code" 
                                type="text" 
                                placeholder="000000" 
                                maxlength="6" 
                                required
                            />
                        </div>
                        
                        <!-- Verify Code Button -->
                        <x-button type="primary" class="w-full">
                            {{ __('messages.verify_code') }}
                        </x-button>
                    </form>
                @endif

                <!-- Back to Login -->
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" 
                       class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                        {{ __('messages.back_to_login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @if(env('RECAPTCHA_ENABLED', true) && config('recaptcha.site_key'))
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}"></script>
            <script>
                document.getElementById('emailCodeForm')?.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ config('recaptcha.site_key') }}', {action: 'email_code_login'}).then(function(token) {
                            document.getElementById('recaptchaToken').value = token;
                            document.getElementById('emailCodeForm').submit();
                        });
                    });
                });
            </script>
        @else
            <script>
                // reCAPTCHA disabled - allow direct form submission
                document.getElementById('emailCodeForm')?.addEventListener('submit', function(e) {
                    // Form submits normally without reCAPTCHA
                });
            </script>
        @endif
    @endpush
</x-customer-frontend-layout::layout>