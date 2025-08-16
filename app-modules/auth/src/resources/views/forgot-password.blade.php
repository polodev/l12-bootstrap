<x-customer-frontend-layout::layout :title="__('messages.forgot_password')">
    <!-- Forgot Password Card -->
    <div class="max-w-md mx-auto">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.forgot_password') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('messages.enter_email_reset_link') }}</p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- Email Input -->
                <div class="mb-4">
                    <x-forms.input name="email" type="email" :label="__('messages.email')" placeholder="your@email.com" />
                </div>

                <!-- Send Reset Link Button -->
                <x-button type="primary" buttonType="submit" class="w-full">
                    {{ __('messages.send_password_reset_link') }}
                </x-button>
            </form>

            <!-- Back to Login Link -->
            <div class="text-center mt-6">
                <a href="{{ route('login') }}"
                    class="text-blue-600 dark:text-blue-400 hover:underline font-medium">{{ __('messages.back_to_login') }}</a>
            </div>
        </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>
