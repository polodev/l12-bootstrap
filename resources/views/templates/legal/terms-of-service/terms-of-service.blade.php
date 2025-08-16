<x-customer-frontend-layout::layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('messages.terms_of_service') }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Last updated: January 2025
            </p>
        </div>

        <!-- Content Section -->
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 border border-gray-200 dark:border-gray-700">
                <!-- Agreement Introduction -->
                <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                    <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-100 mb-2">{{ __('messages.agreement_to_terms') }}</h2>
                    <p class="text-blue-800 dark:text-blue-200">
                        {{ __('messages.agreement_to_terms_text') }}
                    </p>
                </div>

                <!-- Page Content -->
                <div class="space-y-6">
                    @if(app()->getLocale() == 'bn')
                        @include('templates.legal.terms-of-service.content-bn')
                    @else
                        @include('templates.legal.terms-of-service.content-en')
                    @endif
                </div>

                <!-- Contact Information -->
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.contact_information') }}</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ __('messages.terms_contact_text') }}
                        </p>
                        <div class="mt-4 space-y-2">
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ __('messages.email') }}:</strong> info@ecotravelsonline.com.bd
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ __('messages.phone') }}:</strong> +8809647668822
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ __('messages.address') }}:</strong> {{ __('messages.company_address') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>