<x-customer-frontend-layout::layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('messages.privacy_policy') }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Effective date: January 2025
            </p>
        </div>

        <!-- Content Section -->
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 border border-gray-200 dark:border-gray-700">
                <!-- Privacy Notice -->
                <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border-l-4 border-green-500">
                    <h2 class="text-xl font-semibold text-green-900 dark:text-green-100 mb-2">
                        @if(app()->getLocale() == 'bn')
                            আপনার গোপনীয়তা গুরুত্বপূর্ণ
                        @else
                            Your Privacy Matters
                        @endif
                    </h2>
                    <p class="text-green-800 dark:text-green-200">
                        @if(app()->getLocale() == 'bn')
                            আমরা আপনার গোপনীয়তা রক্ষা এবং আপনার ব্যক্তিগত তথ্যের নিরাপত্তা নিশ্চিত করতে প্রতিশ্রুতিবদ্ধ।
                        @else
                            We are committed to protecting your privacy and ensuring the security of your personal information.
                        @endif
                    </p>
                </div>

                <!-- Page Content -->
                <div class="space-y-6">
                    @if(app()->getLocale() == 'bn')
                        @include('templates.legal.privacy-policy.content-bn')
                    @else
                        @include('templates.legal.privacy-policy.content-en')
                    @endif
                </div>

                <!-- Data Rights Section -->
                <div class="mt-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        @if(app()->getLocale() == 'bn')
                            আপনার অধিকারসমূহ
                        @else
                            Your Rights
                        @endif
                    </h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                @if(app()->getLocale() == 'bn') অ্যাক্সেস @else Access @endif
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if(app()->getLocale() == 'bn') আপনার ডেটা দেখুন @else View your data @endif
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-800 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                @if(app()->getLocale() == 'bn') সংশোধন @else Correct @endif
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if(app()->getLocale() == 'bn') আপনার ডেটা আপডেট করুন @else Update your data @endif
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-800 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                @if(app()->getLocale() == 'bn') মুছে ফেলুন @else Delete @endif
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if(app()->getLocale() == 'bn') আপনার ডেটা সরান @else Remove your data @endif
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>