{{-- Refund Policy Template --}}
<x-customer-frontend-layout::layout>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $page->getTranslation('title', app()->getLocale()) }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                @if(app()->getLocale() == 'bn')
                    আমাদের রিফান্ড পদ্ধতি, সময়সীমা এবং সমস্ত ভ্রমণ পরিষেবার শর্তাবলী সম্পর্কে জানুন
                @else
                    Learn about our refund procedures, timelines, and conditions for all travel services
                @endif
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                Effective date: January 2025
            </p>
        </div>

        <!-- Content Section -->
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 border border-gray-200 dark:border-gray-700">

                <!-- Page Content -->
                <div class="space-y-6">
                    @if(app()->getLocale() == 'bn')
                        @include('templates.legal.refund-policy.content-bn')
                    @else
                        @include('templates.legal.refund-policy.content-en')
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-customer-frontend-layout::layout>