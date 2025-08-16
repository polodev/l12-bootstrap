<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.blog_tags') }}</x-slot>
    <x-slot name="description">{{ __('messages.explore_topics_description') }}</x-slot>

    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="hero-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ __('messages.blog_tags') }}</h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto">
                        {{ __('messages.explore_topics_description') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if($tags->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($tags as $tag)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <a href="{{ route('blog::blog.tags.show', $tag->slug) }}" class="block">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2 hover:text-eco-green dark:hover:text-eco-green transition-colors">
                                    {{ $tag->getTranslation('name', app()->getLocale()) }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                    {{ $tag->blogs_count }} {{ $tag->blogs_count === 1 ? __('messages.post') : __('messages.posts') }}
                                </p>
                                <div class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium text-sm">
                                    {{ __('messages.view_posts') }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.no_tags') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_tags_description') }}</p>
                </div>
            @endif

            <!-- Back to Blog -->
            <div class="mt-12 text-center">
                <a href="{{ route('blog::blog.index') }}" 
                   class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.back_to_blog') }}
                </a>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>