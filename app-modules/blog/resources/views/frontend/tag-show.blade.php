<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ $tag->name }} - {{ __('messages.blog_tags') }}</x-slot>
    <x-slot name="description">{{ __('messages.posts_tagged_with') }} {{ $tag->name }}</x-slot>

    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="hero-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-white/80">
                        <li>
                            <a href="{{ route('blog::blog.index') }}" class="hover:text-white transition-colors">
                                {{ __('messages.blog') }}
                            </a>
                        </li>
                        <li class="text-white/60">/</li>
                        <li>
                            <a href="{{ route('blog::blog.tags') }}" class="hover:text-white transition-colors">
                                {{ __('messages.tags') }}
                            </a>
                        </li>
                        <li class="text-white/60">/</li>
                        <li class="text-white">{{ $tag->getTranslation('name', app()->getLocale()) }}</li>
                    </ol>
                </nav>

                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $tag->getTranslation('name', app()->getLocale()) }}</h1>
                    <p class="text-xl text-white/90">
                        {{ $blogs->total() }} {{ $blogs->total() === 1 ? __('messages.post') : __('messages.posts') }} {{ __('messages.tagged_with') }} "{{ $tag->getTranslation('name', app()->getLocale()) }}"
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
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
                                                @foreach($blog->tags->take(3) as $blogTag)
                                                    <a href="{{ route('blog::blog.tags.show', $blogTag->slug) }}" 
                                                       class="text-eco-green dark:text-eco-green hover:underline {{ $blogTag->id === $tag->id ? 'font-semibold' : '' }}">
                                                        {{ $blogTag->getTranslation('name', app()->getLocale()) }}{{ !$loop->last ? ',' : '' }}
                                                    </a>
                                                @endforeach
                                                @if($blog->tags->count() > 3)
                                                    <span class="text-gray-400">+{{ $blog->tags->count() - 3 }}</span>
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
                    {{ $blogs->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.no_posts_for_tag') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('messages.no_posts_for_tag_description', ['tag' => $tag->getTranslation('name', app()->getLocale())]) }}</p>
                    <a href="{{ route('blog::blog.index') }}" 
                       class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                        {{ __('messages.explore_all_posts') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endif

            <!-- Navigation -->
            <div class="mt-12 flex justify-center space-x-6">
                <a href="{{ route('blog::blog.tags') }}" 
                   class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.all_tags') }}
                </a>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <a href="{{ route('blog::blog.index') }}" 
                   class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                    {{ __('messages.all_posts') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>