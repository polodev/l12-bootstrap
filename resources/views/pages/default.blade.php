<x-customer-frontend-layout::layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $page->getTranslation('title', app()->getLocale()) }}
            </h1>
            @if($page->published_at)
                <p class="text-gray-600 dark:text-gray-400">
                    Published: {{ $page->published_at->format('F d, Y') }}
                </p>
            @endif
        </div>

        <!-- Page Content -->
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 border border-gray-200 dark:border-gray-700">
                {!! nl2br(e($page->getTranslation('content', app()->getLocale()))) !!}
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>