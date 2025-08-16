<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('accounts.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('accounts.settings.profile.edit') }}"
           class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.profile') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.password') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.update_password') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            {{ __('messages.password_security_text') }}
        </p>
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
                        <!-- Profile Form -->
                        <form class="max-w-md mb-10" action="{{ route('accounts.settings.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-forms.input :label="__('messages.current_password')" name="current_password" type="password" />
                            </div>

                            <div class="mb-6">
                                <x-forms.input :label="__('messages.new_password')" name="password" type="password" />
                            </div>

                            <div class="mb-6">
                                <x-forms.input :label="__('messages.confirm_password')" name="password_confirmation" type="password" />
                            </div>

                            <div>
                                <x-button type="primary">{{ __('messages.update_password') }}</x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-account-layout::layout>
