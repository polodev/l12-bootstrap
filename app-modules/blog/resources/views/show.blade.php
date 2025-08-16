<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $blog->getTranslation('title', 'en') }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Status: {!! $blog->status_badge !!}
                        @if($blog->published_at)
                            • Published: {{ $blog->published_at->format('M d, Y H:i') }}
                        @endif
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    @if($blog->isLive())
                        <a href="{{ route('blog::blog.show', $blog->slug) }}" 
                           target="_blank"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View on Website
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                            Not Published
                        </span>
                    @endif
                    <a href="{{ route('blog::admin.blog.edit', $blog->slug) }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('blog::admin.blog.index') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <!-- English Title -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">English Title</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $blog->english_title }}</p>
                        </div>

                        <!-- Slug -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">Slug</h3>
                            <p class="text-gray-600 dark:text-gray-400 font-mono text-sm bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $blog->slug }}</p>
                        </div>

                        <!-- Translatable Titles -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-3">Titles</h3>
                            <div class="space-y-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">English</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $blog->getTranslation('title', 'en') ?: 'Not provided' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Bengali</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $blog->getTranslation('title', 'bn') ?: 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Excerpts -->
                        @if($blog->getTranslation('excerpt', 'en') || $blog->getTranslation('excerpt', 'bn'))
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-3">Excerpts</h3>
                            <div class="space-y-3">
                                @if($blog->getTranslation('excerpt', 'en'))
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">English</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $blog->getTranslation('excerpt', 'en') }}</p>
                                </div>
                                @endif
                                @if($blog->getTranslation('excerpt', 'bn'))
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Bengali</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $blog->getTranslation('excerpt', 'bn') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="space-y-6">
                    <!-- Meta Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status:</span>
                                <div class="mt-1">{!! $blog->status_badge !!}</div>
                            </div>
                            @if($blog->published_at)
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Published:</span>
                                <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">{{ $blog->published_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            @endif
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Created:</span>
                                <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">{{ $blog->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Updated:</span>
                                <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">{{ $blog->updated_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Position:</span>
                                <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">{{ $blog->position }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($blog->tags->count() > 0)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($blog->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- SEO Meta Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">SEO Information</h3>
                        <div class="space-y-4">
                            <!-- Meta Titles -->
                            @if($blog->getTranslation('meta_title', 'en') || $blog->getTranslation('meta_title', 'bn'))
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Meta Title:</span>
                                <div class="mt-2 space-y-2">
                                    @if($blog->getTranslation('meta_title', 'en'))
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">EN:</span>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $blog->getTranslation('meta_title', 'en') }}</p>
                                    </div>
                                    @endif
                                    @if($blog->getTranslation('meta_title', 'bn'))
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">BN:</span>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $blog->getTranslation('meta_title', 'bn') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Meta Descriptions -->
                            @if($blog->getTranslation('meta_description', 'en') || $blog->getTranslation('meta_description', 'bn'))
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Meta Description:</span>
                                <div class="mt-2 space-y-2">
                                    @if($blog->getTranslation('meta_description', 'en'))
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">EN:</span>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $blog->getTranslation('meta_description', 'en') }}</p>
                                    </div>
                                    @endif
                                    @if($blog->getTranslation('meta_description', 'bn'))
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">BN:</span>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $blog->getTranslation('meta_description', 'bn') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Meta Keywords -->
                            @if($blog->getTranslation('meta_keywords', 'en') || $blog->getTranslation('meta_keywords', 'bn'))
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Meta Keywords:</span>
                                <div class="mt-2 space-y-2">
                                    @if($blog->getTranslation('meta_keywords', 'en'))
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">EN:</span>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $blog->getTranslation('meta_keywords', 'en') }}</p>
                                    </div>
                                    @endif
                                    @if($blog->getTranslation('meta_keywords', 'bn'))
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">BN:</span>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $blog->getTranslation('meta_keywords', 'bn') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Canonical URL -->
                            @if($blog->canonical_url)
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Canonical URL:</span>
                                <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">
                                    <a href="{{ $blog->canonical_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $blog->canonical_url }}</a>
                                </p>
                            </div>
                            @endif

                            <!-- SEO Directives -->
                            @if($blog->noindex || $blog->nofollow)
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">SEO Directives:</span>
                                <div class="mt-1 flex gap-2">
                                    @if($blog->noindex)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                        No Index
                                    </span>
                                    @endif
                                    @if($blog->nofollow)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                        No Follow
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Default message if no SEO data -->
                            @if(!$blog->getTranslation('meta_title', 'en') && !$blog->getTranslation('meta_title', 'bn') && 
                                !$blog->getTranslation('meta_description', 'en') && !$blog->getTranslation('meta_description', 'bn') && 
                                !$blog->getTranslation('meta_keywords', 'en') && !$blog->getTranslation('meta_keywords', 'bn') && 
                                !$blog->canonical_url && !$blog->noindex && !$blog->nofollow)
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No SEO information provided. <a href="{{ route('blog::admin.blog.edit', $blog->slug) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit this blog</a> to add SEO metadata.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if($blog->featured_image)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Featured Image</h3>
                        <img src="{{ $blog->featured_image }}" alt="Featured Image" class="w-full rounded-lg shadow-sm">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 break-all">{{ $blog->featured_image }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Content Tabs -->
            <div>
                <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button type="button" 
                                class="content-tab active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                data-lang="en">
                            English Content
                        </button>
                        <button type="button" 
                                class="content-tab whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                data-lang="bn">
                            Bengali Content
                        </button>
                    </nav>
                </div>

                <!-- English Content -->
                <div id="content-en" class="content-panel">
                    @if($blog->getTranslation('content', 'en'))
                        <article class="prose prose-base sm:prose-lg max-w-none dark:prose-invert prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-gray-100 prose-code:text-red-600 dark:prose-code:text-red-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm prose-pre:bg-gray-50 dark:prose-pre:bg-gray-900 prose-pre:border prose-pre:border-gray-200 dark:prose-pre:border-gray-700 prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:pl-6 prose-blockquote:py-4 prose-blockquote:rounded-r prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg prose-img:shadow-lg" id="blog-content-en">
                            {!! Str::markdown($blog->getTranslation('content', 'en')) !!}
                        </article>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No English content</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">English content has not been provided for this blog post.</p>
                        </div>
                    @endif
                </div>

                <!-- Bengali Content -->
                <div id="content-bn" class="content-panel hidden">
                    @if($blog->getTranslation('content', 'bn'))
                        <article class="prose prose-base sm:prose-lg max-w-none dark:prose-invert prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-gray-100 prose-code:text-red-600 dark:prose-code:text-red-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm prose-pre:bg-gray-50 dark:prose-pre:bg-gray-900 prose-pre:border prose-pre:border-gray-200 dark:prose-pre:border-gray-700 prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:pl-6 prose-blockquote:py-4 prose-blockquote:rounded-r prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg prose-img:shadow-lg" id="blog-content-bn">
                            {!! Str::markdown($blog->getTranslation('content', 'bn')) !!}
                        </article>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No Bengali content</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Bengali content has not been provided for this blog post.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css" media="(prefers-color-scheme: light)">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css" media="(prefers-color-scheme: dark)">
    <style>
        .content-tab.active {
            @apply border-blue-500 text-blue-600;
        }
        .dark .content-tab.active {
            @apply border-blue-400 text-blue-400;
        }
        
        /* Enhanced prose styles for beautiful documentation */
        .prose {
            line-height: 1.75;
            font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
        }
        
        /* Heading improvements */
        .prose h1 {
            font-size: 2.25rem;
            line-height: 1.2;
            margin-top: 0;
            margin-bottom: 2rem;
            color: rgb(17 24 39);
            border-bottom: 3px solid rgb(59 130 246);
            padding-bottom: 0.5rem;
        }
        .dark .prose h1 {
            color: rgb(243 244 246);
            border-bottom-color: rgb(96 165 250);
        }
        
        .prose h2 {
            font-size: 1.875rem;
            line-height: 1.3;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: rgb(31 41 55);
            position: relative;
        }
        .dark .prose h2 {
            color: rgb(229 231 235);
        }
        
        .prose h3 {
            font-size: 1.5rem;
            line-height: 1.4;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            color: rgb(55 65 81);
        }
        .dark .prose h3 {
            color: rgb(209 213 219);
        }
        
        /* List improvements */
        .prose ul, .prose ol {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            padding-left: 1.75rem;
        }
        
        .prose li {
            margin-top: 0.75rem;
            margin-bottom: 0.75rem;
            line-height: 1.7;
        }
        
        .prose li::marker {
            color: rgb(59 130 246);
            font-weight: 600;
        }
        .dark .prose li::marker {
            color: rgb(96 165 250);
        }
        
        /* Code block improvements */
        .prose pre {
            position: relative;
            overflow-x: auto;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: 2rem 0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-color: rgb(248 250 252) !important;
            border: 1px solid rgb(226 232 240);
        }
        
        .dark .prose pre {
            background-color: rgb(15 23 42) !important;
            border-color: rgb(51 65 85);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        
        .prose pre code {
            background: transparent !important;
            padding: 0 !important;
            border-radius: 0 !important;
            font-size: 0.875rem;
            line-height: 1.6;
            color: inherit !important;
        }
        
        /* Override highlight.js theme for better dark mode */
        .dark .prose pre code .hljs-keyword,
        .dark .prose pre code .hljs-selector-tag,
        .dark .prose pre code .hljs-built_in {
            color: rgb(96 165 250) !important;
        }
        
        .dark .prose pre code .hljs-string,
        .dark .prose pre code .hljs-attr {
            color: rgb(34 197 94) !important;
        }
        
        .dark .prose pre code .hljs-number,
        .dark .prose pre code .hljs-literal {
            color: rgb(251 146 60) !important;
        }
        
        .dark .prose pre code .hljs-comment {
            color: rgb(148 163 184) !important;
            font-style: italic;
        }
        
        .dark .prose pre code .hljs-title,
        .dark .prose pre code .hljs-function {
            color: rgb(236 72 153) !important;
        }
        
        /* Table improvements */
        .prose table {
            margin: 2rem 0;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .prose th {
            background: linear-gradient(135deg, rgb(59 130 246) 0%, rgb(37 99 235) 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.875rem;
        }
        
        .prose tbody tr:nth-child(even) {
            background-color: rgb(249 250 251);
        }
        .dark .prose tbody tr:nth-child(even) {
            background-color: rgb(31 41 55);
        }
        
        /* Blockquote enhancements */
        .prose blockquote {
            font-style: italic;
            position: relative;
            margin: 2rem 0;
        }
        
        .prose blockquote::before {
            content: '"';
            font-size: 4rem;
            position: absolute;
            left: -0.5rem;
            top: -1rem;
            color: rgb(59 130 246);
            opacity: 0.3;
            font-family: Georgia, serif;
        }
        
        /* Link improvements */
        .prose a {
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .prose a:hover {
            color: rgb(37 99 235);
            transform: translateY(-1px);
        }
        .dark .prose a:hover {
            color: rgb(147 197 253);
        }
        
        /* Image improvements */
        .prose img {
            margin: 2rem auto;
            max-width: 100%;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Copy button styling */
        .group:hover .copy-btn {
            opacity: 1;
        }
        
        .copy-btn {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            cursor: pointer;
            opacity: 0;
            transition: all 0.2s ease;
            z-index: 10;
        }
        
        .copy-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.05);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configure marked for better rendering
            marked.setOptions({
                highlight: function(code, lang) {
                    if (lang && hljs.getLanguage(lang)) {
                        try {
                            return hljs.highlight(code, { language: lang }).value;
                        } catch (err) {}
                    }
                    return hljs.highlightAuto(code).value;
                },
                breaks: true,
                gfm: true,
            });

            // Convert markdown content to HTML for both languages
            const contentElementEn = document.getElementById('blog-content-en');
            const contentElementBn = document.getElementById('blog-content-bn');
            
            if (contentElementEn) {
                const rawContentEn = {!! json_encode($blog->getTranslation('content', 'en')) !!};
                
                // Check if content appears to be markdown
                if (rawContentEn && (rawContentEn.includes('#') || rawContentEn.includes('```') || rawContentEn.includes('*') || rawContentEn.includes('[') || rawContentEn.includes('|'))) {
                    contentElementEn.innerHTML = marked.parse(rawContentEn);
                }
            }
            
            if (contentElementBn) {
                const rawContentBn = {!! json_encode($blog->getTranslation('content', 'bn')) !!};
                
                // Check if content appears to be markdown
                if (rawContentBn && (rawContentBn.includes('#') || rawContentBn.includes('```') || rawContentBn.includes('*') || rawContentBn.includes('[') || rawContentBn.includes('|'))) {
                    contentElementBn.innerHTML = marked.parse(rawContentBn);
                }
            }
            
            // Function to update highlight.js theme based on current theme
            function updateHighlightTheme() {
                const isDark = document.documentElement.classList.contains('dark') || 
                              (localStorage.getItem('appearance') === 'dark') ||
                              (localStorage.getItem('appearance') === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                // Remove existing highlight.js stylesheets
                document.querySelectorAll('link[href*="highlight.js"]').forEach(link => link.remove());
                
                // Add appropriate theme
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = isDark 
                    ? 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css'
                    : 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css';
                document.head.appendChild(link);
                
                // Re-highlight after theme change
                setTimeout(() => hljs.highlightAll(), 100);
            }
            
            // Initial theme setup and highlighting
            updateHighlightTheme();
            
            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        updateHighlightTheme();
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            
            // Add copy buttons to code blocks
            function addCopyButtons() {
                document.querySelectorAll('pre code').forEach((block) => {
                    // Skip if copy button already exists
                    if (block.parentNode.querySelector('.copy-btn')) {
                        return;
                    }
                    
                    // Create copy button
                    const button = document.createElement('button');
                    button.className = 'copy-btn';
                    button.textContent = 'Copy';
                    
                    // Wrap pre in relative container
                    const pre = block.parentNode;
                    pre.style.position = 'relative';
                    pre.className += ' group';
                    pre.appendChild(button);
                    
                    // Add click handler
                    button.addEventListener('click', async () => {
                        try {
                            // Try modern clipboard API first
                            if (navigator.clipboard && window.isSecureContext) {
                                await navigator.clipboard.writeText(block.textContent);
                            } else {
                                // Fallback to legacy method
                                const textArea = document.createElement('textarea');
                                textArea.value = block.textContent;
                                textArea.style.position = 'fixed';
                                textArea.style.left = '-999999px';
                                textArea.style.top = '-999999px';
                                document.body.appendChild(textArea);
                                textArea.focus();
                                textArea.select();
                                
                                const successful = document.execCommand('copy');
                                document.body.removeChild(textArea);
                                
                                if (!successful) {
                                    throw new Error('execCommand failed');
                                }
                            }
                            
                            button.textContent = 'Copied!';
                            button.style.backgroundColor = 'rgba(34, 197, 94, 0.8)';
                            setTimeout(() => {
                                button.textContent = 'Copy';
                                button.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                            }, 2000);
                        } catch (err) {
                            console.error('Copy failed:', err);
                            button.textContent = 'Failed';
                            button.style.backgroundColor = 'rgba(239, 68, 68, 0.8)';
                            setTimeout(() => {
                                button.textContent = 'Copy';
                                button.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                            }, 2000);
                        }
                    });
                });
            }
            
            // Add copy buttons initially and after content changes
            addCopyButtons();
            
            // Content tab functionality
            const contentTabs = document.querySelectorAll('.content-tab');
            const contentPanels = document.querySelectorAll('.content-panel');

            contentTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetLang = this.dataset.lang;
                    
                    // Update tab states
                    contentTabs.forEach(t => {
                        t.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    });
                    
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    this.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                    
                    // Update content visibility
                    contentPanels.forEach(panel => {
                        if (panel.id === `content-${targetLang}`) {
                            panel.classList.remove('hidden');
                        } else {
                            panel.classList.add('hidden');
                        }
                    });
                    
                    // Re-add copy buttons for newly visible content
                    setTimeout(addCopyButtons, 100);
                });
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>