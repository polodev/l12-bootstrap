<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.blog') }}</x-slot>
    <x-slot name="description">{{ __('messages.blog_subtitle') }}</x-slot>

    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="hero-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ __('messages.blog') }}</h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto">
                        {{ __('messages.blog_subtitle') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Blog Posts -->
                <div class="lg:col-span-3">
                    @if($blogs->count() > 0)
                        <div class="grid gap-8">
                            @foreach($blogs as $blog)
                                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                    <div class="md:flex">
                                        @if($blog->featured_image)
                                            <div class="md:w-1/3">
                                                <img src="{{ $blog->featured_image }}" 
                                                     alt="{{ $blog->getTranslation('title', app()->getLocale()) }}"
                                                     class="w-full h-48 md:h-full object-cover">
                                            </div>
                                        @endif
                                        
                                        <div class="p-6 {{ $blog->featured_image ? 'md:w-2/3' : 'w-full' }}">
                                            <!-- Meta Info -->
                                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-3">
                                                <span>{{ $blog->published_at->format('F d, Y') }}</span>
                                                @if($blog->tags->isNotEmpty())
                                                    <span>•</span>
                                                    <div class="flex space-x-1">
                                                        @foreach($blog->tags->take(2) as $tag)
                                                            <a href="{{ route('blog::blog.tags.show', $tag->slug) }}" 
                                                               class="text-eco-green dark:text-eco-green hover:underline">
                                                                {{ $tag->getTranslation('name', app()->getLocale()) }}{{ !$loop->last ? ',' : '' }}
                                                            </a>
                                                        @endforeach
                                                        @if($blog->tags->count() > 2)
                                                            <span class="text-gray-400">+{{ $blog->tags->count() - 2 }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Title -->
                                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                                                <a href="{{ route('blog::blog.show', $blog->slug) }}" 
                                                   class="hover:text-eco-green dark:hover:text-eco-green transition-colors">
                                                    {{ $blog->getTranslation('title', app()->getLocale()) }}
                                                </a>
                                            </h2>

                                            <!-- Excerpt -->
                                            @if($blog->getTranslation('excerpt', app()->getLocale()))
                                                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                                    {{ Str::limit($blog->getTranslation('excerpt', app()->getLocale()), 150) }}
                                                </p>
                                            @else
                                                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                                    {{ Str::limit(strip_tags($blog->getTranslation('content', app()->getLocale())), 150) }}
                                                </p>
                                            @endif

                                            <!-- Read More -->
                                            <a href="{{ route('blog::blog.show', $blog->slug) }}" 
                                               class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                                                {{ __('messages.read_more') }}
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $blogs->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.no_blog_posts') }}</h3>
                            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_blog_posts_description') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-8">
                        <!-- Tags -->
                        @if($tags->isNotEmpty())
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.popular_tags') }}</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tags as $tag)
                                        <a href="{{ route('blog::blog.tags.show', $tag->slug) }}" 
                                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 hover:bg-eco-green/10 hover:text-eco-green dark:hover:bg-eco-green/20 dark:hover:text-eco-green transition-colors">
                                            {{ $tag->getTranslation('name', app()->getLocale()) }}
                                            <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">({{ $tag->blogs_count }})</span>
                                        </a>
                                    @endforeach
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('blog::blog.tags') }}" 
                                       class="text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark text-sm font-medium">
                                        {{ __('messages.view_all_tags') }} →
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Archive (Future Enhancement) -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.stay_updated') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('messages.stay_updated_description') }}</p>
                            <a href="{{ route('blog::blog.tags') }}" 
                               class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium text-sm">
                                {{ __('messages.explore_topics') }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>